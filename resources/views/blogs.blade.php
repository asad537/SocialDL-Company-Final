<!DOCTYPE html>
<html lang="en">

<head>
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

        body {
            font-family: 'Inter', sans-serif;
            color: var(--text-main);
            background: #fff;
            line-height: 1.6;
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

        /* ── Blog Banner ── */
        .blog-header {
            background: var(--primary);
            padding: 10rem 0 4rem;
            /* Reduced padding */
            text-align: center;
            border-bottom-left-radius: 60px;
            border-bottom-right-radius: 60px;
            position: relative;
            overflow: hidden;
            margin-bottom: 1.5rem;
            /* Reduced margin */
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
            gap: 0.6rem;
        }

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
            font-weight: 800;
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
            color: var(--text-muted);
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
            color: var(--text-muted);
            margin: 1rem 0 1.5rem;
        }

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
            color: var(--text-dark);
        }

        .btn-web {
            border: 1px solid var(--border);
            color: var(--text-dark);
        }

        .btn-dl:hover {
            opacity: 0.9;
            transform: translateY(-2px);
        }

        @media (max-width: 992px) {
            .container {
                grid-template-columns: 1fr;
            }

            .sidebar {
                order: 2;
            }

            .blog-list {
                order: 1;
            }
        }

        @media (max-width: 768px) {
            .blog-header h1 {
                font-size: 2.5rem;
            }

            .blog-card {
                grid-template-columns: 1fr;
            }

            .card-img {
                height: 200px;
            }

            .filter-box {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }

            .site-header .header-container {
                padding: 0 1.5rem;
            }
        }
    </style>
</head>

<body>

    @include('partials.header')

    <header class="blog-header">
        <!-- Left side icons -->
        <img src="/images/music-alt.png" class="bg-icon"
            style="top: 28%; left: 5%; transform: rotate(-15deg); width: 65px; opacity: 0.9;" alt="">
        <img src="/images/play-alt.png" class="bg-icon"
            style="top: 55%; left: 12%; transform: rotate(10deg); width: 60px; opacity: 0.9;" alt="">
        <img src="/images/screen-play.png" class="bg-icon"
            style="top: 15%; left: 28%; transform: rotate(-20deg); width: 70px; opacity: 0.9;" alt="">
        <!-- Right side icons -->
        <img src="/images/screen-play.png" class="bg-icon"
            style="top: 25%; right: 28%; transform: rotate(15deg); width: 65px; opacity: 0.9;" alt="">
        <img src="/images/music-alt.png" class="bg-icon"
            style="top: 65%; right: 12%; transform: rotate(-10deg); width: 65px; opacity: 0.9;" alt="">
        <img src="/images/play-alt.png" class="bg-icon"
            style="top: 29%; right: 5%; transform: rotate(15deg); width: 60px; opacity: 0.9;" alt="">

        <h1>Video Download <br> Guides & Tips</h1>
    </header>

    <div class="container">
        <!-- Filter Bar -->
        <div class="filter-box">
            <h3>Filter By</h3>
            <form action="{{ route('blogs.index') }}" method="GET" class="filter-flex">
                <div class="filter-group">
                    <label>Resource Hub:</label>
                    <select name="resource" onchange="this.form.submit()">
                        <option value="blog" {{ $resource === 'blog' ? 'selected' : '' }}>Blogs</option>
                        <option value="guide" {{ $resource === 'guide' ? 'selected' : '' }}>Guides</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label>Category:</label>
                    <select name="category" onchange="this.form.submit()">
                        <option value="">All Categories</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}" {{ request('category') === $cat ? 'selected' : '' }}>{{ $cat }}
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
                        <p class="card-excerpt">{{ $blog->description }}</p>
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
                <p>Choose how you want to download and start using the app.</p>
                <div class="dl-buttons">
                    <a href="#" class="btn-dl btn-app">Via App</a>
                    <a href="#" class="btn-dl btn-web">Via Web</a>
                </div>
            </div>
        </aside>
    </div>

    @include('partials.footer')

    <script>
        // Language Dropdown Toggle
        function toggleLangMenu() {
            const menu = document.getElementById('lang-menu');
            if (menu) {
                menu.style.display = (menu.style.display === 'flex') ? 'none' : 'flex';
            }
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
                const currentLangEl = document.getElementById('current-lang');
                if (currentLangEl) currentLangEl.innerText = langNames[langCode];
            }
            const menu = document.getElementById('lang-menu');
            if (menu) menu.style.display = 'none';
        }

        // Mobile Menu Toggle
        function toggleMobileMenu() {
            const nav = document.getElementById('mobile-nav');
            const overlay = document.getElementById('nav-overlay');
            if (nav && overlay) {
                const isOpen = nav.classList.contains('active');
                if (isOpen) {
                    nav.classList.remove('active');
                    overlay.classList.remove('active');
                    document.body.style.overflow = '';
                } else {
                    nav.classList.add('active');
                    overlay.classList.add('active');
                    document.body.style.overflow = 'hidden';
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
    </script>
</body>

</html>