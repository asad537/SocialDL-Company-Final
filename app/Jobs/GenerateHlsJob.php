<?php

namespace App\Jobs;

use App\Models\MediaDownload;
use App\Models\ProcessingJob;
use App\Services\DownloadService;
use App\Services\FFmpegService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

/**
 * GenerateHlsJob — Generate HLS (.m3u8 + .ts) for streaming.
 *
 * Flow:
 *   1. Download the source video (aria2c)
 *   2. Generate HLS segments (ffmpeg -c copy -f hls)
 *   3. Serve via nginx for CDN caching
 */
class GenerateHlsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 2;
    public $timeout = 600;

    /** @var string */
    private $videoUrl;

    /** @var string */
    private $mediaId;

    /** @var string|null */
    private $referer;

    /** @var int|null */
    private $downloadId;

    public function __construct($videoUrl, $mediaId, $referer = null, $downloadId = null)
    {
        $this->videoUrl   = $videoUrl;
        $this->mediaId    = $mediaId;
        $this->referer    = $referer;
        $this->downloadId = $downloadId;
        $this->onQueue('hls');
    }

    public function handle(DownloadService $downloadService, FFmpegService $ffmpegService)
    {
        $job = ProcessingJob::create([
            'job_type'    => ProcessingJob::TYPE_HLS,
            'job_id'      => 'hls_' . $this->mediaId . '_' . time(),
            'download_id' => $this->downloadId,
            'status'      => ProcessingJob::STATUS_PROCESSING,
            'started_at'  => now(),
            'payload'     => ['media_id' => $this->mediaId, 'url' => $this->videoUrl],
        ]);

        try {
            // Step 1: Download source video
            $tmpFilename = 'hls_source_' . $this->mediaId . '.mp4';
            $dlResult = $downloadService->download($this->videoUrl, $tmpFilename, $this->referer);

            if (!$dlResult['success']) {
                throw new \RuntimeException('Source download failed: ' . ($dlResult['error'] ?? 'unknown'));
            }

            // Step 2: Generate HLS
            $hlsResult = $ffmpegService->generateHls($dlResult['path'], $this->mediaId);

            if (!$hlsResult['success']) {
                throw new \RuntimeException('HLS generation failed: ' . ($hlsResult['error'] ?? 'unknown'));
            }

            // Step 3: Cleanup source file (segments are kept)
            @unlink($dlResult['path']);

            // Step 4: Update status
            if ($this->downloadId) {
                $download = MediaDownload::find($this->downloadId);
                if ($download) {
                    $download->markCompleted($hlsResult['playlist']);
                }
            }

            $job->markCompleted($hlsResult['ms'] ?? null);

            Log::info('GenerateHlsJob: completed', [
                'media_id' => $this->mediaId,
                'segments' => $hlsResult['segments'],
                'ms'       => $hlsResult['ms'] ?? 0,
            ]);
        } catch (\Throwable $e) {
            $job->markFailed($e->getMessage());

            if ($this->downloadId) {
                $download = MediaDownload::find($this->downloadId);
                if ($download) $download->markFailed($e->getMessage());
            }

            Log::error('GenerateHlsJob: failed', [
                'media_id' => $this->mediaId,
                'error'    => $e->getMessage(),
            ]);

            throw $e;
        }
    }
}
