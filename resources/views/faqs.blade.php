<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $settings->faq_meta_title ?? 'Frequently Asked Questions — Video Saver' }}</title>
    <meta name="description" content="{{ $settings->faq_meta_description ?? '' }}">
    <meta name="keywords" content="{{ $settings->faq_meta_keywords ?? '' }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

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
            gap: 1.5rem;
        }

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

            .hero-badges {
                justify-content: center;
            }
        }

        /* FAQ Content */
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
            color: var(--text-muted);
            font-size: 0.95rem;
            line-height: 1.7;
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
        <img class="hero-bg-img" src="/images/faqs.jpg" alt="">
        <div class="hero-container">
            <div class="hero-content">
                <div
                    style="display: inline-flex; align-items: center; gap: 8px; background: #ffffff; padding: 6px 14px; border-radius: 50px; font-size: 0.8rem; font-weight: 800; color: #FFB800; text-transform: uppercase; margin-bottom: 1.2rem; box-shadow: 0 4px 10px rgba(0,0,0,0.05); border: 1px solid #FFB800;">
                    <i class="fas fa-question-circle"></i> FAQ'S & HELP
                </div>
                <h1>Answers to Your<br>Common Questions</h1>
                <p class="hero-subtext">Find everything you need to know about downloading videos, <br>quality settings,
                    and
                    platform support.</p>

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
                                {{ $faq->question }}
                                <i class="fas fa-plus toggle-icon"></i>
                            </div>
                            <div class="faq-answer">
                                <div class="faq-answer-inner">
                                    {{ $faq->answer }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        @empty
            <div style="text-align:center; padding:5rem 0;">
                <i class="fas fa-search" style="font-size:3rem; color:#E2E8F0; margin-bottom:1.5rem;"></i>
                <p style="color:var(--text-muted);">No FAQs found at the moment.</p>
            </div>
        @endforelse
    </main>

    <!-- Download CTA Section -->
    <section style="padding: 1.5rem 0 4rem; background: #fff;">
        <div class="container" style="max-width: 1100px;">
            <div
                style="background: #FFC107; border-radius: 28px; padding: 2.2rem 3.5rem; display: flex; align-items: center; justify-content: space-between; gap: 2rem; flex-wrap: wrap;">
                <div style="flex: 1; min-width: 300px;">
                    <h2
                        style="font-size: 2rem; font-weight: 800; color: #111827; margin-bottom: 0.5rem; letter-spacing: -0.01em;">
                        Ready to Start Downloading?</h2>
                    <p style="font-size: 1rem; color: #111827; font-weight: 500; margin: 0; opacity: 0.9;">Join millions
                        of users who rely on HD Video Saver for fast, easy, and reliable downloads</p>
                </div>
                <a href="https://play.google.com/store/apps/details?id=com.jmdsol.videodownloader.videosaver"
                    style="background: #FF6807; color: #fff; text-decoration: none; padding: 1rem 2.2rem; border-radius: 50px; font-weight: 800; font-size: 1rem; box-shadow: 0 8px 20px rgba(255, 94, 20, 0.25); transition: all 0.3s ease; white-space: nowrap;"
                    onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 12px 25px rgba(255, 94, 20, 0.35)';"
                    onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 8px 20px rgba(255, 94, 20, 0.25)';">
                    Download Video Saver
                </a>
            </div>
        </div>
    </section>

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
            const select = document.querySelector('.goog-te-combo');
            if (select) {
                select.value = langCode;
                select.dispatchEvent(new Event('change'));
                const langNames = {
                    'en': 'English', 'ar': 'Arabic', 'ur': 'Urdu',
                    'hi': 'Hindi', 'es': 'Spanish', 'fr': 'French'
                };
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