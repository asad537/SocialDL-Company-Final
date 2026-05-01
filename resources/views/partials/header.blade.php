<header>
    <div class="header-container">
        <a href="/" class="logo">
            <img src="/images/logo.png" alt="Video Saver">
        </a>
        <div class="nav-wrap">
            <ul class="nav-links">
                <li><a href="#">Home</a></li>
                <li><a href="#">Supported Platforms</a></li>
                <li><a href="#">Help Center</a></li>
                <li><a href="#">FAQs</a></li>
                <li><a href="#">Download</a></li>
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
            <!-- Hidden but active Google Translate Element -->
            <div id="google_translate_element"
                style="position: absolute; opacity: 0; pointer-events: none; height: 0; overflow: hidden;"></div>
        </div>
    </div>
</header>
