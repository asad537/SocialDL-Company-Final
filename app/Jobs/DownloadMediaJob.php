<?php

namespace App\Jobs;

use App\Models\MediaDownload;
use App\Models\ProcessingJob;
use App\Services\DownloadService;
use App\Services\PlatformDetector;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

/**
 * DownloadMediaJob — Background download using aria2c.
 *
 * Dispatched when user clicks download.
 * Uses aria2c (16 connections) for maximum speed.
 * Falls back to cURL if aria2c unavailable.
 */
class DownloadMediaJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3;
    public $timeout = 300; // 5 minutes max
    public $backoff = [5, 15, 30]; // retry delays

    /** @var int */
    private $downloadId;

    /** @var string */
    private $url;

    /** @var string */
    private $filename;

    /** @var string|null */
    private $referer;

    /** @var string|null */
    private $platform;

    public function __construct($downloadId, $url, $filename, $referer = null, $platform = null)
    {
        $this->downloadId = $downloadId;
        $this->url        = $url;
        $this->filename   = $filename;
        $this->referer    = $referer;
        $this->platform   = $platform;
        $this->onQueue('downloads');
    }

    public function handle(DownloadService $downloadService)
    {
        $download = MediaDownload::find($this->downloadId);
        if (!$download) return;

        $download->update([
            'status'   => MediaDownload::STATUS_DOWNLOADING,
            'progress' => 10,
        ]);

        // Track in processing_jobs
        $job = ProcessingJob::create([
            'job_type'    => ProcessingJob::TYPE_DOWNLOAD,
            'job_id'      => 'dl_' . $this->downloadId . '_' . time(),
            'download_id' => $this->downloadId,
            'media_id'    => $download->media_id,
            'status'      => ProcessingJob::STATUS_PROCESSING,
            'started_at'  => now(),
            'payload'     => ['url' => $this->url, 'filename' => $this->filename],
        ]);

        try {
            $result = $downloadService->download(
                $this->url,
                $this->filename,
                $this->referer,
                $this->platform
            );

            if ($result['success']) {
                $download->markCompleted($result['path'], $result['size']);
                $job->markCompleted($result['ms'] ?? null);

                Log::info('DownloadMediaJob: completed', [
                    'download_id' => $this->downloadId,
                    'size'        => $result['size'],
                    'ms'          => $result['ms'] ?? 0,
                ]);
            } else {
                throw new \RuntimeException($result['error'] ?? 'Download failed');
            }
        } catch (\Throwable $e) {
            $download->markFailed($e->getMessage());
            $job->markFailed($e->getMessage());

            Log::error('DownloadMediaJob: failed', [
                'download_id' => $this->downloadId,
                'error'       => $e->getMessage(),
                'attempt'     => $this->attempts(),
            ]);

            throw $e; // Re-throw to trigger retry
        }
    }

    public function failed(\Throwable $exception)
    {
        $download = MediaDownload::find($this->downloadId);
        if ($download) {
            $download->markFailed('All retries exhausted: ' . $exception->getMessage());
        }
    }
}
