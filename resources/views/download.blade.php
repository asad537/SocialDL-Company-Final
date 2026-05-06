<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Download Video Saver — Fast & Secure</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        :root {
            --primary: #FFB800;
            --primary-dark: #FF8C00;
            --secondary: #FF5722;
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
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        body {
            font-family: 'Inter', sans-serif;
            color: var(--text-main);
            background: #fff;
            line-height: 1.6;
            top: 0px !important;
            position: static !important;
        }

        /* ── Header Styles for Download Page ── */
        header.site-header {
            position: absolute !important;
            top: 0 !important;
            left: 0 !important;
            right: 0 !important;
            z-index: 1000 !important;
            padding: 1.2rem 0 !important;
            background: transparent !important;
            display: block !important;
        }

        header.site-header .header-container {
            width: 100% !important;
            max-width: 1200px !important;
            margin: 0 auto !important;
            padding: 0 2rem !important;
            display: flex !important;
            justify-content: space-between !important;
            align-items: center !important;
        }

        header.site-header .logo {
            display: flex !important;
            align-items: center !important;
            gap: 10px !important;
            text-decoration: none !important;
        }

        header.site-header .logo img {
            height: 65px !important;
            width: auto !important;
            border-radius: 8px !important;
        }

        header.site-header .nav-wrap {
            display: flex !important;
            align-items: center !important;
            gap: 1.5rem !important;
        }

        header.site-header .nav-links {
            display: flex !important;
            gap: 1.5rem !important;
            list-style: none !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        header.site-header .nav-links li {
            margin: 0 !important;
            padding: 0 !important;
        }

        header.site-header .nav-links a {
            text-decoration: none !important;
            color: #000 !important;
            font-weight: 600 !important;
            font-size: 0.95rem !important;
            transition: color 0.2s !important;
        }

        header.site-header .nav-links a:hover {
            color: #fff !important;
        }

        /* Desktop Lang Dropdown only */
        header.site-header .nav-wrap .lang-dropdown {
            background: rgba(255, 255, 255, 0.25) !important;
            border: 1px solid rgba(0, 0, 0, 0.15) !important;
            padding: 8px 16px !important;
            border-radius: 8px !important;
            font-size: 0.9rem !important;
            font-weight: 700 !important;
            display: flex !important;
            align-items: center !important;
            gap: 8px !important;
            cursor: pointer !important;
            backdrop-filter: blur(10px) !important;
            position: relative !important;
            z-index: 1000 !important;
            color: #000 !important;
        }

        /* Hide Mobile Lang on Desktop */
        header.site-header .lang-dropdown-mobile {
            display: none !important;
        }

        header.site-header .lang-menu {
            position: absolute !important;
            top: 110% !important;
            right: 0 !important;
            background: white !important;
            border: 1px solid var(--border) !important;
            border-radius: 12px !important;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1) !important;
            width: 150px !important;
            display: none;
            flex-direction: column !important;
            overflow: hidden !important;
            z-index: 1001 !important;
        }

        header.site-header .lang-menu div {
            padding: 10px 15px !important;
            font-size: 0.85rem !important;
            color: var(--text-dark) !important;
            transition: background 0.2s !important;
        }

        header.site-header .lang-menu div:hover {
            background: var(--bg-off) !important;
            color: var(--primary) !important;
        }

        /* Mobile Adjustments */
        @media (max-width: 768px) {
            header.site-header .lang-dropdown-mobile {
                display: flex !important;
            }
            header.site-header .nav-wrap {
                display: none !important;
            }
        }

        /* ── Download Banner ── */
        .download-header {
            background: var(--primary);
            padding: 8rem 0 4rem;
            text-align: center;
            border-bottom-left-radius: 60px;
            border-bottom-right-radius: 60px;
            position: relative;
            overflow: hidden;
        }

        /* ── Floating Background Icons ── */
        .bg-icon {
            position: absolute;
            pointer-events: none;
            user-select: none;
            opacity: 0.9;
        }

        .header-content {
            position: relative;
            z-index: 2;
            max-width: 800px;
            margin: 0 auto;
            padding: 0 1.5rem;
        }

        .dl-icon-main {
            font-size: 3.5rem;
            color: #000;
            margin-bottom: 1.5rem;
            display: inline-block;
        }

        .download-header h1 {
            font-size: 3.5rem;
            font-weight: 800;
            color: #000;
            margin-bottom: 2rem;
            line-height: 1.2;
        }

        .btn-download-main {
            display: inline-block;
            background: var(--secondary);
            color: #fff;
            padding: 1.2rem 2.5rem;
            border-radius: 50px;
            font-size: 1.2rem;
            font-weight: 800;
            text-decoration: none;
            box-shadow: 0 10px 20px rgba(255, 87, 34, 0.3);
            transition: all 0.3s ease;
        }

        .btn-download-main:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(255, 87, 34, 0.4);
            background: #E64A19;
        }

        /* ── Instruction Section ── */
        .container {
            max-width: 1000px;
            margin: 4rem auto;
            padding: 0 1.5rem;
        }

        .section-title {
            text-align: center;
            font-size: 2.2rem;
            font-weight: 800;
            color: #000;
            margin-bottom: 3rem;
        }

        .steps-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
        }

        .step-card {
            background: #fff;
            padding: 2.5rem 1.5rem;
            border-radius: 20px;
            border: 1px solid var(--border);
            text-align: center;
            transition: all 0.3s ease;
        }

        .step-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.05);
            border-color: var(--primary);
        }

        .step-num {
            width: 45px;
            height: 45px;
            background: var(--primary);
            color: #000;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            margin: 0 auto 1.5rem;
            font-size: 1.2rem;
        }

        .step-card h3 {
            font-size: 1.2rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: #000;
        }

        .step-card p {
            font-size: 0.95rem;
            color: var(--text-muted);
            line-height: 1.6;
        }

        /* ── Responsive ── */
        @media (max-width: 768px) {
            .download-header {
                padding: 6rem 1.2rem 3rem;
                border-bottom-left-radius: 32px;
                border-bottom-right-radius: 32px;
                min-height: 300px;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .download-header h1 {
                font-size: 2.2rem;
            }

            .dl-icon-main {
                font-size: 2.5rem;
            }

            .btn-download-main {
                padding: 1rem 2rem;
                font-size: 1rem;
            }

            .steps-grid {
                grid-template-columns: 1fr;
            }

            .section-title {
                font-size: 1.8rem;
            }

            /* Make icons visible on mobile */
            .bg-icon {
                opacity: 0.5 !important;
                display: block !important;
            }
        }

        /* ── Screenshots Showcase ── */
        .instruction-list {
            list-style: none;
            padding: 0;
            margin-bottom: 3rem;
            text-align: left;
        }

        .instruction-list li {
            position: relative;
            padding-left: 1.5rem;
            margin-bottom: 2rem;
        }

        .instruction-list li::before {
            content: '•';
            position: absolute;
            left: 0;
            top: 0;
            font-size: 1.5rem;
            line-height: 1;
            color: #000;
        }

        .instruction-list li strong {
            display: block;
            font-size: 1.25rem;
            font-weight: 800;
            color: #000;
            margin-bottom: 0.8rem;
        }

        .instruction-list li p {
            font-size: 1rem;
            color: #4B5563;
            line-height: 1.6;
            max-width: 800px;
        }

        .screenshots-flex {
            display: flex;
            justify-content: center;
            gap: 3rem;
            flex-wrap: wrap;
            margin-top: 4rem;
        }

        .screenshot-card {
            width: 100%;
            max-width: 240px;
            border-radius: 30px;
            overflow: hidden;
            position: relative;
            transition: transform 0.3s ease;
            aspect-ratio: 9 / 18.5; /* Consistent mobile aspect ratio */
            background: #f1f1f1;
        }

        .screenshot-card:hover {
            transform: translateY(-10px);
        }

        .screenshot-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            border-radius: 30px;
        }

        @media (max-width: 768px) {
            .screenshots-flex {
                gap: 2rem;
                margin-top: 2rem;
            }
            .screenshot-card {
                max-width: 200px;
            }
            .instruction-list li strong {
                font-size: 1.1rem;
            }
        }
    </style>
</head>

<body>

    @include('partials.header')

    <header class="download-header">
        <!-- Left side icons -->
        <img src="/images/music-alt.png" class="bg-icon"
            style="top: 28%; left: 5%; transform: rotate(-15deg); width: 65px;" alt="">
        <img src="/images/play-alt.png" class="bg-icon"
            style="top: 55%; left: 12%; transform: rotate(10deg); width: 60px;" alt="">
        <img src="/images/screen-play.png" class="bg-icon"
            style="top: 15%; left: 28%; transform: rotate(-20deg); width: 70px;" alt="">
        <!-- Right side icons -->
        <img src="/images/screen-play.png" class="bg-icon"
            style="top: 25%; right: 28%; transform: rotate(15deg); width: 65px;" alt="">
        <img src="/images/music-alt.png" class="bg-icon"
            style="top: 65%; right: 12%; transform: rotate(-10deg); width: 65px;" alt="">
        <img src="/images/play-alt.png" class="bg-icon"
            style="top: 29%; right: 5%; transform: rotate(15deg); width: 60px;" alt="">

        <div class="header-content">
            <div class="dl-icon-main">
                <i class="fas fa-download"></i>
            </div>
            <h1>Download Video Saver</h1>
            <a href="#" class="btn-download-main">Click Here to Download</a>
        </div>
    </header>

    <div class="container" style="max-width: 900px;">
        <h2 class="section-title">How to Install Video Saver</h2>
        
        <div class="install-instructions">
            <ul class="instruction-list">
                <li>
                    <strong>Tap on "Install"</strong>
                    <p>When you find Video Saver on the Play Store, tap the “Install” button. The app will start downloading and installing automatically on your device.</p>
                </li>
            </ul>
        </div>

        <div class="screenshots-flex">
            <div class="screenshot-card">
                <img src="/images/screen1.png" alt="Video Saver App Screenshot 1">
            </div>
            <div class="screenshot-card">
                <img src="/images/screen2.png" alt="Video Saver App Screenshot 2">
            </div>
        </div>

        {{-- Second Step --}}
        <div class="install-instructions" style="margin-top: 6rem;">
            <ul class="instruction-list">
                <li>
                    <strong>Open & Explore the App</strong>
                    <p>Once installation is complete, tap “Open” to launch the app. You’ll land on the home screen, where you can start saving videos and exploring features right away.</p>
                </li>
            </ul>
        </div>

        <div class="screenshots-flex">
            <div class="screenshot-card">
                <img src="/images/screen3.png" alt="Video Saver App Screenshot 3">
            </div>
            <div class="screenshot-card">
                <img src="/images/screen4.png" alt="Video Saver App Screenshot 4">
            </div>
        </div>
    </div>

    @include('partials.footer')

    <!-- Google Translate Scripts -->
    <script type="text/javascript">
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({
                pageLanguage: 'en',
                includedLanguages: 'en,ar,ur,hi,es,fr',
                autoDisplay: false
            }, 'google_translate_element');
        }
    </script>
    <script type="text/javascript"
        src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit">
    </script>

</body>

</html>
