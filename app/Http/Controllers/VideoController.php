<?php

namespace App\Http\Controllers;

use App\Jobs\DownloadMediaJob;
use App\Jobs\MergeMediaJob;
use App\Jobs\GenerateHlsJob;
use App\Models\MediaDownload;
use App\Services\CacheService;
use App\Services\FFmpegService;
use App\Services\MediaExtractorService;
use App\Services\PlatformDetector;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class VideoController extends Controller
{
    /*
    |----------------------------------------------------------------------
    | PRODUCTION-GRADE MEDIA DOWNLOADER CONTROLLER
    |----------------------------------------------------------------------
    |
    | ARCHITECTURE:
    |   - CacheService:          Redis + MySQL dual-layer cache
    |   - MediaExtractorService: yt-dlp CLI (--dump-single-json, fastest)
    |   - FFmpegService:         Merge + HLS (-c copy, no re-encode)
    |   - PlatformDetector:      URL → platform + media ID
    |   - Queue Jobs:            Downloads, merges, HLS in background
    |
    | LOAD ANALYSIS:
    |   /extract        → Cached <1ms (Redis). Uncached ~2-3s (yt-dlp).
    |   /direct-download → ZERO server load (302 redirect to CDN).
    |   /proxy-download  → Streaming proxy with CDN auth headers.
    |   /merge-download  → FFmpeg -c copy streaming (no re-encode).
    |   /download-status → Check background download progress.
    |   /stream          → HLS .m3u8 streaming endpoint.
    |   /thumbnail-proxy → Browser-cached 1 hour.
    |----------------------------------------------------------------------
    */

    /** @var CacheService */
    private $cacheService;

    /** @var MediaExtractorService */
    private $extractorService;

    /** @var FFmpegService */
    private $ffmpegService;

    public function __construct()
    {
        $this->cacheService     = new CacheService();
        $this->extractorService = new MediaExtractorService();
        $this->ffmpegService    = new FFmpegService();
    }

    /* ================================================================== */
    /*  EXTRACT — Core metadata extraction                                */
    /* ================================================================== */

    /**
     * Extract video info from any supported URL.
     *
     * PERFORMANCE:
     *   - Redis HIT:  <1ms response
     *   - MySQL HIT:  ~5ms response (warms Redis)
     *   - Full miss:  ~2-3s (yt-dlp CLI)
     *
     * POST /extract
     */
    public function extract(Request $request)
    {
        // Release session lock for concurrent requests
        if (session()->isStarted()) session()->save();

        $url = trim($request->input('url', ''));
        if (!$url) {
            return response()->json(['error' => 'URL is required'], 400);
        }

        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            return response()->json(['error' => 'Invalid URL format'], 400);
        }

        // ── Detect platform + media ID ──────────────────────────────────
        $detected = PlatformDetector::detect($url);
        $platform = $detected['platform'];
        $mediaId  = $detected['id'];

        // ── Check dual-layer cache (Redis → MySQL) ──────────────────────
        $cached = $this->cacheService->get($platform, $mediaId);
        if ($cached) {
            $this->logEvent('extraction', $url, 'MP4', '—', true, $cached['title'] ?? null);
            return response()->json($cached)
                ->header('X-Cache', 'HIT')
                ->header('X-Platform', $platform)
                ->header('X-Media-ID', $mediaId);
        }

        // ── Extract via yt-dlp (CLI primary, Python fallback) ───────────
        try {
            $data = $this->extractorService->extract($url);
        } catch (\Throwable $e) {
            $this->logEvent('extraction', $url, 'MP4', '—', false);
            Log::error('Extraction failed', ['url' => $url, 'error' => $e->getMessage()]);
            return response()->json(['error' => 'Extraction failed: ' . $e->getMessage()], 500);
        }

        if (!$data || !empty($data['error'])) {
            $this->logEvent('extraction', $url, 'MP4', '—', false);
            return response()->json($data ?: ['error' => 'No data extracted'], 422);
        }

        // ── Store in dual-layer cache (Redis + MySQL) ───────────────────
        $this->cacheService->put($platform, $mediaId, $url, $data);

        // ── Log extraction ──────────────────────────────────────────────
        $this->logEvent('extraction', $url, 'MP4', '—', true, $data['title'] ?? null);

        return response()->json($data)
            ->header('X-Cache', 'MISS')
            ->header('X-Platform', $platform)
            ->header('X-Media-ID', $mediaId)
            ->header('X-Extraction-Ms', $data['extraction_ms'] ?? 0);
    }

    /* ================================================================== */
    /*  DIRECT DOWNLOAD — Zero server load                                */
    /* ================================================================== */

    /**
     * Redirect to CDN URL directly.
     * Server only sends a 302 — ZERO bandwidth used.
     *
     * GET /direct-download
     */
    public function directDownload(Request $request)
    {
        $url  = $request->query('url');
        $ext  = $request->query('ext', 'mp4');
        $qual = $request->query('quality', '—');
        $orig = $request->query('source_url', $url);

        if (!$url) return abort(400, 'URL parameter is required.');

        $this->logEvent('download', $orig ?: $url, $ext, $qual, true);

        return redirect()->away($url);
    }

    /* ================================================================== */
    /*  PROXY DOWNLOAD — Streaming with CDN auth headers                  */
    /* ================================================================== */

    /**
     * Stream file through server with proper Referer/UA headers.
     * Fallback when CDN rejects direct browser access.
     *
     * GET /proxy-download
     */
    public function proxyDownload(Request $request)
    {
        if (session()->isStarted()) session()->save();

        $url   = $request->query('url');
        $title = $request->query('title', 'video');
        $ext   = strtolower($request->query('ext', 'mp4'));
        $qual  = $request->query('quality', '—');
        $orig  = $request->query('source_url', '');

        if (!$url) return abort(400);

        $this->logEvent('download', $orig ?: $url, $ext, $qual, true, $title);

        // ── Platform detection for Referer ──────────────────────────────
        $detected = PlatformDetector::detect($orig ?: $url);
        $platform = $detected['platform'];
        $referer  = $detected['referer'];

        // Also check CDN host patterns
        if ($platform === 'Other') {
            $cdnDetected = PlatformDetector::detect($url);
            if ($cdnDetected['platform'] !== 'Other') {
                $platform = $cdnDetected['platform'];
                $referer  = $cdnDetected['referer'];
            }
        }

        // ── Validate CDN URL is alive (HEAD request) ────────────────────
        $check = curl_init($url);
        curl_setopt_array($check, [
            CURLOPT_NOBODY         => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_MAXREDIRS      => 5,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_TIMEOUT        => 10,
            CURLOPT_USERAGENT      => config('downloader.extraction.user_agent'),
            CURLOPT_HTTPHEADER     => ['Referer: ' . $referer],
        ]);
        curl_exec($check);
        $httpCode = (int) curl_getinfo($check, CURLINFO_HTTP_CODE);
        curl_close($check);

        if ($httpCode >= 400) {
            return response()->json([
                'error' => 'Download link has expired. Please extract the video again to get a fresh link.'
            ], 410);
        }

        // ── Stream response ─────────────────────────────────────────────
        $safeTitle = substr(preg_replace('/[^A-Za-z0-9\-_]/', '_', $title), 0, 80) ?: 'video';
        $filename  = $safeTitle . '.' . ($ext ?: 'mp4');

        return response()->streamDownload(function () use ($url, $referer) {
            // ── Kill ALL output buffering for maximum streaming speed ────
            while (ob_get_level() > 0) ob_end_flush();
            ob_implicit_flush(true);

            $ch = curl_init($url);
            curl_setopt_array($ch, [
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_MAXREDIRS      => 10,
                CURLOPT_RETURNTRANSFER => false,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_BUFFERSIZE     => 262144,  // 256KB buffer
                CURLOPT_TIMEOUT        => 0,
                CURLOPT_CONNECTTIMEOUT => 20,
                CURLOPT_LOW_SPEED_LIMIT=> 1000,    // abort if <1KB/s
                CURLOPT_LOW_SPEED_TIME => 30,      // for 30 seconds
                CURLOPT_USERAGENT      => config('downloader.extraction.user_agent'),
                CURLOPT_HTTPHEADER     => [
                    'Referer: ' . $referer,
                    'Accept: */*',
                    'Accept-Language: en-US,en;q=0.5',
                    'Connection: keep-alive',
                ],
                CURLOPT_WRITEFUNCTION  => function ($ch, $chunk) {
                    echo $chunk;
                    flush();
                    return strlen($chunk);
                },
            ]);
            curl_exec($ch);
            curl_close($ch);
        }, $filename, [
            'Content-Type'        => 'application/octet-stream',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Cache-Control'       => 'no-cache, no-store, must-revalidate',
            'X-Accel-Buffering'   => 'no',
        ]);
    }

    /* ================================================================== */
    /*  MERGE DOWNLOAD — FFmpeg streaming merge                           */
    /* ================================================================== */

    /**
     * Merge video+audio using FFmpeg and stream result.
     * Uses -c copy (no re-encoding) for maximum speed.
     *
     * GET /merge-download
     */
    public function mergeDownload(Request $request)
    {
        if (session()->isStarted()) session()->save();

        $vUrl  = $request->query('video_url');
        $aUrl  = $request->query('audio_url');
        $title = $request->query('title', 'video');
        $orig  = $request->query('source_url', $vUrl);

        if (!$vUrl) return abort(400);

        $this->logEvent('download', $orig ?: $vUrl, 'mp4', '1080p+', true, $title);

        // Get referer for CDN auth
        $detected  = PlatformDetector::detect($orig ?: $vUrl);
        $referer   = $detected['referer'];
        $userAgent = config('downloader.extraction.user_agent');

        $fileName = substr(preg_replace('/[^A-Za-z0-9\-_]/', '_', $title), 0, 80) . '.mp4';

        // Build ffmpeg command using FFmpegService
        $command = $this->ffmpegService->buildStreamMergeCommand($vUrl, $aUrl, $referer, $userAgent);

        return response()->streamDownload(function () use ($command) {
            // Kill all output buffering for instant streaming
            while (ob_get_level() > 0) ob_end_flush();
            ob_implicit_flush(true);

            $handle = popen($command, 'r');
            if ($handle) {
                while (!feof($handle)) {
                    $data = fread($handle, 262144); // 256KB chunks
                    if ($data !== false && $data !== '') {
                        echo $data;
                        flush();
                    }
                }
                pclose($handle);
            }
        }, $fileName, [
            'Content-Type'      => 'video/mp4',
            'X-Accel-Buffering' => 'no',
        ]);
    }

    /* ================================================================== */
    /*  BACKGROUND DOWNLOAD — Queue-based                                 */
    /* ================================================================== */

    /**
     * Queue a background download (aria2c + optional merge).
     *
     * POST /queue-download
     */
    public function queueDownload(Request $request)
    {
        $url      = $request->input('url');
        $audioUrl = $request->input('audio_url');
        $title    = $request->input('title', 'video');
        $quality  = $request->input('quality', 'best');
        $format   = $request->input('format', 'mp4');
        $orig     = $request->input('source_url', $url);

        if (!$url) return response()->json(['error' => 'URL is required'], 400);

        $detected = PlatformDetector::detect($orig ?: $url);

        // Create download record
        $download = MediaDownload::create([
            'url'        => $orig ?: $url,
            'platform'   => $detected['platform'],
            'format'     => $format,
            'quality'    => $quality,
            'status'     => MediaDownload::STATUS_PENDING,
            'title'      => $title,
            'ip_address' => $request->ip(),
        ]);

        $safeTitle = substr(preg_replace('/[^A-Za-z0-9\-_]/', '_', $title), 0, 80) ?: 'download';
        $filename  = $safeTitle . '_' . $download->id . '.' . $format;

        // Dispatch appropriate job
        if ($audioUrl) {
            MergeMediaJob::dispatch(
                $download->id,
                $url,
                $audioUrl,
                $filename,
                $detected['referer']
            );
        } else {
            DownloadMediaJob::dispatch(
                $download->id,
                $url,
                $filename,
                $detected['referer'],
                $detected['platform']
            );
        }

        return response()->json([
            'download_id' => $download->id,
            'status'      => 'queued',
            'message'     => 'Download queued successfully.',
        ]);
    }

    /* ================================================================== */
    /*  DOWNLOAD STATUS — Check progress                                  */
    /* ================================================================== */

    /**
     * Check the status of a queued download.
     *
     * GET /download-status/{id}
     */
    public function downloadStatus($id)
    {
        $download = MediaDownload::find($id);
        if (!$download) {
            return response()->json(['error' => 'Download not found'], 404);
        }

        $response = [
            'id'       => $download->id,
            'status'   => $download->status,
            'progress' => $download->progress,
            'format'   => $download->format,
            'quality'  => $download->quality,
        ];

        if ($download->status === MediaDownload::STATUS_COMPLETED) {
            $response['file_url']  = url('/download-file/' . $download->id);
            $response['file_size'] = $download->file_size;
        }

        if ($download->status === MediaDownload::STATUS_FAILED) {
            $response['error'] = $download->error_message;
        }

        return response()->json($response);
    }

    /* ================================================================== */
    /*  DOWNLOAD FILE — Serve completed download                          */
    /* ================================================================== */

    /**
     * Serve a completed download file.
     *
     * GET /download-file/{id}
     */
    public function downloadFile($id)
    {
        $download = MediaDownload::find($id);
        if (!$download || $download->status !== MediaDownload::STATUS_COMPLETED) {
            return abort(404, 'File not ready or not found.');
        }

        if (!$download->file_path || !file_exists($download->file_path)) {
            return abort(410, 'File has been cleaned up.');
        }

        $filename = substr(preg_replace('/[^A-Za-z0-9\-_.]/', '_', $download->title ?: 'download'), 0, 80)
            . '.' . ($download->format ?: 'mp4');

        return response()->download($download->file_path, $filename, [
            'Content-Type' => 'application/octet-stream',
        ]);
    }

    /* ================================================================== */
    /*  HLS STREAMING                                                     */
    /* ================================================================== */

    /**
     * Stream HLS playlist.
     *
     * GET /stream/{mediaId}
     */
    public function stream($mediaId)
    {
        $hlsDir = config('downloader.hls_dir', storage_path('app/hls'));
        $playlistPath = $hlsDir . '/' . $mediaId . '/playlist.m3u8';

        if (!file_exists($playlistPath)) {
            return response()->json([
                'error'  => 'Stream not ready. Please request generation first.',
                'status' => 'not_found',
            ], 404);
        }

        return response()->file($playlistPath, [
            'Content-Type'                => 'application/vnd.apple.mpegurl',
            'Cache-Control'               => 'public, max-age=3600',
            'Access-Control-Allow-Origin' => '*',
        ]);
    }

    /**
     * Serve HLS segment (.ts file).
     *
     * GET /stream/{mediaId}/{segment}
     */
    public function streamSegment($mediaId, $segment)
    {
        // Sanitize to prevent path traversal
        $safeMediaId = preg_replace('/[^A-Za-z0-9_\-]/', '', $mediaId);
        $safeSegment = preg_replace('/[^A-Za-z0-9_\-.]/', '', $segment);

        $hlsDir  = config('downloader.hls_dir', storage_path('app/hls'));
        $segPath = $hlsDir . '/' . $safeMediaId . '/' . $safeSegment;

        if (!file_exists($segPath)) {
            return abort(404);
        }

        return response()->file($segPath, [
            'Content-Type'                => 'video/MP2T',
            'Cache-Control'               => 'public, max-age=86400',
            'Access-Control-Allow-Origin' => '*',
        ]);
    }

    /* ================================================================== */
    /*  THUMBNAIL PROXY                                                   */
    /* ================================================================== */

    /**
     * Proxy thumbnail with browser caching.
     *
     * GET /thumbnail-proxy
     */
    public function proxyThumbnail(Request $request)
    {
        $url = $request->query('url');
        if (!$url) return abort(404);

        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_TIMEOUT        => 10,
            CURLOPT_USERAGENT      => 'Mozilla/5.0',
        ]);
        $data = curl_exec($ch);
        $type = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
        curl_close($ch);

        return response($data)
            ->header('Content-Type', $type ?: 'image/jpeg')
            ->header('Cache-Control', 'public, max-age=3600')
            ->header('Expires', gmdate('D, d M Y H:i:s', time() + 3600) . ' GMT');
    }

    /* ================================================================== */
    /*  PRIVATE HELPERS                                                   */
    /* ================================================================== */

    /**
     * Log an extraction or download event.
     */
    private function logEvent($type, $url, $format = 'MP4', $quality = '—', $status = true, $title = null, $ip = null)
    {
        try {
            DB::table('download_logs')->insert([
                'type'       => $type,
                'platform'   => PlatformDetector::platformName($url),
                'format'     => strtoupper($format),
                'quality'    => $quality,
                'ip_address' => $ip ?? request()->ip(),
                'status'     => $status,
                'title'      => $title ? substr($title, 0, 255) : null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } catch (\Throwable $e) {
            // Never let logging crash the main request
        }
    }
}
