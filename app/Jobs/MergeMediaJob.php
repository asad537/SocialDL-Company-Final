<?php

namespace App\Jobs;

use App\Models\MediaDownload;
use App\Models\ProcessingJob;
use App\Services\DownloadService;
use App\Services\FFmpegService;
use App\Services\PlatformDetector;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

/**
 * MergeMediaJob — FFmpeg merge video+audio in background.
 *
 * Used for:
 *   - YouTube DASH formats (1080p+: separate video + audio)
 *   - Instagram VP9 videos that need audio merging
 *   - Any platform with split streams
 *
 * Uses -c copy (no re-encoding) + -movflags +faststart.
 */
class MergeMediaJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 2;
    public $timeout = 600; // 10 minutes max for large files

    /** @var int */
    private $downloadId;

    /** @var string */
    private $videoUrl;

    /** @var string|null */
    private $audioUrl;

    /** @var string */
    private $outputFilename;

    /** @var string|null */
    private $referer;

    public function __construct($downloadId, $videoUrl, $audioUrl, $outputFilename, $referer = null)
    {
        $this->downloadId     = $downloadId;
        $this->videoUrl       = $videoUrl;
        $this->audioUrl       = $audioUrl;
        $this->outputFilename = $outputFilename;
        $this->referer        = $referer;
        $this->onQueue('merge');
    }

    public function handle(DownloadService $downloadService, FFmpegService $ffmpegService)
    {
        $download = MediaDownload::find($this->downloadId);
        if (!$download) return;

        $download->update([
            'status'   => MediaDownload::STATUS_DOWNLOADING,
            'progress' => 10,
        ]);

        $job = ProcessingJob::create([
            'job_type'    => ProcessingJob::TYPE_MERGE,
            'job_id'      => 'merge_' . $this->downloadId . '_' . time(),
            'download_id' => $this->downloadId,
            'media_id'    => $download->media_id,
            'status'      => ProcessingJob::STATUS_PROCESSING,
            'started_at'  => now(),
        ]);

        try {
            $downloadDir = $downloadService->getDownloadDir();
            $videoFile   = $downloadDir . '/video_' . $this->downloadId . '.tmp';
            $audioFile   = $downloadDir . '/audio_' . $this->downloadId . '.tmp';
            $outputFile  = $downloadDir . '/' . $this->outputFilename;

            // Step 1: Download video
            $vResult = $downloadService->download($this->videoUrl, basename($videoFile), $this->referer);
            if (!$vResult['success']) {
                throw new \RuntimeException('Video download failed: ' . ($vResult['error'] ?? 'unknown'));
            }

            $download->update(['progress' => 70]);

            // Step 2: Download audio (if provided)
            if ($this->audioUrl) {
                $aResult = $downloadService->download($this->audioUrl, basename($audioFile), $this->referer);
                if (!$aResult['success']) {
                    throw new \RuntimeException('Audio download failed: ' . ($aResult['error'] ?? 'unknown'));
                }
                $download->update(['progress' => 90]);
            } else {
                $download->update(['progress' => 90]);
            }

            // Step 3: Merge with FFmpeg
            $download->markMerging();

            if ($this->audioUrl && file_exists($audioFile)) {
                $mergeResult = $ffmpegService->merge($videoFile, $audioFile, $outputFile);
            } else {
                // No audio — just remux video into proper MP4 container
                $mergeResult = $ffmpegService->remuxToMp4($videoFile, $outputFile);
            }

            if (!$mergeResult['success']) {
                throw new \RuntimeException('FFmpeg merge failed: ' . ($mergeResult['error'] ?? 'unknown'));
            }

            // Step 4: Cleanup temp files
            @unlink($videoFile);
            @unlink($audioFile);

            // Step 5: Update download record
            $download->markCompleted($outputFile, $mergeResult['size'] ?? filesize($outputFile));
            $job->markCompleted($mergeResult['ms'] ?? null);

            Log::info('MergeMediaJob: completed', [
                'download_id' => $this->downloadId,
                'size'        => $mergeResult['size'] ?? 0,
                'ms'          => $mergeResult['ms'] ?? 0,
            ]);
        } catch (\Throwable $e) {
            // Cleanup on failure
            foreach ([$videoFile ?? '', $audioFile ?? ''] as $tmp) {
                if ($tmp && file_exists($tmp)) @unlink($tmp);
            }

            $download->markFailed($e->getMessage());
            $job->markFailed($e->getMessage());

            Log::error('MergeMediaJob: failed', [
                'download_id' => $this->downloadId,
                'error'       => $e->getMessage(),
            ]);

            throw $e;
        }
    }

    public function failed(\Throwable $exception)
    {
        $download = MediaDownload::find($this->downloadId);
        if ($download) {
            $download->markFailed('Merge failed: ' . $exception->getMessage());
        }
    }
}
