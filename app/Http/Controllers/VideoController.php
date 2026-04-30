<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class VideoController extends Controller
{
    /*
    |----------------------------------------------------------------------
    | LOAD ANALYSIS:
    |   /extract       → Heavy (Python process). CACHED per URL for 30 min.
    |                    1,000,000 users asking same URL = 1 Python call.
    |   /direct-download → ZERO server load. Browser downloads from CDN.
    |   /proxy-download  → Minor (fallback only). Streams 128KB chunks.
    |   /merge-download  → FFmpeg (only 1080p+, unavoidable).
    |   /thumbnail-proxy → Cached in browser for 1 hour.
    |----------------------------------------------------------------------
    */

    /**
     * Extract video info — result cached per URL for 30 minutes.
     * Same URL from 1,000,000 users = only 1 Python subprocess call.
     */
    public function extract(Request $request)
    {
        $url = trim($request->input('url', ''));
        if (!$url) {
            return response()->json(['error' => 'URL is required'], 400);
        }

        // Validate it looks like a URL
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            return response()->json(['error' => 'Invalid URL format'], 400);
        }

        // ── Cache key: sha256 of the URL (safe for cache storage) ──────────
        $cacheKey = 'video_info_' . hash('sha256', $url);

        // ── Return cached result instantly if available ─────────────────────
        if (Cache::has($cacheKey)) {
            return response()->json(Cache::get($cacheKey))
                ->header('X-Cache', 'HIT')
                ->header('X-Cache-TTL', Cache::getStore()->get($cacheKey . '_ttl') ?? '1800');
        }

        // ── Not cached: run Python extraction ──────────────────────────────
        $pythonScript = base_path('downloader.py');
        $pythonExe    = base_path('venv/bin/python3');

        // Fallback to system python3 if venv not present
        if (!file_exists($pythonExe)) {
            $pythonExe = trim(shell_exec('which python3')) ?: 'python3';
        }

        $command = escapeshellarg($pythonExe)
            . ' ' . escapeshellarg($pythonScript)
            . ' ' . escapeshellarg($url)
            . ' 2>&1';

        $output = shell_exec($command);

        if (!$output) {
            return response()->json(['error' => 'Extraction failed — Python returned no output.'], 500);
        }

        // Strip any debug lines before the JSON payload
        $jsonStart = strpos($output, '{');
        if ($jsonStart === false) {
            return response()->json(['error' => 'Script output error: ' . substr($output, 0, 300)], 500);
        }
        $output = substr($output, $jsonStart);

        $data = json_decode($output, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            return response()->json(['error' => 'JSON parse error: ' . json_last_error_msg()], 500);
        }

        // Don't cache error responses
        if (!empty($data['error'])) {
            return response()->json($data, 422);
        }

        // ── Cache for 30 minutes ────────────────────────────────────────────
        // CDN URLs from YouTube/Instagram typically stay valid for ~6 hours,
        // so 30 minutes is safe. Adjust as needed.
        Cache::put($cacheKey, $data, now()->addMinutes(30));

        return response()->json($data)
            ->header('X-Cache', 'MISS');
    }

    /**
     * Direct download — ZERO server load.
     * Redirects the browser straight to the platform CDN URL.
     * Server only sends a 302 redirect response (< 1KB), then done.
     */
    public function directDownload(Request $request)
    {
        $url = $request->query('url');
        if (!$url) return abort(400, 'URL parameter is required.');

        // Redirect browser directly to CDN — no bandwidth used on server
        return redirect()->away($url);
    }

    /**
     * Proxy download — fallback when CDN rejects a plain browser redirect.
     * Uses large 128KB read buffer for efficiency.
     */
    public function proxyDownload(Request $request)
    {
        $url   = $request->query('url');
        $title = $request->query('title', 'video');
        $ext   = $request->query('ext', 'mp4');

        if (!$url) return abort(400);

        $filename = substr(preg_replace('/[^A-Za-z0-9\-_]/', '_', $title), 0, 80)
            . '.' . strtolower($ext);

        return response()->streamDownload(function () use ($url) {
            $ch = curl_init($url);
            curl_setopt_array($ch, [
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_RETURNTRANSFER => false,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_BUFFERSIZE     => 131072,  // 128 KB
                CURLOPT_TIMEOUT        => 0,
                CURLOPT_CONNECTTIMEOUT => 15,
                CURLOPT_USERAGENT      => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
                CURLOPT_HTTPHEADER     => ['Referer: https://www.youtube.com/'],
                CURLOPT_WRITEFUNCTION  => function ($ch, $chunk) {
                    echo $chunk;
                    return strlen($chunk);
                },
            ]);
            curl_exec($ch);
            curl_close($ch);
        }, $filename, [
            'Content-Type'      => 'application/octet-stream',
            'Cache-Control'     => 'no-cache',
            'X-Accel-Buffering' => 'no',
        ]);
    }

    /**
     * Merge-download — FFmpeg stitches separate video+audio streams.
     * Only needed for YouTube 1080p+ (DASH format). Unavoidable server work.
     * -reconnect flags allow FFmpeg to survive slow CDN connections.
     */
    public function mergeDownload(Request $request)
    {
        $vUrl  = $request->query('video_url');
        $aUrl  = $request->query('audio_url');
        $title = $request->query('title', 'video');

        if (!$vUrl || !$aUrl) return abort(400);

        $fileName = substr(preg_replace('/[^A-Za-z0-9\-_]/', '_', $title), 0, 80) . '.mp4';

        $command = 'ffmpeg'
            . ' -reconnect 1 -reconnect_streamed 1 -reconnect_delay_max 5'
            . ' -i ' . escapeshellarg($vUrl)
            . ' -reconnect 1 -reconnect_streamed 1 -reconnect_delay_max 5'
            . ' -i ' . escapeshellarg($aUrl)
            . ' -c:v copy -c:a aac'
            . ' -map 0:v:0 -map 1:a:0'
            . ' -f mp4 -movflags frag_keyframe+empty_moov'
            . ' pipe:1 2>/dev/null';

        return response()->streamDownload(function () use ($command) {
            $handle = popen($command, 'r');
            if ($handle) {
                while (!feof($handle)) {
                    echo fread($handle, 131072); // 128 KB chunk
                    flush();
                }
                pclose($handle);
            }
        }, $fileName, [
            'Content-Type'      => 'video/mp4',
            'X-Accel-Buffering' => 'no',
        ]);
    }

    /**
     * Thumbnail proxy — cached in browser for 1 hour.
     * Server only fetches once per unique thumbnail URL.
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
            ->header('Cache-Control', 'public, max-age=3600')   // Browser caches 1 hour
            ->header('Expires', gmdate('D, d M Y H:i:s', time() + 3600) . ' GMT');
    }
}
