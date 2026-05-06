<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Platform;
use Illuminate\Support\Facades\DB;

class PlatformSeeder extends Seeder
{
    public function run()
    {
        $platforms = [
            [
                'name' => 'Facebook',
                'slug' => 'facebook-video-downloader',
                'h1' => 'Download Facebook Videos & Audios',
                'meta_title' => 'Facebook Video Downloader - Download FB Videos for Free',
                'meta_description' => 'Fastest Facebook video downloader. Save FB videos, reels, and stories in HD quality for free.',
                'content' => json_encode([
                    'blocks' => [
                        ['type' => 'header', 'data' => ['text' => 'How to Download Facebook Videos?', 'level' => 2]],
                        ['type' => 'paragraph', 'data' => ['text' => 'Copy the URL of the Facebook video you want to save, paste it into the search box above, and click Download. You can choose from various qualities including HD.']]
                    ]
                ]),
                'status' => 'active',
            ],
            [
                'name' => 'YouTube',
                'slug' => 'youtube-video-downloader',
                'h1' => 'Download YouTube Videos & MP3s',
                'meta_title' => 'YouTube Downloader - Convert YouTube to MP4 & MP3',
                'meta_description' => 'Download YouTube videos in 4K, 1080p and convert to MP3 instantly. No software required.',
                'content' => json_encode([
                    'blocks' => [
                        ['type' => 'header', 'data' => ['text' => 'YouTube to MP4 & MP3 Downloader', 'level' => 2]],
                        ['type' => 'paragraph', 'data' => ['text' => 'Video Saver is the best tool to convert YouTube videos to MP3 and MP4. It is fast, free, and works on all devices.']]
                    ]
                ]),
                'status' => 'active',
            ],
            [
                'name' => 'WhatsApp',
                'slug' => 'whatsapp-status-saver',
                'h1' => 'Download WhatsApp Status Videos & Images',
                'meta_title' => 'WhatsApp Status Saver - Download Status Online',
                'meta_description' => 'Save WhatsApp status videos and images easily. Just paste the link and download your favorite status.',
                'content' => json_encode([
                    'blocks' => [
                        ['type' => 'header', 'data' => ['text' => 'Online WhatsApp Status Downloader', 'level' => 2]],
                        ['type' => 'paragraph', 'data' => ['text' => 'Never miss a status! Use our tool to download WhatsApp status videos and images directly to your gallery.']]
                    ]
                ]),
                'status' => 'active',
            ],
            [
                'name' => 'Instagram',
                'slug' => 'instagram-video-downloader',
                'h1' => 'Download Instagram Reels & Stories',
                'meta_title' => 'Instagram Downloader - Download Reels, Stories & IGTV',
                'meta_description' => 'Download Instagram reels and stories in high quality. Simply paste the link and save to your device.',
                'content' => json_encode([
                    'blocks' => [
                        ['type' => 'header', 'data' => ['text' => 'Save Instagram Reels Fast', 'level' => 2]],
                        ['type' => 'paragraph', 'data' => ['text' => 'Looking for a way to save Instagram Reels? Paste the link above and get your video in seconds.']]
                    ]
                ]),
                'status' => 'active',
            ],
        ];

        foreach ($platforms as $platform) {
            Platform::updateOrCreate(['slug' => $platform['slug']], $platform);
            
            // Add some default FAQs for each
            DB::table('faqs')->updateOrInsert(
                ['page' => $platform['slug'], 'question' => 'Is this ' . $platform['name'] . ' downloader free?'],
                [
                    'answer' => 'Yes, our ' . $platform['name'] . ' downloader is completely free to use with no limits.',
                    'page' => $platform['slug'],
                    'sort_order' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
