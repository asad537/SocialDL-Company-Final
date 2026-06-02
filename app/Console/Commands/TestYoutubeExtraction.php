<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\MediaExtractorService;

class TestYoutubeExtraction extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'youtube:test {url}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test YouTube extraction with current settings (Android Client + UA)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $url = $this->argument('url');
        $this->info("--------------------------------------------------");
        $this->info("Testing extraction for: {$url}");
        $this->info("Settings: Android Player Client + Custom User-Agent");
        $this->info("--------------------------------------------------");
        
        $service = new MediaExtractorService();
        try {
            $result = $service->extract($url);
            
            $this->info("✅ Extraction Successful!");
            $this->info("Title: " . ($result['title'] ?? 'N/A'));
            $this->info("Source: " . ($result['source'] ?? 'N/A'));
            $this->info("Duration: " . ($result['duration'] ?? 'N/A'));
            
            $medias = $result['medias'] ?? [];
            $this->info("Found " . count($medias) . " media formats.");
            
            if (count($medias) > 0) {
                $headers = ['Quality', 'Ext', 'Size', 'Type'];
                $rows = [];
                foreach (array_slice($medias, 0, 10) as $m) {
                    $rows[] = [
                        $m['quality'] ?? '?',
                        $m['extension'] ?? '?',
                        $m['size'] ?? '?',
                        $m['type'] ?? '?'
                    ];
                }
                $this->table($headers, $rows);
                if (count($medias) > 10) {
                    $this->comment("... and " . (count($medias) - 10) . " more.");
                }
            }
            
        } catch (\Exception $e) {
            $this->error("❌ Extraction Failed!");
            $this->error("Error: " . $e->getMessage());
            
            $this->line("");
            $this->comment("Tip: Check if 'storage/app/cookies.txt' is fresh if this still fails on server.");
        }
    }
}
