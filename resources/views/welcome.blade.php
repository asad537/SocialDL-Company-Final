<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Video Saver - HD Video & Music Downloader</title>
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
            --bg-off: #F9FAFB;
            --border: #E5E7EB;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        body {
            background-color: var(--bg-light);
            color: var(--text-dark);
            overflow-x: hidden;
        }

        /* ── Header ── */
        header {
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
            height: 80px;
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
            color: var(--primary);
        }

        .lang-dropdown {
            background: rgba(255, 255, 255, 0.6);
            border: 1px solid rgba(0, 0, 0, 0.1);
            padding: 7px 14px;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            backdrop-filter: blur(4px);
        }

        /* ── Hero ── */
        .hero {
            position: relative;
            width: 100%;
            height: 500px;
            /* Default for mobile/tablets */
            display: flex;
            align-items: center;
            padding: 4rem 0;
            overflow: hidden;
        }

        /* 13 inch screens (~1280px to 1440px) */
        @media (min-width: 1200px) {
            .hero {
                height: 500px;
            }
        }

        /* 15 inch screens (~1440px to 1600px) */
        @media (min-width: 1440px) {
            .hero {
                height: 550px;
            }
        }

        /* Above 15 inch (>1600px) */
        @media (min-width: 1600px) {
            .hero {
                height: 560px;
            }
        }

        /* BG image — Covers full width without stretching */
        .hero-bg-img {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center right;
            /* Phones right side pe hain */
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
            max-width: 750px;
        }

        .hero h1 {
            font-size: 2rem;
            font-weight: 600;
            line-height: 1.2;
            color: var(--text-dark);
            margin-bottom: 2rem;
        }

        .hero-btn {
            background: var(--primary);
            color: var(--text-dark);
            text-decoration: none;
            padding: 16px 32px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 1.1rem;
            display: inline-block;
            box-shadow: 0 10px 15px -3px rgba(255, 184, 0, 0.3);
            transition: all 0.2s;
            margin-bottom: 3rem;
        }

        .hero-btn:hover {
            background: var(--primary-hover);
            transform: translateY(-2px);
        }

        .trust-row {
            display: flex;
            align-items: center;
            gap: 2rem;
        }

        .trust-item {
            display: flex;
            align-items: center;
            gap: 8px;
            color: var(--text-gray);
            font-weight: 600;
            font-size: 0.95rem;
        }

        .trust-item img {
            height: 24px;
        }

        /* ── Search Section ── */
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
            gap: 10px;
            transition: background 0.2s;
        }

        .search-container button:hover {
            background: var(--primary-hover);
        }

        .search-container button i {
            background: rgba(0, 0, 0, 0.1);
            width: 24px;
            height: 24px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
        }

        .tutorial-link {
            margin-top: 1.5rem;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #3B82F6;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.95rem;
        }

        .tutorial-link i {
            font-size: 1.2rem;
        }

        .tutorial-link span {
            color: var(--text-gray);
            font-weight: 400;
            margin-left: 5px;
        }

        /* ── Loader ── */
        .loader-box {
            display: none;
            text-align: center;
            padding: 4rem 1rem;
        }

        .spinner {
            width: 50px;
            height: 50px;
            border: 4px solid #F3F4F6;
            border-top-color: var(--primary);
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto 20px;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* ── Skeleton ── */
        .skeleton-wrapper {
            max-width: 1100px;
            margin: 2rem auto;
            display: none;
            grid-template-columns: 320px 1fr;
            gap: 30px;
            padding: 0 2rem;
        }

        .skeleton-box {
            background: #F9FAFB;
            border-radius: 24px;
            border: 1px solid var(--border);
            padding: 24px;
        }

        .skel {
            background: #E5E7EB;
            border-radius: 8px;
            animation: pulse 1.5s infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.5;
            }
        }

        /* ── Results ── */
        .results-wrapper {
            max-width: 1100px;
            margin: 2rem auto 5rem;
            display: none;
            grid-template-columns: 320px 1fr;
            gap: 30px;
            padding: 0 2rem;
        }

        .sidebar {
            background: white;
            border-radius: 24px;
            border: 1px solid var(--border);
            padding: 24px;
            height: fit-content;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }

        .thumb-box {
            width: 100%;
            aspect-ratio: 16/9;
            border-radius: 16px;
            overflow: hidden;
            margin-bottom: 20px;
            background: #000;
        }

        .thumb-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .main-content {
            background: white;
            border-radius: 24px;
            border: 1px solid var(--border);
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }

        .section-header {
            padding: 15px 25px;
            border-bottom: 1px solid var(--border);
            background: #F9FAFB;
            font-weight: 700;
            color: var(--text-dark);
        }

        .format-row {
            display: grid;
            grid-template-columns: 80px 120px 1fr 200px;
            padding: 15px 25px;
            align-items: center;
            border-bottom: 1px solid var(--border);
        }

        .dl-btn {
            background: var(--primary);
            color: var(--text-dark);
            padding: 8px 18px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 700;
            font-size: 0.85rem;
            transition: background 0.2s;
        }

        .dl-btn:hover {
            background: var(--primary-hover);
        }

        #error {
            color: #EF4444;
            text-align: center;
            max-width: 700px;
            margin: 2rem auto;
            display: none;
            font-weight: 600;
            padding: 1rem 2rem;
            background: #FEF2F2;
            border: 1px solid #FEE2E2;
            border-radius: 12px;
        }

        /* ── Responsive ── */
        @media (max-width: 1024px) {
            .hero {
                background-position: center bottom;
                text-align: center;
                padding-bottom: 300px;
            }

            .hero-content {
                max-width: 100%;
            }

            .trust-row {
                justify-content: center;
                flex-wrap: wrap;
            }

            .results-wrapper,
            .skeleton-wrapper {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

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
                <div class="lang-dropdown">
                    English <i class="fas fa-chevron-down"></i>
                </div>
            </div>
        </div>
    </header>

    <section class="hero">
        <img class="hero-bg-img" src="/images/hero_section.jpeg" alt="">
        <div class="hero-container">
            <div class="hero-content">
                <h1>HD Video & Music Downloader for<br>Seamless Downloads</h1>
                <a href="#" class="hero-btn">Download Video Saver</a>

                <div class="trust-row">
                    <div class="trust-item">
                        <img src="/images/security2.png" alt="McAfee"> McAfee
                    </div>
                    <div class="trust-item">
                        <img src="/images/security1.png" alt="CM Security"> CM Security
                    </div>
                    <div class="trust-item">
                        <img src="/images/security2.png" alt="Lookout"> Lookout
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="search-section">
        <div class="hero-container">
            <h2>Paste Your Link & Download Instantly</h2>
            <div class="search-box-wrap">
                <div class="search-container" id="searchBox">
                    <i class="fas fa-globe"></i>
                    <input type="text" id="videoUrl" placeholder="Paste your link here" autocomplete="off"
                        spellcheck="false">
                    <button id="fetchBtn"><i class="fas fa-arrow-down"></i> Download</button>
                </div>
                <a href="#" class="tutorial-link">
                    <i class="fab fa-youtube" style="color: #FF0000;"></i> How to download? <span>Watch the
                        tutorial</span>
                </a>
            </div>
        </div>
    </section>

    <div class="loader-box" id="loader">
        <div class="spinner"></div>
        <p>Connecting to platform...</p>
    </div>

    <div class="skeleton-wrapper" id="skeleton"></div>

    <div id="error"></div>

    <div class="results-wrapper" id="results">
        <aside class="sidebar">
            <div class="thumb-box"><img id="thumb" src="" alt="thumbnail"></div>
            <h2 class="video-title" id="title">Video Title</h2>
            <p style="color: var(--text-gray); font-size: 0.85rem;">Platform: <span id="source"
                    style="color: var(--text-dark); font-weight:700;">—</span></p>
        </aside>

        <main class="main-content">
            <div class="section-header">Video Files</div>
            <div id="video-list"></div>
            <div class="section-header" style="margin-top:1px;">Audio Files</div>
            <div id="audio-list"></div>
        </main>
    </div>

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
                render(data);
            } catch (e) {
                errorDiv.innerHTML = `Error: ${e.message}`;
                errorDiv.style.display = 'block';
            } finally {
                loader.style.display = 'none';
            }
        }

        fetchBtn.addEventListener('click', () => fetchVideo(input.value.trim()));
        input.addEventListener('keydown', e => { if (e.key === 'Enter') fetchVideo(input.value.trim()); });

        function render(data) {
            document.getElementById('title').textContent = data.title;
            document.getElementById('thumb').src = `/thumbnail-proxy?url=${encodeURIComponent(data.thumbnail)}`;
            document.getElementById('source').textContent = data.source;

            const vList = document.getElementById('video-list');
            const aList = document.getElementById('audio-list');
            vList.innerHTML = aList.innerHTML = '';

            data.medias.forEach(m => {
                const dlUrl = `/direct-download?url=${encodeURIComponent(m.url)}&title=${encodeURIComponent(data.title)}&ext=${m.extension}`;
                const row = document.createElement('div');
                row.className = 'format-row';
                row.innerHTML = `
                    <div style="font-weight:700">${m.extension.toUpperCase()}</div>
                    <div style="font-weight:600">${m.quality}</div>
                    <div style="color:var(--text-gray); font-size:0.85rem">${m.size || ''}</div>
                    <a href="${dlUrl}" target="_blank" class="dl-btn">Download</a>`;
                (m.type === 'video' ? vList : aList).appendChild(row);
            });
            resultsBox.style.display = 'grid';
        }
    </script>
</body>

</html>