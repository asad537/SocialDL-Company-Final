<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PlatformDetector;
use App\Models\MediaDownload;
use App\Jobs\DownloadMediaJob;
use App\Jobs\MergeMediaJob;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\StreamedResponse;

class VideoController extends Controller
{
    public function extract(Request $request)
    {
        $request->validate(['url' => 'required|url']);
        $url = $request->input('url');

        try {
            $service = new \App\Services\MediaExtractorService();
            $data = $service->extract($url);
            
            return response()->json($data);
        } catch (\Exception $e) {
            Log::error('Extraction Error: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function directDownload(Request $request)
    {
        $url = $request->query('url');
        if (!$url) return abort(400);

        $title = $request->query('title', 'video');
        $ext = $request->query('ext', 'mp4');
        $quality = $request->query('quality', 'HD');
        $sourceUrl = $request->query('source_url', $url);

        $this->logEvent('download', $sourceUrl, $ext, $quality, true, $title);

        return redirect()->away($url);
    }

    public function proxyDownload(Request $request)
    {
        if (session()->isStarted()) session()->save();

        $url = $request->query('url');
        $title = $request->query('title', 'video');
        $ext = $request->query('ext', 'mp4');
        $sourceUrl = $request->query('source_url', $url);
        $cookies = $request->query('cookies');

        if (!$url) return abort(400);

        $proxySession = null;
        if (preg_match('/[?&]proxy_session=([a-zA-Z0-9]+)/', $url, $matches)) {
            $proxySession = $matches[1];
            $url = preg_replace('/([?&])proxy_session=[a-zA-Z0-9]+&?/', '$1', $url);
            $url = rtrim($url, '?&');
        }

        $this->logEvent('download', $sourceUrl, $ext, 'HD', true, $title);

        $detected = PlatformDetector::detect($sourceUrl);
        $referer = $request->query('referer') ?: $detected['referer'];
        $userAgent = $request->query('user_agent') ?: config('downloader.extraction.user_agent', 'Mozilla/5.0');
        $filename = substr(preg_replace('/[^A-Za-z0-9\-_]/', '_', $title), 0, 80) . '.' . $ext;
        $proxy = null;
        if ($proxySession) {
            $baseProxy = config('downloader.ytdlp_proxy');
            if ($baseProxy) {
                $proxy = \App\Services\MediaExtractorService::getStickyProxy($baseProxy, $proxySession);
            }
        } else {
            $baseProxy = config('downloader.ytdlp_proxy');
            if ($baseProxy) {
                $platform = PlatformDetector::platformName($sourceUrl);
                if (in_array($platform, ['TikTok', 'Instagram', 'Facebook', 'Snapchat', 'LinkedIn'])) {
                    $randSession = substr(md5(uniqid(microtime(), true)), 0, 8);
                    $proxy = \App\Services\MediaExtractorService::getStickyProxy($baseProxy, $randSession);
                }
            }
        }

        // Resolve Content-Type
        $contentType = 'application/octet-stream';
        if ($ext === 'mp4') $contentType = 'video/mp4';
        elseif ($ext === 'mp3') $contentType = 'audio/mpeg';
        elseif ($ext === 'webm') $contentType = 'video/webm';

        return new StreamedResponse(function () use ($url, $referer, $userAgent, $proxy, $cookies) {
            // Clear PHP output buffers for instant streaming
            while (ob_get_level()) { ob_end_clean(); }
            ob_implicit_flush(true);

            $headers = [
                'Referer: ' . $referer,
                'User-Agent: ' . $userAgent,
                'Accept: */*',
                'Connection: keep-alive',
            ];

            $ch = curl_init($url);
            $options = [
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_MAXREDIRS      => 10,
                CURLOPT_RETURNTRANSFER => false,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_BUFFERSIZE     => 262144, // 256KB for max throughput
                CURLOPT_TIMEOUT        => 0,
                CURLOPT_CONNECTTIMEOUT => 20,
                CURLOPT_HTTPHEADER     => $headers,
                CURLOPT_WRITEFUNCTION  => function ($ch, $chunk) {
                    echo $chunk;
                    flush();
                    return strlen($chunk);
                },
            ];

            if ($proxy) {
                $options[CURLOPT_PROXY] = $proxy;
            }

            if ($cookies) {
                $options[CURLOPT_COOKIE] = $cookies;
            }

            curl_setopt_array($ch, $options);
            $execResult = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $curlError = curl_error($ch);
            curl_close($ch);

            if ($execResult === false || $httpCode >= 400) {
                Log::error("proxyDownload Failed: URL={$url} | HTTP_CODE={$httpCode} | CURL_ERROR={$curlError} | PROXY=" . ($proxy ?: 'NONE'));
            }
        }, 200, [
            'Content-Type'        => $contentType,
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Cache-Control'       => 'no-cache',
            'X-Accel-Buffering'   => 'no',
        ]);
    }

    public function mergeDownload(Request $request)
    {
        if (session()->isStarted()) session()->save();

        $vUrl   = $request->query('video_url');
        $aUrl   = $request->query('audio_url');
        $title  = $request->query('title', 'video');
        $orig   = $request->query('source_url', $vUrl);
        $vcodec = strtolower($request->query('vcodec', '')); // e.g. 'vp9', 'av01', 'avc1'
        $height = (int) $request->query('height', 0);        // source video height in pixels
        $cookies = $request->query('cookies');
        $formatId = $request->query('format_id');

        if (!$vUrl) return abort(400);

        $this->logEvent('download', $orig ?: $vUrl, 'mp4', '1080p+', true, $title);

        $detected  = PlatformDetector::detect($orig ?: $vUrl);
        $referer   = $request->query('referer') ?: $detected['referer'];
        $userAgent = $request->query('user_agent') ?: config('downloader.extraction.user_agent', 'Mozilla/5.0');
        $filename  = substr(preg_replace('/[^A-Za-z0-9\-_]/', '_', $title), 0, 80) . '.mp4';

        // ── Proxy Decision ────────────────────────────────────────────────
        // YouTube CDN URLs are signed/served based on the extracting IP.
        // If direct extraction (no proxy), download directly.
        // If proxy extraction (fallback), route through the corresponding sticky proxy.
        $proxy = null;
        $proxySession = null;
        if (preg_match('/[?&]proxy_session=([a-zA-Z0-9]+)/', $vUrl, $matches)) {
            $proxySession = $matches[1];
            $baseProxy = config('downloader.ytdlp_proxy');
            if ($baseProxy) {
                $proxy = \App\Services\MediaExtractorService::getStickyProxy($baseProxy, $proxySession);
            }
        } else {
            $baseProxy = config('downloader.ytdlp_proxy');
            if ($baseProxy) {
                $platform = PlatformDetector::platformName($orig ?: $vUrl);
                if (in_array($platform, ['TikTok', 'Instagram', 'Facebook', 'Snapchat', 'LinkedIn'])) {
                    $randSession = substr(md5(uniqid(microtime(), true)), 0, 8);
                    $proxy = \App\Services\MediaExtractorService::getStickyProxy($baseProxy, $randSession);
                }
            }
        }

        // TikTok / Snapchat / Direct MP4: stream directly using yt-dlp to avoid blocks and improve speed
        // M3U8 / MPD must use FFmpeg to remux into playable MP4 container
        $platform = $detected['platform'];
        if (!$aUrl && strpos($vUrl, '.m3u8') === false && strpos($vUrl, '.mpd') === false) {
            $ytdlpPath = config('downloader.ytdlp_path', base_path('venv/bin/yt-dlp'));
            $cmd = '';
            if ($proxy) {
                $cmd .= 'http_proxy=' . escapeshellarg($proxy) . ' https_proxy=' . escapeshellarg($proxy) . ' ';
            }
            $cmd .= 'nice -n 19 ' . escapeshellarg($ytdlpPath)
                . ' --quiet --no-warnings --no-check-certificate';

            if ($proxy) {
                $cmd .= ' --proxy ' . escapeshellarg($proxy);
            }

            if ($formatId) {
                $cmd .= ' -f ' . escapeshellarg($formatId);
            }

            $cmd .= ' -o - ' . escapeshellarg($orig ?: $vUrl);

            $filename = substr(preg_replace('/[^A-Za-z0-9\-_]/', '_', $title), 0, 80) . '.mp4';
            $contentType  = 'video/mp4';
            
            Log::info('mergeDownload: Streaming TikTok/Snapchat via yt-dlp: ' . $cmd);

            return new StreamedResponse(function () use ($cmd) {
                set_time_limit(0);
                while (ob_get_level()) { ob_end_clean(); }
                ob_implicit_flush(true);

                $handle = popen($cmd, 'r');
                if ($handle) {
                    while (!feof($handle)) {
                        if (connection_aborted()) {
                            break;
                        }
                        $buffer = fread($handle, 262144);
                        if ($buffer !== false && $buffer !== '') {
                            echo $buffer;
                            flush();
                        }
                    }
                    pclose($handle);
                }
            }, 200, [
                'Content-Type'        => $contentType,
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
                'Cache-Control'       => 'no-cache',
                'X-Accel-Buffering'   => 'no',
            ]);
        }

        // ── VP9/AV1 detection ─────────────────────────────────────────────
        // VP9/AV1 streams (1440p/2160p YouTube): output as WebM (~500MB, same as vidsave).
        // H.264 streams (≤1080p): output as MP4 (stream copy, universally compatible).
        $isVp9Stream = str_contains($vcodec, 'vp9')
                    || str_contains($vcodec, 'vp09')
                    || str_contains($vcodec, 'av01')
                    || str_contains($vcodec, 'av1');

        $ffmpegService = new \App\Services\FFmpegService();
        $result = $ffmpegService->buildStreamMergeCommand(
            $vUrl, $aUrl, $referer, $userAgent, $proxy, $isVp9Stream, $height, $cookies
        );
        $cmd        = $result['cmd'];
        $outFormat  = $result['format']; // always 'mp4' now

        $baseFilename = substr(preg_replace('/[^A-Za-z0-9\-_]/', '_', $title), 0, 80);
        $filename     = $baseFilename . '.mp4'; // always MP4
        $contentType  = 'video/mp4';

        Log::info('mergeDownload: vcodec=' . $vcodec . ' height=' . $height . ' isVp9=' . ($isVp9Stream ? 'yes' : 'no') . ' proxy=' . ($proxy ? 'yes' : 'no'));
        Log::info('mergeDownload Command: ' . $cmd);

        return new StreamedResponse(function () use ($cmd) {
            set_time_limit(0);
            // Clear any remaining PHP output buffers so data flows immediately
            while (ob_get_level()) { ob_end_clean(); }
            ob_implicit_flush(true);

            $handle = popen($cmd, 'r');
            if ($handle) {
                while (!feof($handle)) {
                    if (connection_aborted()) {
                        break;
                    }
                    $buffer = fread($handle, 262144); // 256KB chunks for max throughput
                    if ($buffer !== false && $buffer !== '') {
                        echo $buffer;
                        flush();
                    }
                }
                pclose($handle);
            }
        }, 200, [
            'Content-Type'        => $contentType,
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Cache-Control'       => 'no-cache',
            'X-Accel-Buffering'   => 'no',
        ]);
    }

    public function downloadStatus($id)
    {
        $download = MediaDownload::find($id);
        if (!$download) return response()->json(['error' => 'Not found'], 404);

        $response = [
            'id'       => $download->id,
            'status'   => $download->status,
            'progress' => $download->progress,
        ];

        if ($download->status === MediaDownload::STATUS_COMPLETED) {
            $response['file_url'] = url('/download-file/' . $download->id);
        }

        return response()->json($response);
    }

    public function downloadFile($id)
    {
        $download = MediaDownload::find($id);
        if (!$download || $download->status !== MediaDownload::STATUS_COMPLETED) return abort(404);

        $ext = pathinfo($download->file_path, PATHINFO_EXTENSION);
        $cleanTitle = substr(preg_replace('/[^A-Za-z0-9\-_]/', '_', $download->title), 0, 80) . '.' . $ext;

        return response()->download($download->file_path, $cleanTitle);
    }

    public function proxyThumbnail(Request $request)
    {
        $url = $request->query('url');
        if (!$url) return abort(404);

        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_USERAGENT      => 'Mozilla/5.0',
        ]);
        $data = curl_exec($ch);
        $type = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
        curl_close($ch);

        return response($data)->header('Content-Type', $type ?: 'image/jpeg');
    }

    private function logEvent($type, $url, $format, $quality, $status, $title)
    {
        try {
            DB::table('download_logs')->insert([
                'type'       => $type,
                'platform'   => PlatformDetector::platformName($url),
                'format'     => $format,
                'quality'    => $quality,
                'ip_address' => request()->ip(),
                'status'     => $status,
                'title'      => $title,
                'created_at' => now(),
            ]);
        } catch (\Exception $e) {}
    }
}
