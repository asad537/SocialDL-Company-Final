<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $platform->meta_title ?: $platform->name . ' - Video Saver' }}</title>
    <meta name="description" content="{{ $platform->meta_description }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --primary: #FFB800;
            --primary-hover: #E5A600;
            --text-dark: #111827;
            --text-gray: #4B5563;
            --bg-light: #FFFFFF;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            background-color: var(--bg-light);
            color: var(--text-dark);
            overflow-x: hidden;
            top: 0 !important;
        }

        .container {
            width: 100%;
            max-width: 1100px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* ── Hero ── */
        .hero {
            position: relative;
            width: 100%;
            height: 35vw;
            /* Height scales with width to maintain aspect ratio */
            min-height: 450px;
            max-height: 650px;
            display: flex;
            align-items: center;
            padding: 2vw 0;
            overflow: hidden;
            background-color: #fff5f6;
        }

        /* BG image — Exactly like homepage */
        .hero-bg-img {
            position: absolute;
            top: 0;
            right: 0;
            width: 100%;
            height: 100%;
            object-fit: contain;
            object-position: center right;
            z-index: 0;
        }

        .hero picture {
            display: block;
            line-height: 0;
        }

        .hero-container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
            position: relative;
            z-index: 2;
        }

        .hero-content {
            max-width: 45%;
            margin-top: 110px;
        }

        .hero h1 {
            font-size: 2rem;
            font-weight: 600;
            line-height: 1.2;
            color: #111827;
            margin-bottom: 2rem;
        }

        .hero-subtext {
            font-size: 1.05rem;
            color: #111827;
            line-height: 1.5;
            margin-bottom: 2.5rem;
            max-width: 600px;
            font-weight: 500;
        }

        .hero-mobile-title,
        .hero-mobile-actions {
            display: none;
        }

        @media (max-width: 1024px) {
            .hero {
                text-align: center;
                padding: 8rem 0 300px 0;
                height: auto;
                min-height: 600px;
            }

            .hero-bg-img {
                object-position: center bottom;
                object-fit: contain;
            }

            .hero-content {
                max-width: 100%;
            }

            .hero h1 {
                font-size: 2.2rem;
            }
        }

        /* ── Search Section ── */
        @media (max-width: 768px) {
            .hero {
                display: block;
                height: auto;
                min-height: 0;
                max-height: none;
                padding: 0 0 1.35rem;
                margin-top: 84px;
                overflow: hidden;
                background: #fff;
                text-align: center;
            }

            .hero-bg-img {
                position: relative;
                top: auto;
                right: auto;
                display: block;
                width: 100%;
                height: 100%;
                object-fit: cover;
                object-position: center top;
                z-index: 0;
            }

            .hero picture {
                height: clamp(500px, 102vw, 590px);
                overflow: hidden;
            }

            .hero-container {
                max-width: 620px;
                padding: 0 2rem;
            }

            .hero-content {
                max-width: 100%;
                margin: 1.25rem auto 0;
            }

            .hero-kicker,
            .hero-desktop-title {
                display: none !important;
            }

            .hero-mobile-title,
            .hero-mobile-actions {
                display: block;
            }

            .hero h1 {
                font-size: clamp(2rem, 5.9vw, 2.35rem);
                font-weight: 800;
                line-height: 1.2;
                color: #000;
                margin: 0 auto 1.25rem;
                max-width: 500px;
                text-align: center;
            }

            .hero-subtext {
                font-size: clamp(1.12rem, 4.1vw, 1.5rem);
                line-height: 1.55;
                color: #000;
                max-width: 530px;
                margin: 0 auto 1.65rem;
                font-weight: 400;
                text-align: center;
            }

            .hero-mobile-actions {
                display: grid;
                grid-template-columns: repeat(3, minmax(0, 1fr));
                gap: clamp(0.85rem, 3vw, 1.25rem);
                width: 100%;
                margin: 0 auto;
            }

            .hero-mobile-pill {
                min-height: 50px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                gap: 0.55rem;
                padding: 0.75rem 0.65rem;
                border-radius: 999px;
                background: #fff;
                color: #000;
                font-size: clamp(0.95rem, 3.2vw, 1.13rem);
                font-weight: 800;
                line-height: 1;
                box-shadow: 0 5px 14px rgba(15, 23, 42, 0.13);
                white-space: nowrap;
            }

            .hero-mobile-pill i {
                color: #FFB800;
                font-size: clamp(1.05rem, 3.6vw, 1.3rem);
            }
        }

        @media (max-width: 430px) {
            .hero {
                margin-top: 78px;
            }

            .hero-container {
                padding: 0 1.45rem;
            }

            .hero-content {
                margin-top: 1.05rem;
            }

            .hero-subtext {
                margin-bottom: 1.35rem;
            }

            .hero-mobile-actions {
                gap: 0.65rem;
            }

            .hero-mobile-pill {
                min-height: 46px;
                padding: 0.65rem 0.4rem;
                gap: 0.42rem;
            }
        }

        .search-section {
            padding: 5rem 0;
            text-align: center;
            background: white;
        }

        .search-section h2 {
            font-size: 2rem;
            font-weight: 800;
            margin-bottom: 2.5rem;
            color: var(--text-dark);
        }

        .search-box-wrap {
            max-width: 800px;
            margin: 0 auto;
            position: relative;
        }

        .search-container {
            background: white;
            border: 2px solid var(--primary);
            border-radius: 16px;
            padding: 8px;
            display: flex;
            align-items: center;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .search-container i.fa-globe {
            margin-left: 1.5rem;
            color: #9CA3AF;
            font-size: 1.2rem;
        }

        .search-container input {
            flex: 1;
            border: none;
            outline: none;
            padding: 1rem 1.5rem;
            font-size: 1rem;
            font-weight: 500;
        }

        .search-container button {
            background: var(--primary);
            color: var(--text-dark);
            border: none;
            padding: 12px 30px;
            border-radius: 12px;
            font-weight: 700;
            font-size: 1rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 12px;
            transition: all 0.2s;
        }

        .search-container button i {
            width: 26px;
            height: 26px;
            border: 2px solid #000;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
        }

        .search-container button:hover {
            background: #000;
            color: var(--primary);
        }

        .search-container button:hover i {
            border-color: var(--primary);
        }

        .tutorial-wrap {
            text-align: center;
            margin-top: 1.5rem;
        }

        .tutorial-link {
            color: #007BFF;
            font-weight: 700;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .tutorial-link .yt-icon {
            color: #FF0000;
            font-size: 1.6rem;
        }

        .tutorial-link .tutorial-text {
            border-bottom: 2px solid #007BFF;
            padding-bottom: 2px;
        }

        .tutorial-link .tutorial-sub {
            color: #6B7280;
            font-weight: 500;
        }

        @media (max-width: 768px) {
            .search-section {
                padding: 2.2rem 0;
            }

            .search-section h2 {
                font-size: clamp(1.75rem, 8vw, 2.2rem);
                line-height: 1.2;
                margin-bottom: 1rem;
                text-align: left;
            }

            .search-box-wrap {
                max-width: 100%;
            }

            .search-container {
                padding: 6px;
                border-radius: 14px;
                gap: 0.35rem;
            }

            .search-container i.fa-globe {
                margin-left: 0.7rem;
                font-size: 1rem;
            }

            .search-container input {
                min-width: 0;
                width: 1%;
                flex: 1 1 auto;
                padding: 0.65rem 0.35rem;
                font-size: 1rem;
            }

            .search-container button {
                flex: 0 0 auto;
                white-space: nowrap;
                padding: 8px 12px;
                border-radius: 10px;
                font-size: 0.92rem;
                gap: 6px;
            }

            .search-container button i {
                width: 22px;
                height: 22px;
                font-size: 0.68rem;
            }

            .tutorial-wrap {
                text-align: left;
                margin-top: 1rem;
            }

            .tutorial-link {
                gap: 6px;
                flex-wrap: wrap;
                font-size: 0.95rem;
            }

            .tutorial-link .yt-icon {
                font-size: 1.2rem;
            }
        }

        @media (max-width: 430px) {
            .search-section h2 {
                font-size: clamp(1.45rem, 7.4vw, 1.9rem);
            }

            .search-container {
                gap: 0.2rem;
            }

            .search-container i.fa-globe {
                margin-left: 0.5rem;
            }

            .search-container input {
                padding: 0.55rem 0.2rem;
                font-size: 0.95rem;
            }

            .search-container button {
                padding: 8px 9px;
                font-size: 0.84rem;
                gap: 4px;
            }

            .search-container button i {
                width: 20px;
                height: 20px;
            }

            .tutorial-link {
                font-size: 0.86rem;
            }
        }

        /* ── Loader & Results ── */
        .loader-box {
            display: none;
            text-align: center;
            padding: 3rem;
        }

        .spinner {
            width: 45px;
            height: 45px;
            border: 4px solid #f3f3f3;
            border-top: 4px solid var(--primary);
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        #results {
            display: none;
            flex-direction: column;
            gap: 20px;
            background: #fff;
            padding: 25px;
            border: 1px solid #eee;
            border-radius: 24px;
            margin: 2rem auto 4rem;
            max-width: 1100px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.03);
        }

        /* ── Platform Content ── */
        .content-section {
            padding: 3rem 0 5rem;
        }

        .editor-content {
            font-size: 1.05rem;
            line-height: 1.8;
            color: #334155;
        }

        .editor-content h2 {
            margin-top: 2rem;
            margin-bottom: 1rem;
        }

        /* ── FAQs ── */
        .faq-section {
            padding: 4rem 0;
            border-top: 1px solid #f1f5f9;
            background: #fafafa;
        }

        .faq-wrap {
            border: 1.5px solid #EBEBEB;
            border-radius: 16px;
            overflow: hidden;
            background: #fff;
            margin-bottom: 0.8rem;
        }

        .faq-btn {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1.2rem 1.5rem;
            background: transparent;
            border: none;
            cursor: pointer;
            font-size: 1rem;
            font-weight: 700;
            color: #111827;
            text-align: left;
        }

        .faq-body {
            max-height: 0;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .faq-body p {
            padding: 0 1.5rem 1.2rem;
            font-size: 0.95rem;
            color: #6B7280;
            line-height: 1.7;
        }

        .why-choose-section {
            padding: 3rem 0;
            background: #fff;
        }

        .why-choose-heading {
            text-align: center;
            margin-bottom: 2.5rem;
        }

        .why-choose-heading h2 {
            font-size: 1.8rem;
            font-weight: 800;
            color: #0F0F0F;
            margin-bottom: 0.75rem;
            letter-spacing: -0.02em;
        }

        .why-choose-heading p {
            font-size: 0.93rem;
            color: #6B7280;
            max-width: 620px;
            margin: 0 auto;
            line-height: 1.75;
        }

        .why-choose-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 1.2rem;
        }

        .why-choose-card {
            background: #fff;
            border: 1.5px solid #F0F1F3;
            border-radius: 18px;
            padding: 1.5rem 1.8rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .why-choose-card-icon {
            width: 60px;
            height: 60px;
            background: #FEF3C7;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
        }

        .why-choose-card-icon img {
            width: 35px;
            height: 35px;
            object-fit: contain;
        }

        .why-choose-card h3 {
            font-size: 1rem;
            font-weight: 800;
            color: #0F172A;
            margin-bottom: 0.45rem;
        }

        .why-choose-card p {
            font-size: 0.875rem;
            color: #6B7280;
            line-height: 1.65;
            margin: 0;
            text-align: left;
        }

        .download-cta-section {
            padding: 1.5rem 0 4rem;
            background: #fff;
        }

        .download-cta-card {
            background: #FFC107;
            border-radius: 28px;
            padding: 2.2rem 3.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 2rem;
            flex-wrap: wrap;
        }

        .download-cta-content {
            flex: 1;
            min-width: 300px;
        }

        .download-cta-content h2 {
            font-size: 2rem;
            font-weight: 800;
            color: #111827;
            margin-bottom: 0.5rem;
            letter-spacing: -0.01em;
        }

        .download-cta-content p {
            font-size: 1rem;
            color: #111827;
            font-weight: 500;
            margin: 0;
            opacity: 0.9;
            line-height: 1.5;
        }

        .download-cta-btn {
            background: #FF6807;
            color: #fff;
            text-decoration: none;
            padding: 1rem 2.2rem;
            border-radius: 50px;
            font-weight: 800;
            font-size: 1rem;
            box-shadow: 0 8px 20px rgba(255, 94, 20, 0.25);
            transition: all 0.3s ease;
            white-space: nowrap;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        @media (max-width: 768px) {
            .download-cta-section {
                padding: 1.25rem 0 2.4rem;
            }

            .download-cta-card {
                border-radius: 30px;
                padding: 2rem 1.35rem 2.2rem;
                gap: 1.3rem;
                justify-content: center;
            }

            .download-cta-content {
                min-width: 0;
                width: 100%;
            }

            .download-cta-content h2 {
                font-size: clamp(2rem, 10vw, 2.6rem);
                line-height: 1.1;
                margin-bottom: 0.75rem;
                text-align: left;
            }

            .download-cta-content p {
                font-size: clamp(1rem, 4.8vw, 1.3rem);
                line-height: 1.42;
                text-align: left;
            }

            .download-cta-btn {
                width: 100%;
                max-width: 360px;
                min-height: 54px;
                border-radius: 999px;
                font-size: clamp(1rem, 4.4vw, 1.25rem);
                padding: 0.9rem 1.2rem;
            }
        }

        @media (max-width: 991px) {
            .why-choose-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 768px) {
            .why-choose-section {
                padding: 2rem 0;
            }

            .why-choose-heading {
                margin-bottom: 1.4rem;
            }

            .why-choose-heading h2 {
                font-size: 1.9rem;
                line-height: 1.15;
            }

            .why-choose-heading p {
                font-size: 0.95rem;
                line-height: 1.6;
            }

            .why-choose-grid {
                grid-template-columns: 1fr;
                gap: 0.95rem;
            }

            .why-choose-card {
                padding: 1.2rem 1.05rem;
            }
        }
    </style>
</head>

<body>

    @include('partials.header')

    <section class="hero">
        <picture>
            <source media="(max-width: 768px)" srcset="/images/mobile/support-hero.jpg">
            <img class="hero-bg-img" src="/images/supporteds.jpg" alt="">
        </picture>
        <div class="hero-container">
            <div class="hero-content">
                <div class="hero-kicker"
                    style="display: inline-flex; align-items: center; gap: 8px; background: #ffffff; padding: 6px 14px; border-radius: 50px; font-size: 0.8rem; font-weight: 800; color: #FFB800; text-transform: uppercase; margin-bottom: 1.2rem; box-shadow: 0 4px 10px rgba(0,0,0,0.05); border: 1px solid #FFB800;">
                    <i class="fas fa-rocket"></i> SUPPORTED PLATFORMS
                </div>
                <h1 class="hero-desktop-title">{{ $platform->h1 ?? 'Download Videos Instantly' }}</h1>
                <h1 class="hero-mobile-title">Works on Your<br>Favourite Platforms</h1>
                <p class="hero-subtext">Our app lets you download videos from all your favourite social platforms fast,
                    easy &amp; seamless.</p>
                <div class="hero-mobile-actions">
                    <div class="hero-mobile-pill"><i class="fas fa-bolt"></i> Fast</div>
                    <div class="hero-mobile-pill"><i class="fas fa-award"></i> Quality</div>
                    <div class="hero-mobile-pill"><i class="fas fa-user-shield"></i> Secure</div>
                </div>
            </div>
        </div>
    </section>

    <section class="search-section">
        <div class="container">
            <h2>Paste Your Link & Download Instantly</h2>
            <div class="search-box-wrap">
                <div class="search-container">
                    <i class="fas fa-globe"></i>
                    <input type="text" id="videoUrl" placeholder="Paste your link here">
                    <button id="fetchBtn"><i><i class="fas fa-arrow-down"></i></i> Download</button>
                </div>
            </div>
            <div class="tutorial-wrap">
                <a href="#" class="tutorial-link">
                    <i class="fab fa-youtube yt-icon"></i>
                    <span class="tutorial-text">How to download?</span>
                    <span class="tutorial-sub">Watch the tutorial</span>
                </a>
            </div>

            <div class="loader-box" id="loader">
                <div class="spinner"></div>
                <p style="margin-top:15px; font-weight:600; color:#6B7280;">Connecting to platform...</p>
            </div>

            <div id="error"
                style="display:none; color:#EF4444; background:#FEF2F2; padding:15px; border-radius:12px; margin-top:2rem; font-weight:600; border:1px solid #FEE2E2;">
            </div>

            <div id="results">
                {{-- Results will be rendered here --}}
            </div>
        </div>
    </section>

    @if(!empty($platform->content))
        <section class="content-section">
            <div class="container">
                <div class="editor-content">
                    {!! App\Models\Blog::renderEditorJS($platform->content) !!}
                </div>
            </div>
        </section>
    @endif

    <!-- Why Millions Choose Video Saver -->
    <section class="why-choose-section">
        <div class="hero-container" style="max-width: 1050px;">

            <div class="why-choose-heading">
                <h2>Why Millions Choose Video Saver</h2>
                <p>
                    Video Saver makes it effortless to download videos, audio, reels, shorts, and photos in just a few
                    clicks. Built for speed, privacy, and a smooth experience, it works seamlessly across both mobile
                    and desktop browsers.
                </p>
            </div>

            <div class="why-choose-grid">

                <!-- Card 1 -->
                <div class="why-choose-card">
                    <div class="why-choose-card-icon">
                        <img src="/images/icon-rocket.svg" alt="Instant">
                    </div>
                    <h3>Instant Link Analysis</h3>
                    <p>Paste a
                        link and get results in seconds — often faster than other downloaders.</p>
                </div>

                <!-- Card 2 -->
                <div class="why-choose-card">
                    <div class="why-choose-card-icon">
                        <img src="/images/icon-globe.svg" alt="Multilingual">
                    </div>
                    <h3>Multilingual Experience</h3>
                    <p>Use HD
                        Video Downloader in multiple languages, including English, Spanish, Hindi, and more.</p>
                </div>

                <!-- Card 3 -->
                <div class="why-choose-card">
                    <div class="why-choose-card-icon">
                        <img src="/images/icon-download.svg" alt="Quality">
                    </div>
                    <h3>Flexible Quality Choices</h3>
                    <p>Pick the
                        quality you want from 144p up to 1080p+ (4K) when available.</p>
                </div>

                <!-- Card 4 -->
                <div class="why-choose-card">
                    <div class="why-choose-card-icon">
                        <img src="/images/icon-layers.svg" alt="Platform">
                    </div>
                    <h3>Wide Platform Support</h3>
                    <p>Supports
                        YouTube, TikTok, Instagram, Facebook, and more.</p>
                </div>

                <!-- Card 5 -->
                <div class="why-choose-card">
                    <div class="why-choose-card-icon">
                        <img src="/images/icon-settings.svg" alt="Device">
                    </div>
                    <h3>Works on Any Device</h3>
                    <p>Download
                        seamlessly on mobile, tablet, or desktop — no extra apps needed.</p>
                </div>

                <!-- Card 6 -->
                <div class="why-choose-card">
                    <div class="why-choose-card-icon">
                        <img src="/images/icon-shield.png" alt="Privacy">
                    </div>
                    <h3>Privacy-First by Design</h3>
                    <p>Your
                        privacy matters. Processing happens locally, with no data storage and reduced security risk.</p>
                </div>

            </div>
        </div>
    </section>

    @if(count($faqs) > 0)
        <section class="faq-section">
            <div class="container" style="max-width: 850px;">
                <h2 style="text-align:center; font-size: 2rem; font-weight: 800; margin-bottom: 2.5rem;">Frequently Asked
                    Questions</h2>
                <div class="faq-list">
                    @foreach($faqs as $faq)
                        <div class="faq-wrap">
                            <button class="faq-btn" onclick="toggleFaq(this)">
                                <span>{{ $faq->question }}</span>
                                <i class="fas fa-plus"></i>
                            </button>
                            <div class="faq-body">
                                <p>{{ $faq->answer }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- Download CTA Section -->
    <section class="download-cta-section">
        <div class="container" style="max-width: 1100px;">
            <div class="download-cta-card">
                <div class="download-cta-content">
                    <h2>Ready to Start Downloading?</h2>
                    <p>Join millions of users who rely on HD Video Saver for fast, easy, and reliable downloads</p>
                </div>
                <a href="https://play.google.com/store/apps/details?id=com.jmdsol.videodownloader.videosaver"
                    class="download-cta-btn"
                    onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 12px 25px rgba(255, 94, 20, 0.35)';"
                    onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 8px 20px rgba(255, 94, 20, 0.25)';">
                    Download Video Saver
                </a>
            </div>
        </div>
    </section>

    @include('partials.footer')

    <script>
        function toggleFaq(btn) {
            const body = btn.nextElementSibling;
            const icon = btn.querySelector('i');
            const isOpen = body.style.maxHeight && body.style.maxHeight !== '0px';

            document.querySelectorAll('.faq-body').forEach(b => b.style.maxHeight = '0px');
            document.querySelectorAll('.faq-btn i').forEach(i => { i.classList.replace('fa-times', 'fa-plus'); });

            if (!isOpen) {
                body.style.maxHeight = body.scrollHeight + 'px';
                icon.classList.replace('fa-plus', 'fa-times');
            }
        }

        const input = document.getElementById('videoUrl');
        const fetchBtn = document.getElementById('fetchBtn');
        const loader = document.getElementById('loader');
        const resultsBox = document.getElementById('results');
        const errorDiv = document.getElementById('error');
        const csrf = document.querySelector('meta[name="csrf-token"]').content;

        async function fetchVideo(url) {
            if (!url) return;
            loader.style.display = 'block';
            resultsBox.style.display = 'none';
            errorDiv.style.display = 'none';

            try {
                const res = await fetch('/extract', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf },
                    body: JSON.stringify({ url })
                });
                const data = await res.json();
                if (data.error) throw new Error(data.error);
                renderResults(data);
            } catch (e) {
                errorDiv.textContent = e.message;
                errorDiv.style.display = 'block';
            } finally {
                loader.style.display = 'none';
            }
        }

        fetchBtn.addEventListener('click', () => fetchVideo(input.value.trim()));
        input.addEventListener('keydown', e => { if (e.key === 'Enter') fetchVideo(input.value.trim()); });

        function renderResults(data) {
            const videoMedias = data.medias.filter(m => m.type === 'video');
            const audioMedias = data.medias.filter(m => m.type === 'audio');

            function renderRow(m, title) {
                const dlUrl = `/proxy-download?url=${encodeURIComponent(m.url)}&title=${encodeURIComponent(title)}&ext=${m.extension}`;
                return `
                    <div style="display:grid; grid-template-columns: 60px 80px 100px 1fr; align-items:center; background:#fff; padding:12px 0; border-bottom:1px solid #F3F4F6;">
                        <span style="background:#00C853; color:#fff; padding:4px 0; border-radius:5px; font-size:0.75rem; font-weight:800; text-align:center; width:50px;">${m.extension.toUpperCase()}</span>
                        <span style="font-weight:700; color:#111827; font-size:0.9rem;">${m.quality}</span>
                        <span style="color:#6B7280; font-size:0.85rem; font-weight:600;">${m.size || ''}</span>
                        <a href="${dlUrl}" style="background:#fff; color:#000; border:2px solid #FFB800; text-decoration:none; padding:8px 22px; border-radius:10px; font-weight:700; font-size:0.85rem; display:flex; align-items:center; gap:10px; transition:0.2s; width:fit-content; justify-self:end;">
                            <i class="fas fa-download" style="color:#FFB800; font-size:0.95rem;"></i> Download
                        </a>
                    </div>
                `;
            }

            let html = `
                <div style="display:flex; gap:40px; flex-wrap:wrap; align-items:flex-start; text-align:left;">
                    <!-- Sidebar -->
                    <div style="width: 280px; flex-shrink: 0;">
                        <div style="width:100%; aspect-ratio:16/9; border-radius:12px; overflow:hidden; margin-bottom:15px; background:#f3f4f6;">
                            <img src="/thumbnail-proxy?url=${encodeURIComponent(data.thumbnail)}" style="width:100%; height:100%; object-fit:cover;">
                        </div>
                        <h3 style="font-weight:700; font-size:1.05rem; margin-bottom:15px; line-height:1.4; color:#111827;">${data.title}</h3>
                        <span style="background:#FFE082; color:#000; padding:6px 14px; border-radius:10px; font-weight:800; font-size:0.85rem; display:inline-flex; align-items:center; gap:8px;">
                            <i class="far fa-clock"></i> ${data.duration || '00:00'}
                        </span>
                    </div>

                    <!-- Content Area -->
                    <div style="flex:1; min-width:300px;">
                        <!-- Video Section -->
                        <div style="display:flex; align-items:center; gap:12px; margin-bottom:10px; border-bottom:2px solid #F3F4F6; padding-bottom:10px;">
                            <i class="fas fa-film" style="color:#FFB800; font-size:1.3rem;"></i>
                            <h4 style="font-weight:800; font-size:1.3rem; color:#111827;">Video</h4>
                        </div>
                        <div style="display:flex; flex-direction:column; margin-bottom:35px;">
                            ${videoMedias.length ? videoMedias.map(m => renderRow(m, data.title)).join('') : '<p style="color:#6B7280; font-size:0.9rem;">No video formats available.</p>'}
                        </div>

                        <!-- Music Section -->
                        <div style="display:flex; align-items:center; gap:12px; margin-bottom:10px; border-bottom:2px solid #F3F4F6; padding-bottom:10px;">
                            <i class="fas fa-music" style="color:#FFB800; font-size:1.3rem;"></i>
                            <h4 style="font-weight:800; font-size:1.3rem; color:#111827;">Music</h4>
                        </div>
                        <div style="display:flex; flex-direction:column;">
                            ${audioMedias.length ? audioMedias.map(m => renderRow(m, data.title)).join('') : '<p style="color:#6B7280; font-size:0.9rem;">No audio formats available.</p>'}
                        </div>
                    </div>
                </div>
            `;

            resultsBox.innerHTML = html;
            resultsBox.style.display = 'block';
        }

        // Auto-Hide Google Translate Banner
        setInterval(function () {
            const banner = document.querySelector('.goog-te-banner-frame');
            if (banner) banner.remove();
            document.body.style.top = '0px';
        }, 500);
    </script>
</body>

</html>
