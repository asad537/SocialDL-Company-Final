<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FaqSeeder extends Seeder
{
    public function run()
    {
        // Clear existing to avoid duplicates if running multiple times
        DB::table('faqs')->truncate();

        // Homepage FAQs
        $homeFaqs = [
            ['question' => 'How can I download videos from any website?', 'answer' => 'Simply copy the video URL from your browser, paste it into the Video Saver search box, and click Download. Our tool will instantly fetch the available formats for you to choose from.', 'sort_order' => 1],
            ['question' => 'How can I download videos via a URL?', 'answer' => 'Copy the direct video URL from any supported platform (YouTube, Instagram, TikTok, etc.), paste it into our input field, select your preferred quality, and hit download. It\'s that simple!', 'sort_order' => 2],
            ['question' => 'How to download WhatsApp Videos?', 'answer' => 'To download WhatsApp videos, open the video in WhatsApp, tap the share icon, copy the link, then paste it into Video Saver. You can then download it in your preferred quality.', 'sort_order' => 3],
            ['question' => 'What is the best all-in-one video downloader?', 'answer' => 'Video Saver is the best all-in-one video downloader supporting YouTube, Instagram, TikTok, Facebook, Twitter, Reddit, and many more platforms — all completely free with no sign-up required.', 'sort_order' => 4],
            ['question' => 'Is Video Saver free to use?', 'answer' => 'Yes! Video Saver is 100% free to use. There are no hidden charges, no subscriptions, and no sign-up required. Simply paste your link and download instantly.', 'sort_order' => 5],
        ];

        foreach ($homeFaqs as $faq) {
            DB::table('faqs')->insert([
                'question'   => $faq['question'],
                'answer'     => $faq['answer'],
                'page'       => 'home',
                'sort_order' => $faq['sort_order'],
                'is_active'  => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Dedicated FAQ Page Content (Categorized)
        $faqPageContent = [
            // Getting Started
            [
                'category' => 'Getting Started',
                'faqs' => [
                    ['q' => 'How does this video downloader work?', 'a' => 'Video Saver works by fetching the direct media file link from the URL you provide. Once you paste a link, our system analyzes the platform and provides you with various download options in different resolutions and formats.'],
                    ['q' => 'Do I need to create an account?', 'a' => 'No. Video Saver is designed for maximum privacy and convenience. You can download any video without registering, signing up, or providing any personal information.'],
                    ['q' => 'Is this service free to use?', 'a' => 'Absolutely. Our service is 100% free. We sustain the platform through minimal ads to keep the servers running without charging our users.'],
                    ['q' => 'Which devices are supported?', 'a' => 'Video Saver is a web-based tool, meaning it works on any device with a browser. You can use it on Windows, macOS, Android, and iOS (iPhone/iPad).'],
                ]
            ],
            // Supported Platforms
            [
                'category' => 'Supported Platforms',
                'faqs' => [
                    ['q' => 'Can I download YouTube videos in 4K?', 'a' => 'Yes, if the original video is available in 4K, Video Saver will provide you with the option to download it in that resolution.'],
                    ['q' => 'Does it work with private Instagram profiles?', 'a' => 'For security and privacy reasons, our downloader can only access public content. We do not support downloading videos from private accounts that you do not have permission to view.'],
                    ['q' => 'Can I download TikTok videos without watermark?', 'a' => 'Yes! One of our most popular features is the ability to download TikTok videos in high quality without any watermark.'],
                ]
            ],
            // Troubleshooting
            [
                'category' => 'Troubleshooting',
                'faqs' => [
                    ['q' => 'Why is my download slow?', 'a' => 'Download speed depends on your internet connection and the responsiveness of the original platform\'s servers. High-resolution videos (4K/1080p) also take longer to process.'],
                    ['q' => 'The video plays instead of downloading?', 'a' => 'On some browsers (like Chrome or Safari), the video might open in a new tab. Simply right-click the video and select "Save Video As..." or use the download button provided in the options menu.'],
                    ['q' => 'Why did my download fail?', 'a' => 'A download might fail if the video has been deleted, is restricted in your region, or if the platform has changed its security settings. Try refreshing the page or using a different browser.'],
                ]
            ],
            // General Questions
            [
                'category' => 'General Questions',
                'faqs' => [
                    ['q' => 'Is there a limit on the number of downloads?', 'a' => 'No. You can download an unlimited number of videos and audio files with Video Saver. We do not impose any daily or monthly limits.'],
                    ['q' => 'What video formats are supported?', 'a' => 'We primarily support MP4 for video and MP3 for audio. Depending on the source, you may also see options for WEBM, M4A, and different resolution tiers.'],
                    ['q' => 'Can I download audio only?', 'a' => 'Yes! For most platforms like YouTube and SoundCloud, Video Saver provides a "Music" section where you can download the audio track as an MP3 file.'],
                    ['q' => 'Is it legal to download videos?', 'a' => 'Downloading videos for personal, offline viewing is generally considered fair use. However, you should not redistribute or use downloaded content for commercial purposes without permission from the creator.'],
                    ['q' => 'How do I save videos to my iPhone?', 'a' => 'On iOS, use the Safari browser. After clicking download, the file will go to your "Downloads" folder in the Files app. You can then move it to your Camera Roll.'],
                    ['q' => 'Are the downloads safe and secure?', 'a' => 'Absolutely. Video Saver does not require any software installation or extensions. All processing happens on our secure servers, and we never store your personal data.'],
                ]
            ]
        ];

        foreach ($faqPageContent as $group) {
            foreach ($group['faqs'] as $index => $faq) {
                DB::table('faqs')->insert([
                    'question'   => $faq['q'],
                    'answer'     => $faq['a'],
                    'category'   => $group['category'],
                    'page'       => 'faq_page',
                    'sort_order' => $index + 1,
                    'is_active'  => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
