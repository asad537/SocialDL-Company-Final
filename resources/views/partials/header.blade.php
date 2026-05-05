<header class="site-header">
    <div class="header-container">

        <!-- Mobile Hamburger (LEFT) — hidden on desktop -->
        <button class="hamburger" id="hamburger" onclick="toggleMobileMenu()" aria-label="Menu">
            <span></span><span></span><span></span>
        </button>

        <!-- Logo (CENTER on mobile, LEFT on desktop) -->
        <a href="/" class="logo">
            <img src="/images/logofinal.png" alt="Video Saver">
        </a>

        <!-- Desktop Nav -->
        <div class="nav-wrap">
            <ul class="nav-links">
                <li><a href="/">Home</a></li>
                <li><a href="/#supported-platforms">Supported Platforms</a></li>
                <li><a href="/blogs">Blog</a></li>
                <li><a href="/faqs">FAQs</a></li>
                <li><a href="/#download">Download</a></li>
            </ul>
            <div class="lang-dropdown" onclick="toggleLangMenu()">
                <span id="current-lang">English</span> <i class="fas fa-chevron-down"></i>
                <div id="lang-menu" class="lang-menu">
                    <div onclick="changeLanguage('en')">English</div>
                    <div onclick="changeLanguage('ar')">Arabic</div>
                    <div onclick="changeLanguage('ur')">Urdu</div>
                    <div onclick="changeLanguage('hi')">Hindi</div>
                    <div onclick="changeLanguage('es')">Spanish</div>
                    <div onclick="changeLanguage('fr')">French</div>
                </div>
            </div>
        </div>

        <!-- Mobile Lang (RIGHT) — hidden on desktop -->
        <div class="lang-dropdown lang-dropdown-mobile" onclick="toggleLangMenuMobile()">
            <span id="current-lang-mobile">English</span> <i class="fas fa-chevron-down"></i>
            <div id="lang-menu-mobile" class="lang-menu">
                <div onclick="changeLanguage('en')">English</div>
                <div onclick="changeLanguage('ar')">Arabic</div>
                <div onclick="changeLanguage('ur')">Urdu</div>
                <div onclick="changeLanguage('hi')">Hindi</div>
                <div onclick="changeLanguage('es')">Spanish</div>
                <div onclick="changeLanguage('fr')">French</div>
            </div>
        </div>
    </div>

    <!-- Mobile Slide-down Nav (Sidebar) -->
    <div class="mobile-nav" id="mobile-nav">
        <!-- Logo at top of sidebar -->
        <div style="text-align: center; padding: 2.5rem 0 1.5rem;">
            <img src="/images/logofinal.png" alt="Video Saver" style="height: 60px; width: auto;">
        </div>
        <ul>
            <li><a href="/" onclick="toggleMobileMenu()">Home</a></li>
            <li><a href="/#supported-platforms" onclick="toggleMobileMenu()">Supported Platforms</a></li>
            <li><a href="/blogs" onclick="toggleMobileMenu()">Blog</a></li>
            <li><a href="/faqs" onclick="toggleMobileMenu()">FAQs</a></li>
            <li><a href="/#download" onclick="toggleMobileMenu()">Download</a></li>
        </ul>
    </div>

    <!-- Mobile Overlay -->
    <div class="mobile-overlay" id="mobile-overlay" onclick="toggleMobileMenu()"></div>

    <!-- Hidden Google Translate -->
    <div id="google_translate_element"
        style="position: absolute; opacity: 0; pointer-events: none; height: 0; overflow: hidden;"></div>
</header>

<style>
    /* ── Header Styles ── */
    .hamburger { display: none; }
    .mobile-nav { display: none; }
    .mobile-overlay { display: none; }
    .lang-dropdown-mobile { display: none; }

    @media (max-width: 768px) {
        /* Desktop-only elements */
        .nav-wrap { display: none !important; }

        /* Mobile header: 3-column layout — ≡ | LOGO | English */
        .site-header .header-container {
            display: grid !important;
            grid-template-columns: auto 1fr auto;
            align-items: center;
            padding: 0 1rem !important;
        }

        /* Hamburger: far left */
        .hamburger {
            display: flex !important;
            background: none;
            border: none;
            cursor: pointer;
            flex-direction: column;
            gap: 5px;
            padding: 4px;
            order: 1;
        }

        .hamburger span {
            display: block;
            width: 24px;
            height: 2.5px;
            background: #111827;
            border-radius: 3px;
            transition: all 0.3s ease;
        }

        .hamburger.open span:nth-child(1) { transform: translateY(7.5px) rotate(45deg); }
        .hamburger.open span:nth-child(2) { opacity: 0; }
        .hamburger.open span:nth-child(3) { transform: translateY(-7.5px) rotate(-45deg); }

        /* Logo: centered */
        .site-header .logo {
            order: 2;
            display: flex;
            justify-content: center;
        }

        /* Lang dropdown: far right */
        .lang-dropdown-mobile {
            order: 3;
            display: flex !important;
            border: 1px solid #000 !important; /* Black border */
            background: #fff !important; /* Solid white background for contrast */
            padding: 6px 12px !important;
            border-radius: 8px !important;
        }

        /* Sidebar Nav */
        .mobile-nav {
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0;
            left: -280px;
            width: 280px;
            height: 100vh;
            background: #fff;
            box-shadow: 2px 0 12px rgba(0,0,0,0.1);
            transition: left 0.3s ease;
            z-index: 1000;
            overflow-y: auto;
        }

        .mobile-nav.open {
            left: 0;
        }

        .mobile-nav ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .mobile-nav ul li a {
            display: block;
            padding: 1.2rem 1.5rem;
            font-size: 1.1rem;
            font-weight: 600;
            color: #111827;
            text-decoration: none;
            border-bottom: 1px solid #F3F4F6;
            text-align: center;
        }

        /* Overlay */
        .mobile-overlay {
            display: block;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            background: rgba(0, 0, 0, 0.5);
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease, visibility 0.3s ease;
            z-index: 999;
        }

        .mobile-overlay.open {
            opacity: 1;
            visibility: visible;
        }

        /* Sticky Header on Mobile */
        .site-header {
            position: sticky !important;
            top: 0 !important;
            background: #ffffff !important;
            box-shadow: 0 2px 12px rgba(0,0,0,0.09);
            z-index: 999 !important;
            padding: 0.6rem 0 !important;
        }

        .faq-header {
            padding-top: 4rem !important;
        }
    }
</style>

<script>
    function toggleMobileMenu() {
        const nav = document.getElementById('mobile-nav');
        const overlay = document.getElementById('mobile-overlay');
        const btn = document.getElementById('hamburger');
        nav.classList.toggle('open');
        overlay.classList.toggle('open');
        btn.classList.toggle('open');
        
        // Prevent body scroll when menu is open
        if (nav.classList.contains('open')) {
            document.body.style.overflow = 'hidden';
        } else {
            document.body.style.overflow = '';
        }
    }

    function toggleLangMenuMobile() {
        const menu = document.getElementById('lang-menu-mobile');
        if (menu) menu.style.display = menu.style.display === 'flex' ? 'none' : 'flex';
    }

    window.addEventListener('click', function(e) {
        if (!e.target.closest('.lang-dropdown-mobile')) {
            const m = document.getElementById('lang-menu-mobile');
            if (m) m.style.display = 'none';
        }
    });
</script>
