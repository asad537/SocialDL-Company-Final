<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Preload hero image for instant LCP -->
    <link rel="preload" as="image" href="/images/supporteds.webp" type="image/webp" fetchpriority="high">
    <link rel="icon" type="image/webp" href="/images/Fav-logo.webp">
    <link rel="apple-touch-icon" href="/images/logofinal.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $platform->meta_title ?: $platform->name . ' - Video Saver' }}</title>
    <meta name="description" content="{{ $platform->meta_description }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- JSON-LD Schemas for Platform Page -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "Organization",
      "name": "Video Saver",
      "alternateName": [
        "HD Video Saver",
        "HDVideoSaver",
        "HVS Downloader"
      ],
      "url": "https://hdvideosaver.com",
      "logo": {
        "@type": "ImageObject",
        "url": "https://hdvideosaver.com/images/logofinal.png"
      },
      "description": "Video Saver is a free online video downloader that lets users download videos, reels, shorts, and audio clips in MP4 or MP3 format from supported platforms.",
      "sameAs": [
        "https://play.google.com/store/apps/details?id=com.jmdsol.videodownloader.videosaver"
      ]
    }
    </script>
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "WebSite",
      "name": "Video Saver",
      "alternateName": [
        "HD Video Saver",
        "HDVideoSaver",
        "HVS Downloader"
      ],
      "url": "https://hdvideosaver.com",
      "description": "Video Saver is a free online video downloader that lets users download videos, reels, shorts, and audio clips in MP4 or MP3 format from supported platforms.",
      "publisher": {
        "@id": "https://hdvideosaver.com/#organization"
      }
    }
    </script>
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "SoftwareApplication",
      "name": "Video Saver",
      "alternateName": [
        "HD Video Saver",
        "HDVideoSaver",
        "HVS Downloader"
      ],
      "description": "Video Saver is a free online video downloader that lets users download videos, reels, shorts, and audio clips in MP4 or MP3 format from supported platforms.",
      "operatingSystem": "Windows, macOS, Linux, Android, iOS",
      "applicationCategory": "MultimediaApplication",
      "url": "https://hdvideosaver.com",
      "downloadUrl": "https://play.google.com/store/apps/details?id=com.jmdsol.videodownloader.videosaver",
      "offers": {
        "@type": "Offer",
        "price": "0",
        "priceCurrency": "USD"
      },
      "publisher": {
        "@id": "https://hdvideosaver.com/#organization"
      }
    }
    </script>
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "BreadcrumbList",
      "itemListElement": [
        {
          "@type": "ListItem",
          "position": 1,
          "name": "Home",
          "item": "https://hdvideosaver.com"
        },
        {
          "@type": "ListItem",
          "position": 2,
          "name": "{{ $platform->name }}",
          "item": "{{ url('/' . $platform->slug) }}/"
        }
      ]
    }
    </script>
    @if(count($faqs) > 0)
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "FAQPage",
      "name": "Frequently Asked Questions - {{ $platform->name }}",
      "url": "{{ url('/' . $platform->slug) }}/",
      "publisher": {
        "@id": "https://hdvideosaver.com/#organization"
      },
      "mainEntity": [
        @foreach($faqs as $index => $faq)
        {
          "@type": "Question",
          "name": "{{ strip_tags($faq->question) }}",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "{{ strip_tags($faq->answer) }}"
          }
        }{{ !$loop->last ? ',' : '' }}
        @endforeach
      ]
    }
    </script>
    @endif

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
            font-weight: 800;
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


        /* --- Shared UI CSS --- */

        .why-choose-section {
            padding: 3rem 0;
            background: #ffffff;
        }

        .why-choose-container {
            max-width: 1050px;
        }

        .why-choose-header {
            text-align: center;
            margin-bottom: 2.5rem;
        }

        .why-choose-title {
            font-size: 1.8rem;
            font-weight: 800;
            color: #0F0F0F;
            margin-bottom: 0.75rem;
            letter-spacing: -0.02em;
        }

        .why-choose-desc {
            font-size: 0.93rem;
            color: #000;
            max-width: 620px;
            margin: 0 auto;
            line-height: 1.75;
            text-align: center !important;
        }

        .why-choose-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 1.2rem;
        }

        .why-choose-card {
            background: #ffffff;
            border: 1.5px solid #FFB800;
            border-radius: 18px;
            padding: 1.5rem 1.8rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .why-choose-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 10px 25px rgba(255, 184, 0, 0.15);
        }

        .why-choose-icon {
            width: 60px;
            height: 60px;
            background: #FEF3C7;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
        }

        .why-choose-icon img {
            width: 35px;
            height: 35px;
            object-fit: contain;
        }

        .why-choose-card span.why-choose-card-title {
            display: block;
            font-size: 1rem;
            font-weight: 800;
            color: #0F172A;
            margin-bottom: 0.45rem;
            text-align: left !important;
        }

        .why-choose-card p {
            font-size: 0.875rem;
            color: #000;
            line-height: 1.45;
            margin: 0;
            text-align: left !important;
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

            .why-choose-header {
                margin-bottom: 1.4rem;
                text-align: left;
            }

            .why-choose-title {
                font-size: 1.35rem;
                margin-bottom: 0.6rem;
            }

            .why-choose-desc {
                max-width: 100%;
                margin: 0;
                font-size: 0.92rem;
                line-height: 1.6;
                text-align: left !important;
            }

            .why-choose-grid {
                grid-template-columns: 1fr;
                gap: 0.95rem;
            }

            .why-choose-card {
                border-radius: 16px;
                padding: 1.25rem 1.2rem;
            }
        }
    </style>
</head>

<body>

    @include('partials.header')

    <section class="hero">
        <picture>
            <source media="(max-width: 768px)" srcset="/images/mobile/support-hero.jpg">
            <source srcset="/images/supporteds.webp" type="image/webp">
            <img class="hero-bg-img" src="/images/supporteds.jpg" alt="Supported Platforms" fetchpriority="high" loading="eager">
        </picture>
        <div class="hero-container">
            <div class="hero-content">
                <div class="hero-kicker"
                    style="display: inline-flex; align-items: center; gap: 8px; background: #ffffff; padding: 6px 14px; border-radius: 50px; font-size: 0.8rem; font-weight: 800; color: #FFB800; text-transform: uppercase; margin-bottom: 1.2rem; box-shadow: 0 4px 10px rgba(0,0,0,0.05); border: 1px solid #FFB800;">
                    <i class="fas fa-rocket"></i> SUPPORTED PLATFORMS
                </div>
                <h1 class="hero-desktop-title">{{ $platform->h1 ?? 'Download Videos Instantly' }}</h1>
                <h1 class="hero-mobile-title">Works on Your Favourite Platforms</h1>
                <p class="hero-subtext" style="line-height: 1.45;">Our app lets you download videos from all your favourite social platforms fast,
                    easy &amp; seamless.</p>
                <div class="hero-mobile-actions">
                    <div class="hero-mobile-pill"><i class="fas fa-bolt"></i> Fast</div>
                    <div class="hero-mobile-pill"><i class="fas fa-award"></i> Quality</div>
                    <div class="hero-mobile-pill"><i class="fas fa-user-shield"></i> Secure</div>
                </div>
            </div>
        </div>
    </section>

    @include('partials.downloader')

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
        <div class="hero-container why-choose-container">

            <div class="why-choose-header">
                <h2 class="why-choose-title">Why Millions Choose Video Saver</h2>
                <p class="why-choose-desc" style="line-height: 1.45;">
                    Video Saver makes it effortless to download videos, audio, reels, shorts, and photos in just a few
                    clicks. Built for speed, privacy, and a smooth experience, it works seamlessly across both mobile
                    and desktop browsers.
                </p>
            </div>

            <div class="why-choose-grid">

                <!-- Card 1 -->
                <div class="why-choose-card">
                    <div class="why-choose-icon">
                        <img src="/images/icon-rocket.svg" alt="Instant">
                    </div>
                    <span class="why-choose-card-title">Instant Link Analysis</span>
                    <p style="line-height: 1.45;">Paste a
                        link and get results in seconds — often faster than other downloaders.</p>
                </div>

                <!-- Card 2 -->
                <div class="why-choose-card">
                    <div class="why-choose-icon">
                        <img src="/images/icon-globe.svg" alt="Multilingual">
                    </div>
                    <span class="why-choose-card-title">Multilingual Experience</span>
                    <p style="line-height: 1.45;">Use HD
                        Video Downloader in multiple languages, including English, Spanish, Hindi, and more.</p>
                </div>

                <!-- Card 3 -->
                <div class="why-choose-card">
                    <div class="why-choose-icon">
                        <img src="/images/icon-download.svg" alt="Quality">
                    </div>
                    <span class="why-choose-card-title">Flexible Quality Choices</span>
                    <p style="line-height: 1.45;">Pick the
                        quality you want from 144p up to 1080p+ (4K) when available.</p>
                </div>

                <!-- Card 4 -->
                <div class="why-choose-card">
                    <div class="why-choose-icon">
                        <img src="/images/icon-layers.svg" alt="Platform">
                    </div>
                    <span class="why-choose-card-title">Wide Platform Support</span>
                    <p style="line-height: 1.45;">Supports
                        YouTube, TikTok, Instagram, Facebook, and more.</p>
                </div>

                <!-- Card 5 -->
                <div class="why-choose-card">
                    <div class="why-choose-icon">
                        <img src="/images/icon-settings.svg" alt="Device">
                    </div>
                    <span class="why-choose-card-title">Works on Any Device</span>
                    <p style="line-height: 1.45;">Download
                        seamlessly on mobile, tablet, or desktop — no extra apps needed.</p>
                </div>

                <!-- Card 6 -->
                <div class="why-choose-card">
                    <div class="why-choose-icon">
                        <img src="/images/icon-shield.png" alt="Privacy">
                    </div>
                    <span class="why-choose-card-title">Privacy-First by Design</span>
                    <p style="line-height: 1.45;">Your
                        privacy matters. Processing happens locally, with no data storage and reduced security risk.</p>
                </div>

            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    @if(count($faqs) > 0)
        <style>
            .faq-list {
                display: flex;
                flex-direction: column;
                gap: 1rem;
            }

            .faq-item {
                border: 1px solid #E2E8F0;
                border-radius: 16px;
                overflow: hidden;
                background: #fff;
                transition: all 0.3s ease;
            }

            .faq-item:hover {
                border-color: #FFB800;
                box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05);
            }

            .faq-item.active {
                border-color: #FFB800;
            }

            .faq-question {
                padding: 1.2rem 1.5rem;
                display: flex;
                justify-content: space-between;
                align-items: center;
                cursor: pointer;
                font-weight: 700;
                color: #1E293B;
                font-size: 1rem;
                user-select: none;
            }

            .faq-answer {
                max-height: 0;
                overflow: hidden;
                transition: max-height 0.4s cubic-bezier(0.4, 0, 0.2, 1);
                background: #F8FAFC;
            }

            .faq-answer-inner {
                padding: 0 1.5rem 1.5rem;
                color: #000;
                font-size: 0.95rem;
                line-height: 1.7;
            }

            .faq-answer-inner p {
                margin: 0;
            }

            .faq-item.active .faq-answer {
                max-height: 500px;
            }

            .faq-item.active .faq-question {
                color: #FF8C00;
            }

            .toggle-icon {
                font-size: 1.2rem;
                color: #CBD5E1;
                transition: transform 0.3s ease;
            }

            .faq-item.active .toggle-icon {
                transform: rotate(45deg);
                color: #FF8C00;
            }
        </style>
        <section style="padding: 3.5rem 0; background: #ffffff; border-top: 1px solid #F3F4F6;">
            <div class="hero-container" style="max-width: 850px;">

                <div style="text-align:center; margin-bottom: 2.5rem;">
                    <h2
                        style="font-size: 1.8rem; font-weight: 700; color: #0F0F0F; margin-bottom: 0; letter-spacing:-0.02em;">
                        Frequently Asked Questions
                    </h2>
                </div>

                <div class="faq-list" id="faqAccordion">
                    @foreach ($faqs as $faq)
                        <div class="faq-item">
                            <div class="faq-question">
                                <span>{{ $faq->question }}</span>
                                <i class="fas fa-plus toggle-icon"></i>
                            </div>
                            <div class="faq-answer">
                                <div class="faq-answer-inner">
                                    <p>{{ $faq->answer }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
        </section>

        <script>
            document.querySelectorAll('#faqAccordion .faq-question').forEach(button => {
                button.addEventListener('click', () => {
                    const item = button.parentElement;

                    // Close other items
                    document.querySelectorAll('#faqAccordion .faq-item').forEach(otherItem => {
                        if (otherItem !== item) {
                            otherItem.classList.remove('active');
                        }
                    });

                    item.classList.toggle('active');
                });
            });
        </script>
    @endif

    <!-- Download CTA Section -->
    <!-- <section style="padding: 1.5rem 0 4rem; background: #fff;">
        <div class="container" style="max-width: 1100px;"> -->
            @include('partials.cta')
        <!-- </div>
    </section> -->

    @include('partials.footer')

    <script>
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
                        <span style="color:#000; font-size:0.85rem; font-weight:600;">${m.size || ''}</span>
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
                            ${videoMedias.length ? videoMedias.map(m => renderRow(m, data.title)).join('') : '<p style="color:#000; font-size:0.9rem; line-height: 1.45;">No video formats available.</p>'}
                        </div>

                        <!-- Music Section -->
                        <div style="display:flex; align-items:center; gap:12px; margin-bottom:10px; border-bottom:2px solid #F3F4F6; padding-bottom:10px;">
                            <i class="fas fa-music" style="color:#FFB800; font-size:1.3rem;"></i>
                            <h4 style="font-weight:800; font-size:1.3rem; color:#111827;">Music</h4>
                        </div>
                        <div style="display:flex; flex-direction:column;">
                            ${audioMedias.length ? audioMedias.map(m => renderRow(m, data.title)).join('') : '<p style="color:#000; font-size:0.9rem; line-height: 1.45;">No audio formats available.</p>'}
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
