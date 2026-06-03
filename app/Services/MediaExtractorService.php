<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use App\Services\PlatformDetector;

class MediaExtractorService
{
    protected $config;
    protected $ytdlpPath;

    public function __construct()
    {
        $this->config = config('downloader');
        $this->ytdlpPath = $this->config['ytdlp_path'] ?? base_path('venv/bin/yt-dlp');
    }

    /**
     * Extract media info from a URL.
     */
    public function extract($url)
    {
        $startTime = microtime(true);
        $platform = PlatformDetector::detect($url);

        // Platforms where RapidAPI is PRIMARY (yt-dlp needs auth or proxy blocks them)
        $rapidApiPrimary  = ['LinkedIn', 'Snapchat'];
        // Platforms where RapidAPI is FALLBACK if yt-dlp fails
        $rapidApiFallback = ['YouTube', 'TikTok', 'Instagram', 'Facebook', 'LinkedIn', 'Snapchat'];

        $result = null;

        // Skip yt-dlp for platforms where it always fails (auth / proxy block)
        if (!in_array($platform['platform'], $rapidApiPrimary)) {
            $result = $this->extractViaCli($url);
        }

        // Fallback (or primary for LinkedIn/Snapchat) to RapidAPI
        if (!$result && in_array($platform['platform'], $rapidApiFallback)) {
            $result = $this->extractViaRapidApi($url);
        }

        if (!$result) {
            throw new \RuntimeException('Extraction failed: no output from extractor');
        }

        $result['extraction_ms'] = (int) ((microtime(true) - $startTime) * 1000);
        return $result;
    }

    /**
     * Extract via yt-dlp CLI.
     */
    private function extractViaCli($url)
    {
        $binary = $this->findBinary();
        if (!$binary) return null;

        $platform = PlatformDetector::detect($url);
        $isYouTube = ($platform['platform'] === 'YouTube');
        
        // Build command
        $cmd = escapeshellarg($binary)
            . ' --dump-single-json'
            . ' --no-warnings'
            . ' --no-playlist'
            . ' --no-check-certificate'
            . ' --geo-bypass'
            . ' --format-sort "vcodec:h264,res,acodec:m4a"'
            . ' --socket-timeout 30'
            . ' --retries 2';

        // Cookies support
        $cookiesPath = storage_path('app/cookies.txt');
        if (file_exists($cookiesPath)) {
            $cmd .= ' --cookies ' . escapeshellarg($cookiesPath);
        }

        // Platform-specific optimizations
        if ($isYouTube) {
            $extArgs = $this->config['extraction']['extractor_args']['youtube'] ?? null;
            if ($extArgs) {
                $cmd .= ' --extractor-args ' . escapeshellarg($extArgs);
            }
        }

        // User agent
        $ua = $this->config['extraction']['user_agent'] ?? 'Mozilla/5.0';
        $cmd .= ' --user-agent ' . escapeshellarg($ua);

        // Proxy support — only for YouTube (prevents 403 blocks on LinkedIn, Snapchat, TikTok)
        $proxy = $this->config['ytdlp_proxy'] ?? null;
        $sessionId = null;
        if ($proxy && $isYouTube) {
            $proxy = self::getStickyProxy($proxy, $sessionId);
            $cmd .= ' --proxy ' . escapeshellarg($proxy);
        }

        // URL
        $cmd .= ' ' . escapeshellarg($url) . ' 2>&1';
        
        Log::debug('MediaExtractor: Executing CLI | URL: ' . $url);

        $timeout = 60; 
        $output = $this->execWithTimeout($cmd, $timeout);

        if ($output) {
            $parsed = $this->parseYtdlpJson($output, $url, $sessionId);
            if ($parsed) return $parsed;
            
            Log::error("MediaExtractor: CLI Output parsing failed. Output: " . substr($output, 0, 500));
        }
        
        return null;
    }

    /**
     * EXTRACT VIA RAPIDAPI: Social Download All-In-One.
     */
    private function extractViaRapidApi($url)
    {
        $config = config('downloader.rapidapi');
        if (empty($config['key'])) return null;

        $client = new Client([
            'base_uri' => $config['base_url'],
            'timeout'  => 25.0,
            'verify'   => false
        ]);

        try {
            $response = $client->post($config['path'], [
                'headers' => [
                    'X-RapidAPI-Key'  => $config['key'],
                    'X-RapidAPI-Host' => $config['host'],
                    'Content-Type'    => 'application/json',
                ],
                'json' => ['url' => $url]
            ]);

            $data = json_decode($response->getBody(), true);
            if (!$data) return null;

            $apiData = isset($data['data']) && is_array($data['data']) ? $data['data'] : $data;
            if (empty($apiData['medias']) && empty($apiData['title'])) return null;

            $result = [
                'title'          => $apiData['title'] ?? 'Video',
                'thumbnail'      => $apiData['thumbnail'] ?? '',
                'source'         => $apiData['source'] ?? 'RapidAPI',
                'duration'       => $this->formatDuration($apiData['duration'] ?? 0),
                'duration_raw'   => $apiData['duration'] ?? 0,
                'uploader'       => $apiData['author'] ?? null,
                'best_audio_url' => '',
                'medias'         => [],
                'is_rapidapi'    => true,
            ];

            foreach ($apiData['medias'] ?? [] as $m) {
                $type = $m['type'] ?? 'video';
                $isAudio = ($type === 'audio');
                
                $ext = strtolower($m['extension'] ?? ($isAudio ? 'MP3' : 'MP4'));
                if ($type === 'video' && $ext === 'webm') {
                    continue;
                }
                if ($type === 'audio' && in_array($ext, ['webm', 'opus'])) {
                    continue;
                }

                $result['medias'][] = [
                    'url'       => $m['url'],
                    'quality'   => $m['quality'] ?? ($isAudio ? ($m['bitrate'] ?? '128k') : 'HD'),
                    'extension' => strtoupper($m['extension'] ?? ($isAudio ? 'MP3' : 'MP4')),
                    'size'      => $this->formatSize($m['size'] ?? 0),
                    'raw_size'  => (float) ($m['size'] ?? 0),
                    'type'      => $type,
                    'has_audio' => $type === 'video',
                    'height'    => $m['height'] ?? null,
                    'width'     => $m['width'] ?? null,
                ];
            }

            return $result;
        } catch (\Exception $e) {
            Log::error('MediaExtractor: RapidAPI Error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Parse raw yt-dlp --dump-single-json output.
     */
    private function parseYtdlpJson($jsonString, $url, $sessionId = null)
    {
        $info = json_decode($jsonString, true);
        if (!$info || json_last_error() !== JSON_ERROR_NONE) return null;

        if (!empty($info['_type']) && $info['_type'] === 'playlist' && !empty($info['entries'])) {
            $info = $info['entries'][0];
        }

        $result = [
            'id'           => $info['id'] ?? '',
            'title'        => $info['title'] ?? 'Video',
            'thumbnail'    => $info['thumbnail'] ?? '',
            'source'       => $info['extractor_key'] ?? 'Direct',
            'duration'     => $this->formatDuration($info['duration'] ?? 0),
            'duration_raw' => $info['duration'] ?? 0,
            'uploader'     => $info['uploader'] ?? null,
            'medias'       => [],
        ];

        $source = strtolower($info['extractor_key'] ?? '');
        $isYouTube = (strpos($source, 'youtube') !== false);

        // For non-YouTube platforms, pre-scan to see if there are any combined (video+audio) formats.
        // Only filter out video-only formats if combined ones exist (Instagram DASH case).
        // If ALL formats are "video-only" (Snapchat, TikTok, LinkedIn), show them all.
        $hasCombinedVideoFormat = false;
        if (!$isYouTube) {
            foreach ($info['formats'] ?? [] as $f) {
                if (empty($f['url'])) continue;
                $fIsAudio = (!empty($f['vcodec']) && $f['vcodec'] === 'none');
                $fHasAudio = (!empty($f['acodec']) && $f['acodec'] !== 'none');
                if (!$fIsAudio && $fHasAudio) {
                    $hasCombinedVideoFormat = true;
                    break;
                }
            }
        }

        foreach ($info['formats'] ?? [] as $f) {
            if (empty($f['url'])) continue;

            // Skip storyboard and mhtml preview formats
            if (isset($f['format_id']) && (strpos($f['format_id'], 'sb') === 0 || strpos($f['format_id'], 'storyboard') !== false)) {
                continue;
            }
            if (isset($f['ext']) && strtolower($f['ext']) === 'mhtml') {
                continue;
            }

            $ext = strtolower($f['ext'] ?? '');
            $isAudio = (!empty($f['vcodec']) && $f['vcodec'] === 'none');
            $type = $isAudio ? 'audio' : 'video';
            $hasAudio = (!empty($f['acodec']) && $f['acodec'] !== 'none');

            // For non-YouTube platforms, skip video-only (DASH) formats ONLY IF combined formats exist.
            // (Prevents Instagram DASH fragments, but keeps Snapchat/TikTok/LinkedIn single streams)
            if (!$isYouTube && $hasCombinedVideoFormat && $type === 'video' && !$hasAudio) {
                continue;
            }

            // Skip AV1 video codec formats (av01) - not natively supported by Apple QuickTime/macOS/iOS
            $vcodec = strtolower($f['vcodec'] ?? '');
            if ($type === 'video' && (strpos($vcodec, 'av01') !== false || strpos($vcodec, 'av1') !== false)) {
                continue;
            }

            // Skip WEBM video formats for ≤1080p (H264 available as better alternative)
            // BUT allow WebM/VP9 for 4K+ (1440p/2160p) since YouTube has no H264 above 1080p
            $height = (int) ($f['height'] ?? 0);
            if ($type === 'video' && $ext === 'webm' && $height <= 1080) {
                continue;
            }
            // Skip WEBM/Opus audio formats
            if ($type === 'audio' && in_array($ext, ['webm', 'opus'])) {
                continue;
            }

            $mediaUrl = $f['url'];
            if ($sessionId) {
                $mediaUrl .= (strpos($mediaUrl, '?') !== false ? '&' : '?') . 'proxy_session=' . $sessionId;
            }

            // For 4K+ WebM video-only streams: show MP4 badge since FFmpeg merge outputs MP4
            $displayExt = strtoupper($f['ext'] ?? 'MP4');
            if ($type === 'video' && $ext === 'webm' && $height > 1080) {
                $displayExt = 'MP4'; // FFmpeg merge will remux WebM→MP4 container
            }

            $result['medias'][] = [
                'format_id' => $f['format_id'] ?? '',
                'url'       => $mediaUrl,
                'quality'   => $f['format_note'] ?? ($f['height'] ? $f['height'].'p' : 'HD'),
                'extension' => $displayExt,
                'size'      => $this->formatSize($f['filesize'] ?? ($f['filesize_approx'] ?? 0)),
                'raw_size'  => (float) ($f['filesize'] ?? ($f['filesize_approx'] ?? 0)),
                'type'      => $type,
                // For non-YouTube: if no combined format exists and this IS a video,
                // it's a single progressive stream (TikTok/Snapchat) — treat as has_audio = true
                'has_audio' => (!empty($f['acodec']) && $f['acodec'] !== 'none')
                               || (!$isYouTube && !$hasCombinedVideoFormat && $type === 'video'),
            ];
        }

        return $result;
    }

    /**
     * Jugar: Try to refresh cookies automatically.
     */
    public function refreshCookies()
    {
        $binary = $this->findBinary();
        if (!$binary) return false;

        $cookiesPath = storage_path('app/cookies.txt');
        $testUrl = 'https://www.youtube.com/watch?v=dQw4w9WgXcQ';
        
        $cmd = escapeshellarg($binary)
            . ' --cookies ' . escapeshellarg($cookiesPath)
            . ' --user-agent ' . escapeshellarg($this->config['extraction']['user_agent'] ?? 'Mozilla/5.0')
            . ' --extractor-args "youtube:player_client=android"'
            . ' --no-warnings --quiet --dump-single-json ' . escapeshellarg($testUrl) . ' > /dev/null 2>&1';
        
        @exec($cmd);
        return file_exists($cookiesPath);
    }

    private function formatDuration($seconds)
    {
        if (!$seconds) return '00:00';
        $d = (int) $seconds;
        $h = intdiv($d, 3600);
        $m = intdiv($d % 3600, 60);
        $s = $d % 60;
        return $h > 0 ? sprintf('%02d:%02d:%02d', $h, $m, $s) : sprintf('%02d:%02d', $m, $s);
    }

    private function formatSize($bytes)
    {
        if (!$bytes) return '';
        $displaySz = (float) $bytes;
        foreach (['B', 'KB', 'MB', 'GB'] as $unit) {
            if ($displaySz < 1024.0) return sprintf('%.1f %s', $displaySz, $unit);
            $displaySz /= 1024.0;
        }
        return '';
    }

    private function findBinary()
    {
        if (file_exists($this->ytdlpPath)) return $this->ytdlpPath;
        $system = trim(shell_exec('which yt-dlp 2>/dev/null') ?: '');
        if ($system && file_exists($system)) return $system;
        return null;
    }

    private function execWithTimeout($cmd, $timeoutSeconds)
    {
        $descriptorspec = [
            0 => ["pipe", "r"],
            1 => ["pipe", "w"],
            2 => ["pipe", "w"]
        ];

        $process = proc_open($cmd, $descriptorspec, $pipes);
        if (!is_resource($process)) return null;

        stream_set_blocking($pipes[1], false);
        $output  = '';
        $start   = time();

        while (true) {
            $chunk = fread($pipes[1], 65536);
            if ($chunk !== false && $chunk !== '') {
                $output .= $chunk;
            }

            $status = proc_get_status($process);
            if (!$status['running']) break;

            if ((time() - $start) > $timeoutSeconds) {
                proc_terminate($process, 9);
                fclose($pipes[1]);
                fclose($pipes[2]);
                proc_close($process);
                return null;
            }
            usleep(10000);
        }

        $remaining = stream_get_contents($pipes[1]);
        if ($remaining) $output .= $remaining;

        fclose($pipes[1]);
        fclose($pipes[2]);
        proc_close($process);

        return $output ?: null;
    }

    public static function getStickyProxy($proxyUrl, &$sessionId = null)
    {
        if (!$proxyUrl) return null;
        
        $parsed = parse_url($proxyUrl);
        if (!$parsed || empty($parsed['pass'])) return $proxyUrl;
        
        if (strpos($parsed['pass'], '_session-') !== false) {
            if (preg_match('/_session-([a-zA-Z0-9]+)/', $parsed['pass'], $matches)) {
                $sessionId = $matches[1];
            }
            return $proxyUrl;
        }
        
        if (!$sessionId) {
            $sessionId = substr(md5(uniqid(microtime(), true)), 0, 8);
        }
        
        $newPass = $parsed['pass'] . '_session-' . $sessionId . '_lifetime-15m';
        
        $scheme = isset($parsed['scheme']) ? $parsed['scheme'] . '://' : 'http://';
        $user = isset($parsed['user']) ? $parsed['user'] : '';
        $host = isset($parsed['host']) ? $parsed['host'] : '';
        $port = isset($parsed['port']) ? ':' . $parsed['port'] : '';
        
        return $scheme . $user . ':' . $newPass . '@' . $host . $port;
    }
}
