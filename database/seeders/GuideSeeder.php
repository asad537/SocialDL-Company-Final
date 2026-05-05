<?php

namespace Database\Seeders;

use App\Models\Guide;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class GuideSeeder extends Seeder
{
    public function run()
    {
        $guides = [
            [
                'title' => 'How to Download Facebook Videos in 4K Quality',
                'description' => 'A complete step-by-step guide on how to save Facebook videos directly to your device in high definition without losing quality.',
                'tags' => 'Facebook',
                'author_name' => 'Admin',
                'reading_time' => '5 min read',
            ],
            [
                'title' => 'The Ultimate Guide to Saving Instagram Reels with Music',
                'description' => 'Learn how to download Instagram Reels with audio intact. We cover the best tools and methods for iOS, Android, and PC.',
                'tags' => 'Instagram',
                'author_name' => 'Admin',
                'reading_time' => '4 min read',
            ],
            [
                'title' => 'How to Remove Watermarks from TikTok Videos',
                'description' => 'Want a clean TikTok video for reposting? This guide shows you how to download TikToks without the jumping watermark easily.',
                'tags' => 'TikTok',
                'author_name' => 'Admin',
                'reading_time' => '6 min read',
            ],
            [
                'title' => 'Download YouTube Playlists in One Click',
                'description' => 'Stop downloading videos one by one. Use our advanced guide to grab entire YouTube playlists and save hours of time.',
                'tags' => 'YouTube',
                'author_name' => 'Admin',
                'reading_time' => '7 min read',
            ],
            [
                'title' => 'Save Twitter (X) Videos to Your Gallery',
                'description' => 'Quick and easy ways to download videos and GIFs from Twitter. Works on mobile and desktop browsers instantly.',
                'tags' => 'Twitter',
                'author_name' => 'Admin',
                'reading_time' => '3 min read',
            ],
        ];

        foreach ($guides as $g) {
            $content = [
                'blocks' => [
                    [
                        'type' => 'header',
                        'data' => ['text' => 'Introduction', 'level' => 2]
                    ],
                    [
                        'type' => 'paragraph',
                        'data' => ['text' => 'In this guide, we will walk you through the most efficient way to ' . strtolower($g['title']) . '. Follow these simple steps to get started.']
                    ],
                    [
                        'type' => 'header',
                        'data' => ['text' => 'Step 1: Copy the URL', 'level' => 3]
                    ],
                    [
                        'type' => 'paragraph',
                        'data' => ['text' => 'First, find the video you want to download and copy its direct URL from the address bar or sharing menu.']
                    ],
                    [
                        'type' => 'header',
                        'data' => ['text' => 'Step 2: Paste and Extract', 'level' => 3]
                    ],
                    [
                        'type' => 'paragraph',
                        'data' => ['text' => 'Paste the link into our downloader tool and click the extract button to see available qualities.']
                    ]
                ]
            ];

            Guide::create([
                'title' => $g['title'],
                'slug' => Str::slug($g['title']),
                'description' => $g['description'],
                'content' => json_encode($content),
                'tags' => $g['tags'],
                'author_name' => $g['author_name'],
                'reading_time' => $g['reading_time'],
                'featured_image' => '/images/placeholder-blog.jpg',
                'status' => 1,
                'meta_description' => $g['description'],
            ]);
        }
    }
}
