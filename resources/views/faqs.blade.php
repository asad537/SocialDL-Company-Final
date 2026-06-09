<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Preload hero image for instant LCP -->
    <link rel="preload" as="image" href="/images/faqs.webp" type="image/webp" fetchpriority="high">
    <link rel="icon" type="image/webp" href="/images/Fav-logo.webp">
    <link rel="apple-touch-icon" href="/images/logofinal.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $settings->faq_meta_title ?? 'Frequently Asked Questions — Video Saver' }}</title>
    <meta name="description" content="{{ $settings->faq_meta_description ?? '' }}">
    <meta name="keywords" content="{{ $settings->faq_meta_keywords ?? '' }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    
    <!-- JSON-LD Schemas for FAQ Page -->
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
      "url": "https://hdvideosaver.com/",
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
      "@type": "FAQPage",
      "name": "Frequently Asked Questions - Video Saver",
      "url": "https://hdvideosaver.com/faq",
      "description": "Find answers to frequently asked questions about Video Saver — how it works, supported platforms, troubleshooting, and general usage.",
      "publisher": {
        "@id": "https://hdvideosaver.com/#organization"
      },
      "mainEntity": [
        {
          "@type": "Question",
          "name": "How does this video downloader work?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "Video Saver works by fetching the direct media file link from the URL you provide. Once you paste a link, our system analyzes the platform and provides you with various download options in different resolutions and formats."
          }
        },
        {
          "@type": "Question",
          "name": "Do I need to create an account?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "No. Video Saver is designed for maximum privacy and convenience. You can download any video without registering, signing up, or providing any personal information."
          }
        },
        {
          "@type": "Question",
          "name": "Is this service free to use?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "Absolutely. Our service is 100% free. We sustain the platform through minimal ads to keep the servers running without charging our users."
          }
        },
        {
          "@type": "Question",
          "name": "Which devices are supported?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "Video Saver is a web-based tool, meaning it works on any device with a browser. You can use it on Windows, macOS, Android, and iOS (iPhone/iPad)."
          }
        },
        {
          "@type": "Question",
          "name": "Can I download YouTube videos in 4K?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "Yes, if the original video is available in 4K, Video Saver will provide you with the option to download it in that resolution."
          }
        },
        {
          "@type": "Question",
          "name": "Does it work with private Instagram profiles?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "For security and privacy reasons, our downloader can only access public content. We do not support downloading videos from private accounts that you do not have permission to view."
          }
        },
        {
          "@type": "Question",
          "name": "Can I download TikTok videos without watermark?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "Yes! One of our most popular features is the ability to download TikTok videos in high quality without any watermark."
          }
        },
        {
          "@type": "Question",
          "name": "Why is my download slow?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "Download speed depends on your internet connection and the responsiveness of the original platform's servers. High-resolution videos (4K/1080p) also take longer to process."
          }
        },
        {
          "@type": "Question",
          "name": "The video plays instead of downloading?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "On some browsers (like Chrome or Safari), the video might open in a new tab. Simply right-click the video and select 'Save Video As...' or use the download button provided in the options menu."
          }
        },
        {
          "@type": "Question",
          "name": "Why did my download fail?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "A download might fail if the video has been deleted, is restricted in your region, or if the platform has changed its security settings. Try refreshing the page or using a different browser."
          }
        },
        {
          "@type": "Question",
          "name": "Is there a limit on the number of downloads?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "No. You can download an unlimited number of videos and audio files with Video Saver. We do not impose any daily or monthly limits."
          }
        },
        {
          "@type": "Question",
          "name": "What video formats are supported?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "We primarily support MP4 for video and MP3 for audio. Depending on the source, you may also see options for WEBM, M4A, and different resolution tiers."
          }
        },
        {
          "@type": "Question",
          "name": "Can I download audio only?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "Yes! For most platforms like YouTube and SoundCloud, Video Saver provides a 'Music' section where you can download the audio track as an MP3 file."
          }
        },
        {
          "@type": "Question",
          "name": "Is it legal to download videos?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "Downloading videos for personal, offline viewing is generally considered fair use. However, you should not redistribute or use downloaded content for commercial purposes without permission from the creator."
          }
        },
        {
          "@type": "Question",
          "name": "How do I save videos to my iPhone?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "On iOS, use the Safari browser. After clicking download, the file will go to your 'Downloads' folder in the Files app. You can then move it to your Camera Roll."
          }
        },
        {
          "@type": "Question",
          "name": "Are the downloads safe and secure?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "Absolutely. Video Saver does not require any software installation or extensions. All processing happens on our secure servers, and we never store your personal data."
          }
        }
      ]
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
          "item": "https://hdvideosaver.com/"
        },
        {
          "@type": "ListItem",
          "position": 2,
          "name": "FAQ",
          "item": "https://hdvideosaver.com/faq"
        }
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
      "url": "https://hdvideosaver.com/",
      "description": "Video Saver is a free online video downloader that lets users download videos, reels, shorts, and audio clips in MP4 or MP3 format from supported platforms.",
      "publisher": {
        "@id": "https://hdvideosaver.com/#organization"
      }
    }
    </script>

    <style>
        :root {
            --primary: #FFB800;
            --primary-dark: #FF8C00;
            --text-main: #1E293B;
            --text-muted: #64748B;
            --bg-light: #F8FAFC;
            --text-dark: #111827;
            --border: #E5E7EB;
            --bg-off: #F9FAFB;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            color: var(--text-main);
            background: #fff;
            line-height: 1.6;
        }

        /* ── Header Styles ── */
        .site-header {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            z-index: 100;
            padding: 1.2rem 0;
            background: transparent;
            display: flex;
            justify-content: center;
        }

        .header-container {
            width: 100%;
            max-width: 1200px;
            padding: 0 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            color: var(--text-dark);
            font-weight: 800;
            font-size: 1.1rem;
        }

        .logo img {
            height: 65px;
            width: auto;
            border-radius: 8px;
        }

        .nav-wrap {
            display: flex;
            align-items: center;
            gap: 1.5rem; line-height: 1.45; }

        .nav-links {
            display: flex;
            gap: 1.5rem;
            list-style: none;
        }

        .nav-links a {
            text-decoration: none;
            color: var(--text-dark);
            font-weight: 600;
            font-size: 0.9rem;
            transition: color 0.2s;
        }

        .nav-links a:hover {
            color: #fff;
            /* White on yellow looks better */
        }

        .lang-dropdown {
            background: rgba(255, 255, 255, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.3);
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 0.9rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            backdrop-filter: blur(6px);
            position: relative;
            z-index: 1000;
            color: #000;
        }

        .lang-menu {
            position: absolute;
            top: 110%;
            right: 0;
            background: white;
            border: 1px solid var(--border);
            border-radius: 12px;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            width: 150px;
            display: none;
            flex-direction: column;
            overflow: hidden;
        }

        .lang-menu div {
            padding: 10px 15px;
            font-size: 0.85rem;
            color: var(--text-dark);
            transition: background 0.2s;
        }

        .lang-menu div:hover {
            background: var(--bg-off);
            color: var(--primary);
        }

        iframe.skiptranslate,
        .goog-te-banner-frame {
            display: none !important;
        }

        /* ── FAQ Specific Styles ── */
        .container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 0 1.5rem;
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
            margin-bottom: 4rem;
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
            margin-top: 70px;
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

        .hero-badges {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .hero-badge {
            display: flex;
            align-items: center;
            gap: 8px;
            background: #ffffff;
            padding: 8px 18px;
            border-radius: 50px;
            font-size: 0.9rem;
            font-weight: 700;
            color: #000;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.04);
            border: 1.5px solid #F3F4F6;
        }

        .hero-badge i {
            color: #FFB800;
            font-size: 0.85rem;
        }

        @media (max-width: 1024px) {
            .hero {
                padding-top: 80px;
                height: auto !important;
                min-height: unset !important;
                max-height: unset !important;
                display: flex;
                flex-direction: column;
                align-items: center;
                overflow: hidden;
                background: #fff;
                margin-bottom: 2rem;
            }

            .hero picture {
                display: block;
                width: 100%;
                flex-shrink: 0;
            }

            .hero-bg-img {
                position: relative !important;
                display: block;
                width: 100%;
                height: auto;
                object-fit: contain;
            }

            .hero-container {
                position: relative;
                z-index: 2;
                width: 100%;
                text-align: center;
                padding: 1.2rem 1.25rem 2rem;
            }

            .hero-content {
                max-width: 100%;
                margin: 0 auto;
            }

            .hero h1 {
                font-size: clamp(1.45rem, 6vw, 1.75rem);
                font-weight: 800;
                line-height: 1.2;
                margin-bottom: 1rem;
            }

            .hero-badges {
                justify-content: center;
                gap: 8px;
            }

            .hero-badge {
                font-size: 0.8rem;
                padding: 6px 14px;
            }
        }




        .category-section {
            margin-bottom: 4rem;
        }

        .category-title {
            font-size: 1.5rem;
            font-weight: 800;
            color: #0F172A;
            margin-bottom: 1.5rem;
            padding-left: 0.5rem;
            border-left: 4px solid var(--primary);
        }

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
            border-color: var(--primary);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05);
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
            color: var(--primary-dark);
        }

        .toggle-icon {
            font-size: 1.2rem;
            color: #CBD5E1;
            transition: transform 0.3s ease;
        }

        .faq-item.active .toggle-icon {
            transform: rotate(45deg);
            color: var(--primary-dark);
        }

        @media (max-width: 768px) {
            .faq-header h1 {
                font-size: 2.2rem;
            }

            .question-mark-bg {
                width: 150px;
                right: 5%;
            }
        }
    </style>
</head>

<body>

    @include('partials.header')

    <section class="hero">
        <picture>
            <source media="(max-width: 768px)" srcset="/images/mobile/faqsmobile.webp" type="image/webp">
            <source media="(max-width: 768px)" srcset="/images/mobile/faqsmobile.jpg">
            <source srcset="/images/faqs.webp" type="image/webp">
            <img class="hero-bg-img" src="/images/faqs.jpg" alt="Frequently Asked Questions" fetchpriority="high" loading="eager">
        </picture>
        <div class="hero-container">
            <div class="hero-content">
                <div
                    style="display: inline-flex; align-items: center; gap: 8px; background: #ffffff; padding: 6px 14px; border-radius: 50px; font-size: 0.8rem; font-weight: 800; color: #FFB800; text-transform: uppercase; margin-bottom: 1.2rem; box-shadow: 0 4px 10px rgba(0,0,0,0.05); border: 1px solid #FFB800;">
                    <i class="fas fa-question-circle"></i> Find Answers
                </div>
                <h1>Answers to Your Common Questions</h1>
                <p class="hero-subtext" style="line-height: 1.45;">Find everything you need to know about downloading videos, quality settings, and platform support.</p>

                <div class="hero-badges">
                    <div class="hero-badge"><i class="fas fa-bolt"></i> Fast</div>
                    <div class="hero-badge"><i class="fas fa-gem"></i> Quality</div>
                    <div class="hero-badge"><i class="fas fa-shield-alt"></i> Secure</div>
                </div>
            </div>
        </div>
    </section>

    <main class="container">
        @forelse($faqs as $category => $items)
            <section class="category-section">
                <h2 class="category-title">{{ $category }}</h2>
                <div class="faq-list">
                    @foreach($items as $faq)
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
            </section>
        @empty
            <div style="text-align:center; padding:5rem 0;">
                <i class="fas fa-search" style="font-size:3rem; color:#E2E8F0; margin-bottom:1.5rem;"></i>
                <p style="color:#000; line-height: 1.45;">No FAQs found at the moment.</p>
            </div>
        @endforelse
    </main>

    <!-- Download CTA Section -->
    <!-- <section style="padding: 1.5rem 0 4rem; background: #fff;">
        <div class="container" style="max-width: 1100px;"> -->
            @include('partials.cta')
        <!-- </div>
    </section> -->

    @include('partials.footer')

    <div id="google_translate_element"
        style="position: absolute; opacity: 0; pointer-events: none; height: 0; overflow: hidden;"></div>

    <script type="text/javascript">
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({
                pageLanguage: 'en',
                autoDisplay: false
            }, 'google_translate_element');
        }
    </script>
    <script type="text/javascript"
        src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

    <script>
        document.querySelectorAll('.faq-question').forEach(button => {
            button.addEventListener('click', () => {
                const item = button.parentElement;

                // Close other items
                document.querySelectorAll('.faq-item').forEach(otherItem => {
                    if (otherItem !== item) {
                        otherItem.classList.remove('active');
                    }
                });

                item.classList.toggle('active');
            });
        });

        // --- Translation Scripts (Ported from Home) ---
        function toggleLangMenu() {
            const menu = document.getElementById('lang-menu');
            if (menu) menu.style.display = menu.style.display === 'flex' ? 'none' : 'flex';
        }

        function changeLanguage(langCode) {
            if (langCode === 'en') {
                localStorage.setItem('selectedLanguage', 'en');
                localStorage.setItem('selectedLanguageName', 'English');
                document.cookie = "googtrans=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
                document.cookie = "googtrans=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/; domain=" + location.host;
                document.cookie = "googtrans=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/; domain=." + location.hostname.split('.').slice(-2).join('.');
                location.reload();
                return;
            }

            const select = document.querySelector('.goog-te-combo');
            if (select) {
                let actualLang = select.value || 'en';
                if (actualLang === langCode) {
                    const menu = document.getElementById('lang-menu');
                    if (menu) menu.style.display = 'none';
                    return;
                }

                select.value = langCode;
                select.dispatchEvent(new Event('change'));
                const langNames = {
                    'en': 'English', 'ar': 'Arabic', 'ur': 'Urdu',
                    'hi': 'Hindi', 'es': 'Spanish', 'fr': 'French', 'pt': 'Portuguese'
                };
                
                // Save to localStorage
                localStorage.setItem('selectedLanguage', langCode);
                localStorage.setItem('selectedLanguageName', langNames[langCode]);

                document.getElementById('current-lang').innerText = langNames[langCode];
            }
            const menu = document.getElementById('lang-menu');
            if (menu) menu.style.display = 'none';
        }

        window.onclick = function (event) {
            if (!event.target.closest('.lang-dropdown')) {
                const menu = document.getElementById('lang-menu');
                if (menu) menu.style.display = 'none';
            }
        }
    </script>

</body>

</html>