<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

/**
 * FFmpegService — Video/Audio merging and HLS generation.
 *
 * RULES:
 *   - NEVER re-encode video. Always use -c:v copy.
 *   - Re-encode audio to AAC only when merging with incompatible audio codec.
 *   - HLS: use -c copy -f hls with segmenting.
 */
class FFmpegService
{
    /** @var string */
    private $ffmpegPath;

    /** @var string */
    private $ffprobePath;

    /** @var string */
    private $hlsDir;

    /** @var string */
    private $tempDir;

    public function __construct()
    {
        $this->ffmpegPath  = config('downloader.ffmpeg_path', '/usr/local/bin/ffmpeg');
        $this->ffprobePath = config('downloader.ffprobe_path', '/usr/local/bin/ffprobe');
        $this->hlsDir      = config('downloader.hls_dir', storage_path('app/hls'));
        $this->tempDir     = config('downloader.temp_dir', storage_path('app/temp'));

        foreach ([$this->hlsDir, $this->tempDir] as $dir) {
            if (!is_dir($dir)) mkdir($dir, 0755, true);
        }
    }

    /**
     * Merge separate video and audio files into a single MP4.
     * Uses -c copy (no re-encoding) for maximum speed.
     *
     * @param string $videoPath  Path to video file
     * @param string $audioPath  Path to audio file
     * @param string $outputPath Output MP4 path
     * @return array ['success' => bool, 'path' => string, 'size' => int, 'ms' => int, 'error' => string|null]
     */
    public function merge($videoPath, $audioPath, $outputPath)
    {
        $startTime = microtime(true);
        $ffmpeg = $this->findFfmpeg();

        $cmd = escapeshellarg($ffmpeg)
            . ' -y'
            . ' -i ' . escapeshellarg($videoPath)
            . ' -i ' . escapeshellarg($audioPath)
            . ' -c:v copy -c:a aac'
            . ' -map 0:v:0 -map 1:a:0'
            . ' -movflags +faststart'
            . ' ' . escapeshellarg($outputPath)
            . ' 2>&1';

        exec($cmd, $output, $exitCode);
        $elapsed = (int) ((microtime(true) - $startTime) * 1000);

        if ($exitCode === 0 && file_exists($outputPath)) {
            return [
                'success' => true,
                'path'    => $outputPath,
                'size'    => filesize($outputPath),
                'ms'      => $elapsed,
                'error'   => null,
            ];
        }

        $error = implode("\n", array_slice($output, -10));
        Log::error('FFmpegService: merge failed', ['exit' => $exitCode, 'error' => $error]);

        return ['success' => false, 'path' => null, 'size' => 0, 'ms' => $elapsed, 'error' => $error];
    }

    /**
     * Merge video and audio from remote URLs (streaming merge).
     * Used for real-time proxy downloads.
     *
     * @param string $videoUrl
     * @param string $audioUrl|null
     * @param string $referer
     * @param string $userAgent
     * @return string  The ffmpeg command that outputs to pipe:1
     */
    public function buildStreamMergeCommand($videoUrl, $audioUrl = null, $referer = '', $userAgent = '')
    {
        $ffmpeg = $this->findFfmpeg();
        $headersStr = '';
        if ($userAgent || $referer) {
            $parts = [];
            if ($userAgent) $parts[] = "User-Agent: {$userAgent}";
            if ($referer)   $parts[] = "Referer: {$referer}";
            $headersStr = implode("\r\n", $parts) . "\r\n";
        }

        $cmd = escapeshellarg($ffmpeg);

        if ($headersStr) {
            $cmd .= ' -headers ' . escapeshellarg($headersStr);
        }

        $cmd .= ' -reconnect 1 -reconnect_streamed 1 -reconnect_delay_max 5'
            . ' -i ' . escapeshellarg($videoUrl);

        if ($audioUrl) {
            if ($headersStr) {
                $cmd .= ' -headers ' . escapeshellarg($headersStr);
            }
            $cmd .= ' -reconnect 1 -reconnect_streamed 1 -reconnect_delay_max 5'
                . ' -i ' . escapeshellarg($audioUrl)
                . ' -c:v copy -c:a aac'
                . ' -map 0:v:0 -map 1:a:0';
        } else {
            $cmd .= ' -c:v copy';
        }

        $cmd .= ' -f mp4 -movflags frag_keyframe+empty_moov'
            . ' pipe:1 2>/dev/null';

        return $cmd;
    }

    /**
     * Re-mux a file into proper MP4 container.
     * Fixes files that don't play on macOS/iOS.
     */
    public function remuxToMp4($inputPath, $outputPath = null)
    {
        if (!$outputPath) {
            $outputPath = $inputPath . '.remuxed.mp4';
        }

        $ffmpeg = $this->findFfmpeg();
        $cmd = escapeshellarg($ffmpeg)
            . ' -y -i ' . escapeshellarg($inputPath)
            . ' -c copy -movflags +faststart'
            . ' ' . escapeshellarg($outputPath)
            . ' 2>&1';

        exec($cmd, $output, $exitCode);

        if ($exitCode === 0 && file_exists($outputPath)) {
            return ['success' => true, 'path' => $outputPath, 'size' => filesize($outputPath)];
        }

        return ['success' => false, 'path' => null, 'error' => implode("\n", array_slice($output, -5))];
    }

    /**
     * Generate HLS (HTTP Live Streaming) files from a local video.
     *
     * Creates:
     *   - {outputDir}/playlist.m3u8
     *   - {outputDir}/segment_000.ts, segment_001.ts, ...
     *
     * @param string $inputPath  Path to source video
     * @param string $mediaId    Unique identifier for output directory
     * @return array ['success' => bool, 'playlist' => string, 'dir' => string, 'segments' => int]
     */
    public function generateHls($inputPath, $mediaId)
    {
        $outputDir = $this->hlsDir . '/' . $mediaId;
        if (!is_dir($outputDir)) mkdir($outputDir, 0755, true);

        $playlistPath = $outputDir . '/playlist.m3u8';
        $segmentPath  = $outputDir . '/segment_%03d.ts';

        $hlsTime     = config('downloader.ffmpeg.hls_time', 6);
        $hlsListSize = config('downloader.ffmpeg.hls_list_size', 0);

        $ffmpeg = $this->findFfmpeg();
        $cmd = escapeshellarg($ffmpeg)
            . ' -y -i ' . escapeshellarg($inputPath)
            . ' -c copy'    // NEVER re-encode
            . ' -f hls'
            . ' -hls_time ' . (int) $hlsTime
            . ' -hls_list_size ' . (int) $hlsListSize
            . ' -hls_segment_filename ' . escapeshellarg($segmentPath)
            . ' -hls_flags independent_segments'
            . ' ' . escapeshellarg($playlistPath)
            . ' 2>&1';

        $startTime = microtime(true);
        exec($cmd, $output, $exitCode);
        $elapsed = (int) ((microtime(true) - $startTime) * 1000);

        if ($exitCode === 0 && file_exists($playlistPath)) {
            $segments = count(glob($outputDir . '/*.ts'));
            Log::info("FFmpegService: HLS generated in {$elapsed}ms, {$segments} segments");
            return [
                'success'  => true,
                'playlist' => $playlistPath,
                'dir'      => $outputDir,
                'segments' => $segments,
                'ms'       => $elapsed,
            ];
        }

        $error = implode("\n", array_slice($output, -5));
        Log::error('FFmpegService: HLS generation failed', ['error' => $error]);
        return ['success' => false, 'playlist' => null, 'error' => $error];
    }

    /**
     * Probe a media file for metadata.
     */
    public function probe($filePath)
    {
        $ffprobe = $this->findFfprobe();
        $cmd = escapeshellarg($ffprobe)
            . ' -v quiet -print_format json -show_format -show_streams'
            . ' ' . escapeshellarg($filePath)
            . ' 2>/dev/null';

        $output = shell_exec($cmd);
        return json_decode($output ?: '{}', true);
    }

    /**
     * Find ffmpeg binary.
     */
    private function findFfmpeg()
    {
        if (file_exists($this->ffmpegPath)) return $this->ffmpegPath;
        $which = trim(shell_exec('which ffmpeg 2>/dev/null') ?: '');
        return $which ?: 'ffmpeg';
    }

    /**
     * Find ffprobe binary.
     */
    private function findFfprobe()
    {
        if (file_exists($this->ffprobePath)) return $this->ffprobePath;
        $which = trim(shell_exec('which ffprobe 2>/dev/null') ?: '');
        return $which ?: 'ffprobe';
    }
}
