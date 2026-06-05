<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="icon" type="image/png" href="/images/logofinal.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Video Download Guides & Tips — Video Saver</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600;700;800&display=swap"
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
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        /* Ultra-Aggressive Hide Google Translate */
        iframe.skiptranslate,
        .goog-te-banner-frame,
        .goog-te-banner,
        .goog-te-balloon-frame,
        #goog-gt-tt,
        .goog-tooltip,
        .goog-tooltip:hover,
        .goog-te-spinner-pos,
        .goog-te-spinner,
        .goog-te-spinner-pos+div {
            display: none !important;
            visibility: hidden !important;
            opacity: 0 !important;
        }

        body {
            font-family: 'Inter', sans-serif;
            color: var(--text-main);
            background: #fff;
            line-height: 1.6;
            top: 0px !important;
            position: static !important;
        }

        /* ── Header Styles for Blog Page ── */
        .site-header {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            z-index: 100;
            padding: 1.2rem 0;
            background: transparent;
        }

        .header-container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
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
            z-index: 1001;
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

        /* ── Blog Banner Redesign ── */
        .blog-header {
            position: relative;
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
            margin-top: 110px;
        }

        .blog-header h1 {
            font-size: 2rem;
            font-weight: 600;
            line-height: 1.2;
            color: #111827;
            margin-bottom: 1.5rem;
            text-align: left;
        }

        .hero-subtext {
            font-size: 1.05rem;
            color: #000;
            line-height: 1.6;
            margin-bottom: 2rem;
            max-width: 500px;
            text-align: left;
            font-weight: 500;
        }

        .hero-badges {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        .hero-badge {
            background: #fff;
            border: 1.5px solid #F1F5F9;
            padding: 8px 18px;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 700;
            color: #111827;
            display: flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
        }

        .hero-badge i {
            color: #FFB800;
        }

        /* ── Floating Background Icons ── */
        .bg-icon {
            position: absolute;
            pointer-events: none;
            user-select: none;
        }

        /* ── Main Layout ── */
        .container {
            max-width: 1000px;
            margin: 0 auto 4rem;
            /* Removed top margin */
            padding: 0 1.5rem;
            position: relative;
            z-index: 10;
            display: grid;
            grid-template-columns: 1fr 260px;
            gap: 1.5rem;
        }

        /* ── Filter Section ── */
        .filter-box {
            grid-column: 1 / -1;
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            padding: 1.2rem 2rem;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04);
            border: 1px solid rgba(255, 184, 0, 0.2);
            margin-bottom: 2rem;
            width: 100%;
            display: flex;
            align-items: center;
            gap: 2rem;
        }

        .filter-box h3 {
            font-size: 0.95rem;
            font-weight: 800;
            color: #000;
            white-space: nowrap;
        }

        .filter-flex {
            display: flex;
            align-items: center;
            gap: 2rem;
        }

        .filter-group {
            display: flex;
            align-items: center;
            gap: 0.6rem; line-height: 1.45; }

        .filter-group label {
            font-size: 0.85rem;
            font-weight: 800;
            color: #000;
            white-space: nowrap;
        }

        .filter-group select {
            padding: 0.4rem 0.6rem;
            border-radius: 6px;
            border: 1.5px solid #E5E7EB;
            font-size: 0.8rem;
            font-weight: 500;
            background: #fff;
            outline: none;
            min-width: 130px;
            color: #374151;
            cursor: pointer;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%236B7280'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 0.6rem center;
            background-size: 0.9rem;
        }

        .filter-group select:focus {
            border-color: #FFB800;
        }

        /* ── Blog Posts ── */
        .blog-list {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .blog-card {
            display: flex;
            background: #fff;
            border-radius: 16px;
            overflow: hidden;
            border: 1px solid #F1F5F9;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            margin-bottom: 1.5rem;
            height: 180px;
            /* Consistent height */
            text-decoration: none;
            color: inherit;
        }

        .blog-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.06);
            border-color: rgba(255, 184, 0, 0.3);
        }

        .card-img {
            width: 220px;
            flex-shrink: 0;
            position: relative;
            overflow: hidden;
            background: #f1f5f9;
        }

        .card-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center top;
            transition: transform 0.6s ease;
            display: block;
        }

        .blog-card:hover .card-img img {
            transform: scale(1.08);
        }

        .card-content {
            padding: 1.2rem 1.5rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            flex-grow: 1;
        }

        .card-content h2 {
            font-size: 1.15rem;
            font-weight: 700;
            margin-bottom: 0.6rem;
            color: #000;
            line-height: 1.3;
        }

        .card-content h2 a {
            text-decoration: none;
            color: inherit;
            transition: color 0.2s;
        }

        .card-excerpt {
            font-size: 0.88rem;
            color: #64748B;
            line-height: 1.5;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            margin-bottom: 1rem;
        }

        .card-footer {
            margin-top: auto;
            display: flex;
            align-items: center;
            gap: 1rem;
            font-size: 0.75rem;
            font-weight: 700;
            color: #94A3B8;
            letter-spacing: 0.02em;
        }

        .card-footer span:first-child {
            color: #000;
            background: rgba(255, 184, 0, 0.1);
            padding: 2px 8px;
            border-radius: 4px;
        }

        /* ── Sidebar ── */
        .sidebar {
            display: flex;
            flex-direction: column;
            gap: 2rem;
        }

        .widget {
            background: #fff;
            padding: 1.5rem;
            border-radius: 16px;
            border: 1px solid #F1F5F9;
            margin-bottom: 1.5rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.02);
        }

        .widget-title {
            font-size: 1rem;
            font-weight: 800;
            color: #000;
            margin-bottom: 1.2rem;
            position: relative;
            padding-bottom: 0.5rem;
        }

        .widget-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 30px;
            height: 3px;
            background: var(--primary);
            border-radius: 2px;
        }

        .popular-list {
            display: flex;
            flex-direction: column;
            gap: 1.2rem;
        }

        .popular-item {
            display: flex;
            gap: 1rem;
            align-items: center;
            text-decoration: none;
        }

        .pop-img {
            width: 70px;
            height: 45px;
            border-radius: 6px;
            overflow: hidden;
            background: var(--bg-off);
            flex-shrink: 0;
            border: 1px solid var(--border);
        }

        .pop-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .pop-info h4 {
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--text-dark);
            line-height: 1.2;
            margin-bottom: 0.2rem;
        }

        .pop-info span {
            font-size: 0.75rem;
            color: #000;
        }

        /* Download Widget */
        .download-widget {
            text-align: center;
        }

        .dl-icon {
            width: 50px;
            height: 50px;
            background: #FEF3C7;
            color: #D97706;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            font-size: 1.2rem;
        }

        .download-widget p {
            font-size: 0.85rem;
            color: #000;
            margin: 1rem 0 1.5rem; line-height: 1.45; }

        .dl-buttons {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.8rem;
        }

        .btn-dl {
            padding: 0.6rem;
            border-radius: 8px;
            font-size: 0.8rem;
            font-weight: 700;
            text-decoration: none;
            transition: all 0.2s;
        }

        .btn-app {
            background: var(--primary);
            color: var(--text-dark); line-height: 1.45; }

        .btn-web {
            border: 1px solid var(--border);
            color: var(--text-dark);
        }

        .btn-dl:hover {
            opacity: 0.9;
            transform: translateY(-2px);
        }

        /* ── Tablet (≤ 992px) ── */
        @media (max-width: 992px) {
            .container {
                grid-template-columns: 1fr;
                padding: 0 1.2rem;
            }

            .filter-box {
                grid-column: 1 / -1;
            }

            .sidebar {
                order: 2;
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 1rem;
            }

            .blog-list {
                order: 1;
            }

            .blog-header {
                padding: 6rem 1.5rem 3.5rem;
            }

            .blog-header h1 {
                font-size: 2.4rem;
            }
        }

        /* ── Mobile (≤ 768px) ── */
        @media (max-width: 768px) {

            /* Hero — stack image then text */
            .blog-header {
                padding-top: 80px;
                height: auto !important;
                min-height: unset !important;
                max-height: unset !important;
                display: flex;
                flex-direction: column;
                align-items: center;
                overflow: hidden;
                background: #fff;
                margin-bottom: 0;
            }

            .blog-header picture {
                display: block;
                width: 100%;
                flex-shrink: 0;
            }

            .blog-header .hero-bg-img {
                position: relative !important;
                display: block;
                width: 100%;
                height: auto;
                object-fit: contain;
            }

            .blog-header .hero-container {
                position: relative;
                z-index: 2;
                width: 100%;
                text-align: center;
                padding: 0.75rem 1.25rem 0.25rem;
            }

            .blog-header .hero-content {
                max-width: 100%;
                margin: 0 auto;
                margin-top: 0;
            }

            .blog-header h1 {
                font-size: clamp(1.6rem, 6vw, 2rem);
                font-weight: 800;
                line-height: 1.2;
                text-align: center;
                margin-bottom: 1rem;
                position: static;
            }

            .hero-subtext {
                text-align: center;
                font-size: 0.95rem;
            }

            .hero-badges {
                justify-content: center;
                gap: 6px;
                flex-wrap: nowrap;
            }

            .hero-badge {
                font-size: 0.78rem;
                padding: 7px 12px;
                gap: 5px;
            }

            /* Make icons visible on mobile */
            .bg-icon {
                opacity: 0.5 !important;
                display: block !important;
            }

            /* Container — switch to block */
            .container {
                display: block;
                padding: 0 1rem;
                margin-bottom: 2rem;
            }

            /* Filter bar — hide on mobile */
            .filter-box {
                display: none !important;
            }

            /* Blog list */
            .blog-list {
                order: unset;
                display: block;
                width: 100%;
                margin-bottom: 1.2rem;
            }

            /* Blog cards — vertical stacked layout */
            .blog-card {
                display: flex;
                flex-direction: column;
                height: auto;
                margin-bottom: 1.2rem;
                border-radius: 12px;
                background: #fff;
            }

            .card-img {
                width: 100%;
                height: 200px;
                border-radius: 12px 12px 0 0;
            }

            .card-img img {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }

            .card-content {
                padding: 1rem 1.2rem;
                display: flex;
                flex-direction: column;
                justify-content: flex-start;
                flex: 1;
            }

            .card-content h2 {
                font-size: 1rem;
                margin-bottom: 0.5rem;
                line-height: 1.4;
                display: -webkit-box;
                -webkit-line-clamp: 2;
                -webkit-box-orient: vertical;
                overflow: hidden;
            }

            .card-excerpt {
                font-size: 0.85rem;
                line-height: 1.5;
                -webkit-line-clamp: 3;
                margin-bottom: 0.8rem;
            }

            .card-footer {
                font-size: 0.75rem;
                gap: 0.6rem;
                flex-wrap: wrap;
                margin-top: auto;
            }

            /* Sidebar — block, single column */
            .sidebar {
                order: unset;
                display: block;
                width: 100%;
            }

            .sidebar .widget {
                margin-bottom: 1rem;
                padding: 1rem;
            }

            .widget-title {
                font-size: 0.92rem;
                margin-bottom: 0.8rem;
            }

            .popular-item {
                padding: 0.3rem 0;
                gap: 0.6rem;
            }

            .pop-img {
                width: 50px;
                height: 38px;
            }

            .pop-info h4 {
                font-size: 0.78rem;
            }

            .pop-info span {
                font-size: 0.68rem;
            }

            /* Pagination */
            .pagination {
                gap: 0.3rem;
                flex-wrap: wrap;
                justify-content: center;
            }

            .page-btn {
                padding: 0.45rem 0.7rem;
                font-size: 0.78rem;
                min-width: 34px;
            }

            /* Header */
            .site-header .header-container {
                padding: 0 1rem;
            }
        }

        /* ── Small phones (≤ 480px) ── */
        @media (max-width: 480px) {
            .blog-header {
                padding: 5rem 1rem 2.5rem;
            }

            .blog-header h1 {
                font-size: 1.55rem;
            }

            .card-img {
                width: 100%;
                height: 180px;
            }

            .card-content h2 {
                font-size: 0.95rem;
            }

            .card-content {
                padding: 0.9rem 1rem;
            }

            .card-excerpt {
                font-size: 0.82rem;
                -webkit-line-clamp: 3;
            }
        }
    </style>
</head>

<body>

    @include('partials.header')

    <header class="blog-header">
        <picture>
            <source media="(max-width: 768px)" srcset="/images/mobile/blogmobile.jpg">
            <img class="hero-bg-img" src="/images/blog.jpg" alt="Blog Banner">
        </picture>
        <div class="hero-container">
            <div class="hero-content">
                <div
                    style="display: inline-flex; align-items: center; gap: 8px; background: #fff; padding: 6px 16px; border-radius: 50px; font-size: 0.8rem; font-weight: 800; color: #FFB800; text-transform: uppercase; margin-bottom: 1.2rem; box-shadow: 0 4px 10px rgba(0,0,0,0.05); border: 1.5px solid #F3F4F6;">
                    <i class="fas fa-file-alt"></i> Blog
                </div>
                <h1>Tips, Guides &<br>Latest Updates</h1>
                <p class="hero-subtext" style="line-height: 1.45;">Stay informed with helpful tips, how-tos, and updates to get the most out of the
                    app.</p>

                <div class="hero-badges">
                    <div class="hero-badge"><i class="fas fa-lightbulb"></i> Tips</div>
                    <div class="hero-badge"><i class="fas fa-book-open"></i> Guides</div>
                    <div class="hero-badge"><i class="fas fa-bell"></i> Updates</div>
                </div>
            </div>
        </div>
    </header>

    <div class="container">
        <!-- Filter Bar -->
        <div class="filter-box">
            <h3>Filter By</h3>
            <form action="{{ route('blogs.filter') }}" method="POST" class="filter-flex">
                @csrf
                <div class="filter-group">
                    <label>Resource Hub:</label>
                    <select name="resource" onchange="this.form.submit()">
                        <option value="blog" {{ session('helpcenter_resource', 'blog') === 'blog' ? 'selected' : '' }}>Blogs</option>
                        <option value="guide" {{ session('helpcenter_resource') === 'guide' ? 'selected' : '' }}>Guides</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label>Category:</label>
                    <select name="category" onchange="this.form.submit()">
                        <option value="">All Categories</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}" {{ session('helpcenter_category') === $cat ? 'selected' : '' }}>{{ $cat }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </form>
        </div>

        <!-- Main Blog List -->
        <main class="blog-list">
            @forelse($blogs as $blog)
                <article class="blog-card">
                    <div class="card-img">
                        <img src="{{ $blog->featured_image ?? '/images/placeholder-blog.jpg' }}" alt="{{ $blog->title }}">
                    </div>
                    <div class="card-content">
                        <h2><a href="{{ route($resource . '.show', $blog->slug) }}">{{ $blog->title }}</a></h2>
                        <p class="card-excerpt" style="line-height: 1.45;">{{ $blog->description }}</p>
                        <div class="card-footer">
                            <span>{{ $blog->author_name ?? 'Admin' }}</span>
                            <span>•</span>
                            <span>{{ $blog->created_at->format('M d, Y') }}</span>
                        </div>
                    </div>
                </article>
            @empty
                <div style="text-align: center; padding: 4rem 0;">
                    <h3>No blog posts found.</h3>
                </div>
            @endforelse

            <div style="margin-top: 2rem;">
                {{ $blogs->links() }}
            </div>
        </main>

        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="widget">
                <h3 class="widget-title">Popular {{ $resource === 'guide' ? 'Guides' : 'Articles' }}</h3>
                <div class="popular-list">
                    @foreach($popular as $pop)
                        <a href="{{ route($resource . '.show', $pop->slug) }}" class="popular-item">
                            <div class="pop-img">
                                <img src="{{ $pop->featured_image ?? '/images/placeholder-blog.jpg' }}" alt="">
                            </div>
                            <div class="pop-info">
                                <h4>{{ $pop->title }}</h4>
                                <span>{{ $pop->created_at->format('M d, Y') }}</span>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>

            <div class="widget download-widget">
                <div class="dl-icon"><i class="fas fa-download"></i></div>
                <h3 class="widget-title">Download Your Way</h3>
                <p style="line-height: 1.45;">Choose how you want to download and start using the app.</p>
                <div class="dl-buttons">
                    <a href="https://play.google.com/store/apps/details?id=com.jmdsol.videodownloader.videosaver"
                        class="btn-dl btn-app">Via App</a>
                    <a href="/" class="btn-dl btn-web">Via Web</a>
                </div>
            </div>
        </aside>
    </div>

    @include('partials.footer')

    <!-- Google Translate Scripts -->
    <script type="text/javascript">
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({
                pageLanguage: 'en',
                includedLanguages: 'en,ar,ur,hi,es,fr,pt',
                autoDisplay: false
            }, 'google_translate_element');
        }
    </script>
    <script type="text/javascript"
        src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit">
        </script>

    <script>
        // Language Dropdown Toggle
        function toggleLangMenu() {
            const menu = document.getElementById('lang-menu');
            if (menu) {
                menu.style.display = (menu.style.display === 'flex') ? 'none' : 'flex';
            }
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
                    const menuMobile = document.getElementById('lang-menu-mobile');
                    if (menuMobile) menuMobile.style.display = 'none';
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

                const currentLangEl = document.getElementById('current-lang');
                if (currentLangEl) currentLangEl.innerText = langNames[langCode];

                const currentLangMobileEl = document.getElementById('current-lang-mobile');
                if (currentLangMobileEl) currentLangMobileEl.innerText = langNames[langCode];
            } else {
                console.log("Retrying translation...");
                setTimeout(() => changeLanguage(langCode), 300);
            }
            const menu = document.getElementById('lang-menu');
            if (menu) menu.style.display = 'none';
            const menuMobile = document.getElementById('lang-menu-mobile');
            if (menuMobile) menuMobile.style.display = 'none';
        }

        // Mobile Menu Toggle
        function toggleMobileMenu() {
            const nav = document.getElementById('mobile-nav');
            const overlay = document.getElementById('mobile-overlay');
            const btn = document.getElementById('hamburger');

            if (nav && overlay) {
                nav.classList.toggle('open');
                overlay.classList.toggle('open');
                if (btn) btn.classList.toggle('open');

                // Prevent body scroll when menu is open
                if (nav.classList.contains('open')) {
                    document.body.style.overflow = 'hidden';
                } else {
                    document.body.style.overflow = '';
                }
            }
        }

        // Close menu on outside click
        window.onclick = function (event) {
            if (!event.target.closest('.lang-dropdown')) {
                const menu = document.getElementById('lang-menu');
                if (menu) menu.style.display = 'none';
            }
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