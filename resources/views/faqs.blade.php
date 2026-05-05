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

        /* Premium Header */
        .faq-header {
            background: var(--primary);
            padding: 10rem 0 8rem;
            /* Increased top padding for absolute header */
            text-align: center;
            border-bottom-left-radius: 60px;
            border-bottom-right-radius: 60px;
            position: relative;
            overflow: hidden;
            margin-bottom: 4rem;
        }

        .faq-header h1 {
            font-size: 3.5rem;
            font-weight: 800;
            color: #000;
            line-height: 1.1;
            margin: 0;
            position: relative;
            z-index: 2;
        }

        .question-mark-bg {
            position: absolute;
            top: 50%;
            right: 10%;
            transform: translateY(-50%) rotate(15deg);
            width: 350px;
            opacity: 1;
            z-index: 1;
            pointer-events: none;
            filter: brightness(0) saturate(100%);
            /* Makes it solid dark */
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

    <header class="faq-header">
        <div class="container">
            <h1>Frequently<br>Asked Questions</h1>
            <img src="/images/question1.svg" alt="" class="question-mark-bg" onerror="this.style.display='none'">
        </div>
    </header>

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