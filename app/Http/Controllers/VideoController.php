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

        if (!$url) return abort(400);

        $proxySession = null;
        if (preg_match('/[?&]proxy_session=([a-zA-Z0-9]+)/', $url, $matches)) {
            $proxySession = $matches[1];
            $url = preg_replace('/([?&])proxy_session=[a-zA-Z0-9]+&?/', '$1', $url);
            $url = rtrim($url, '?&');
        }

        $this->logEvent('download', $sourceUrl, $ext, 'HD', true, $title);

        $detected = PlatformDetector::detect($sourceUrl);
        $referer = $detected['referer'];
        $userAgent = config('downloader.extraction.user_agent', 'Mozilla/5.0');
        $filename = substr(preg_replace('/[^A-Za-z0-9\-_]/', '_', $title), 0, 80) . '.' . $ext;
        $proxy = config('downloader.ytdlp_proxy');
        if ($proxy && $proxySession) {
            $proxy = \App\Services\MediaExtractorService::getStickyProxy($proxy, $proxySession);
        }

        // Resolve Content-Type
        $contentType = 'application/octet-stream';
        if ($ext === 'mp4') $contentType = 'video/mp4';
        elseif ($ext === 'mp3') $contentType = 'audio/mpeg';
        elseif ($ext === 'webm') $contentType = 'video/webm';

        return new StreamedResponse(function () use ($url, $referer, $userAgent, $proxy) {
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
                CURLOPT_BUFFERSIZE     => 131072,
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

            curl_setopt_array($ch, $options);
            curl_exec($ch);
            curl_close($ch);
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

        $vUrl = $request->query('video_url');
        $aUrl = $request->query('audio_url');
        $title = $request->query('title', 'video');
        $orig = $request->query('source_url', $vUrl);

        if (!$vUrl) return abort(400);

        $this->logEvent('download', $orig ?: $vUrl, 'mp4', '1080p+', true, $title);

        $detected = PlatformDetector::detect($orig ?: $vUrl);
        $referer = $detected['referer'];
        $userAgent = config('downloader.extraction.user_agent', 'Mozilla/5.0');
        $filename = substr(preg_replace('/[^A-Za-z0-9\-_]/', '_', $title), 0, 80) . '.mp4';

        // Resolve Proxy
        $proxy = config('downloader.ytdlp_proxy');
        $proxySession = null;
        if (preg_match('/[?&]proxy_session=([a-zA-Z0-9]+)/', $vUrl, $matches)) {
            $proxySession = $matches[1];
        }
        if ($proxy && $proxySession) {
            $proxy = \App\Services\MediaExtractorService::getStickyProxy($proxy, $proxySession);
        }

        $ffmpegService = new \App\Services\FFmpegService();
        $cmd = $ffmpegService->buildStreamMergeCommand($vUrl, $aUrl, $referer, $userAgent, $proxy);

        return new StreamedResponse(function () use ($cmd) {
            $handle = popen($cmd, 'r');
            if ($handle) {
                while (!feof($handle)) {
                    $buffer = fread($handle, 65536);
                    echo $buffer;
                    flush();
                }
                pclose($handle);
            }
        }, 200, [
            'Content-Type'        => 'video/mp4',
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
