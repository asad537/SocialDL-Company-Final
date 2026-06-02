<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\MediaExtractorService;

class RefreshYoutubeCookies extends Command
{
    protected $signature = 'youtube:refresh-cookies';
    protected $description = 'Refresh YouTube cookies using yt-dlp guest session';

    public function handle()
    {
        $this->info('Refreshing YouTube cookies...');
        $service = new MediaExtractorService();
        if ($service->refreshCookies()) {
            $this->info('Cookies refreshed successfully!');
        } else {
            $this->error('Failed to refresh cookies.');
        }
    }
}
