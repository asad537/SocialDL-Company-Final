<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function extract(Request $request)
    {
        $url = $request->input('url');
        if (!$url) {
            return response()->json(['error' => 'URL is required'], 400);
        }

        // Path to your python script and venv python
        $pythonScript = base_path('downloader.py');
        $pythonExe = base_path('venv/bin/python3');
        
        // Execute the script using venv python (escaped for spaces)
        $command = escapeshellarg($pythonExe) . " " . escapeshellarg($pythonScript) . " " . escapeshellarg($url) . " 2>&1";
        $output = shell_exec($command);

        if (!$output) {
            return response()->json(['error' => 'Failed to execute extraction script'], 500);
        }

        // Check if output is valid JSON
        $data = json_decode($output);
        if (json_last_error() !== JSON_ERROR_NONE) {
            return response()->json(['error' => 'Invalid response from extractor: ' . $output], 500);
        }

        return response()->json($data);
    }

    public function proxyDownload(Request $request)
    {
        $url = $request->query('url');
        $filename = $request->query('title', 'video');
        $ext = $request->query('ext', 'mp4');

        if (!$url) return abort(400, 'URL missing');

        // Clean filename
        $filename = preg_replace('/[^A-Za-z0-9\-]/', '_', $filename) . '.' . $ext;

        return response()->streamDownload(function () use ($url) {
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
            curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0');
            curl_exec($ch);
            curl_close($ch);
        }, $filename);
    }

    public function mergeDownload(Request $request)
    {
        $videoUrl = $request->query('video_url');
        $audioUrl = $request->query('audio_url');
        $title = $request->query('title', 'video');
        
        if (!$videoUrl || !$audioUrl) return abort(400, 'Missing URLs');

        $fileName = preg_replace('/[^A-Za-z0-9\-]/', '_', $title) . ".mp4";
        
        // This command merges video from URL 1 and audio from URL 2 on the fly
        // It uses "-c copy" so no re-encoding is needed (very fast)
        $command = "ffmpeg -i " . escapeshellarg($videoUrl) . " -i " . escapeshellarg($audioUrl) . " -c copy -map 0:v:0 -map 1:a:0 -f mp4 -movflags frag_keyframe+empty_moov pipe:1 2>/dev/null";

        return response()->streamDownload(function() use ($command) {
            $handle = popen($command, 'r');
            if ($handle) {
                while (!feof($handle)) {
                    echo fread($handle, 16384);
                    flush();
                }
                pclose($handle);
            }
        }, $fileName);
    }

    public function proxyThumbnail(Request $request)
    {
        $url = $request->query('url');
        if (!$url) return abort(404);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/119.0.0.0 Safari/537.36');
        curl_setopt($ch, CURLOPT_REFERER, 'https://www.instagram.com/');
        $data = curl_exec($ch);
        $type = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
        curl_close($ch);

        return response($data)->header('Content-Type', $type);
    }
}
