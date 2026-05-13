<?php

namespace App\Jobs;

use App\Models\MediaDownload;
use App\Models\ProcessingJob;
use App\Services\DownloadService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

/**
 * CleanupMediaJob — Scheduled cleanup of old files and stale records.
 *
 * Should be scheduled hourly via Laravel scheduler:
 *   $schedule->job(new CleanupMediaJob)->hourly();
 */
class CleanupMediaJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 1;
    public $timeout = 120;

    public function __construct()
    {
        $this->onQueue('cleanup');
    }

    public function handle(DownloadService $downloadService)
    {
        $startTime = microtime(true);
        $maxAge    = config('downloader.cleanup.max_age_hours', 24);
        $stats     = ['files_deleted' => 0, 'records_cleaned' => 0, 'jobs_cleaned' => 0];

        // 1. Delete old downloaded files
        $stats['files_deleted'] = $downloadService->cleanupOldFiles($maxAge);

        // 2. Clean stale download records (failed + older than max_age)
        try {
            $stats['records_cleaned'] = MediaDownload::where('created_at', '<', now()->subHours($maxAge))
                ->whereIn('status', [MediaDownload::STATUS_FAILED, MediaDownload::STATUS_COMPLETED])
                ->delete();
        } catch (\Throwable $e) {
            Log::warning('CleanupMediaJob: DB cleanup failed', ['error' => $e->getMessage()]);
        }

        // 3. Clean old processing job records
        try {
            $stats['jobs_cleaned'] = ProcessingJob::where('created_at', '<', now()->subHours($maxAge * 2))
                ->whereIn('status', [ProcessingJob::STATUS_COMPLETED, ProcessingJob::STATUS_FAILED])
                ->delete();
        } catch (\Throwable $e) {
            Log::warning('CleanupMediaJob: processing_jobs cleanup failed', ['error' => $e->getMessage()]);
        }

        $elapsed = (int) ((microtime(true) - $startTime) * 1000);

        Log::info('CleanupMediaJob: completed', array_merge($stats, ['ms' => $elapsed]));
    }
}
