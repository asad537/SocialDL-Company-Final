<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Binary Paths
    |--------------------------------------------------------------------------
    */
    'ytdlp_path'   => env('YTDLP_PATH', base_path('venv/bin/yt-dlp')),
    'ytdlp_proxy'  => env('YTDLP_PROXY'),
    'python_path'   => env('PYTHON_PATH', base_path('venv/bin/python3')),
    'ffmpeg_path'   => env('FFMPEG_PATH', '/usr/local/bin/ffmpeg'),
    'ffprobe_path'  => env('FFPROBE_PATH', '/usr/local/bin/ffprobe'),
    'aria2c_path'   => env('ARIA2C_PATH', '/usr/local/bin/aria2c'),

    /*
    |--------------------------------------------------------------------------
    | Storage Paths
    |--------------------------------------------------------------------------
    */
    'download_dir'  => env('DOWNLOAD_DIR', storage_path('app/downloads')),
    'hls_dir'       => env('HLS_DIR', storage_path('app/hls')),
    'temp_dir'      => env('TEMP_DIR', storage_path('app/temp')),

    /*
    |--------------------------------------------------------------------------
    | Cache Settings
    |--------------------------------------------------------------------------
    */
    'cache' => [
        'driver'      => env('DOWNLOADER_CACHE_DRIVER', 'redis'),  // redis | file
        'prefix'      => 'media:',
        'ttl_minutes' => (int) env('DOWNLOADER_CACHE_TTL', 30),     // Redis TTL
        'db_persist'  => true,                                       // Also store in MySQL
    ],

    /*
    |--------------------------------------------------------------------------
    | yt-dlp Extraction Settings
    |--------------------------------------------------------------------------
    */
    'extraction' => [
        'timeout'        => 15,     // seconds max for extraction
        'socket_timeout' => 8,
        'retries'        => 2,
        'no_check_cert'  => true,
        'geo_bypass'     => true,
        'user_agent'     => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36',

        // Platform-specific extractor args for speed
        'extractor_args' => [
            // 'youtube' => 'youtube:player_client=web,mweb',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | aria2c Download Settings
    |--------------------------------------------------------------------------
    */
    'aria2c' => [
        'connections'    => 16,      // -x 16
        'splits'         => 16,      // -s 16
        'min_split_size' => '1M',    // -k 1M
        'timeout'        => 120,
        'max_retries'    => 5,
        'retry_wait'     => 3,
    ],

    /*
    |--------------------------------------------------------------------------
    | FFmpeg Settings
    |--------------------------------------------------------------------------
    */
    'ffmpeg' => [
        'hls_time'       => 6,        // segment duration in seconds
        'hls_list_size'  => 0,        // 0 = all segments in playlist
    ],

    /*
    |--------------------------------------------------------------------------
    | Cleanup Settings
    |--------------------------------------------------------------------------
    */
    'cleanup' => [
        'max_age_hours'   => 24,     // delete files older than this
        'run_every_hours' => 1,      // cleanup cron frequency
    ],

    /*
    |--------------------------------------------------------------------------
    | Rate Limiting
    |--------------------------------------------------------------------------
    */
    'rate_limits' => [
        'extract'        => '30,1',  // 30 per minute
        'download'       => '10,1',  // 10 per minute
        'merge'          => '5,1',   // 5 per minute
        'stream'         => '60,1',  // 60 per minute
    ],

    /*
    |--------------------------------------------------------------------------
    | Referer Map (for CDN authentication)
    |--------------------------------------------------------------------------
    */
    'referers' => [
        'Instagram'   => 'https://www.instagram.com/',
        'TikTok'      => 'https://www.tiktok.com/',
        'Facebook'    => 'https://www.facebook.com/',
        'Twitter'     => 'https://twitter.com/',
        'Pinterest'   => 'https://www.pinterest.com/',
        'Vimeo'       => 'https://vimeo.com/',
        'Dailymotion' => 'https://www.dailymotion.com/',
        'YouTube'     => 'https://www.youtube.com/',
        'Reddit'      => 'https://www.reddit.com/',
        'Twitch'      => 'https://www.twitch.tv/',
        'SoundCloud'  => 'https://soundcloud.com/',
    ],

    /*
    |--------------------------------------------------------------------------
    | RapidAPI Settings
    |--------------------------------------------------------------------------
    */
    'rapidapi' => [
        'key'      => env('RAPIDAPI_KEY'),
        'host'     => env('RAPIDAPI_HOST', 'social-download-all-in-one.p.rapidapi.com'),
        'base_url' => env('RAPIDAPI_BASE_URL', 'https://social-download-all-in-one.p.rapidapi.com/'),
        'path'     => 'v1/social/autolink',
    ],
];
