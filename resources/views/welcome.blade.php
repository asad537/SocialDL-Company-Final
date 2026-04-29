<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SocialDL - Premium Video Downloader</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #8b5cf6;
            --primary-light: #a78bfa;
            --bg-dark: #020617;
            --card-bg: #0f172a;
            --border: #1e293b;
            --text-main: #f8fafc;
            --text-dim: #94a3b8;
            --accent: #ec4899;
            --success: #10b981;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        body {
            background-color: var(--bg-dark);
            color: var(--text-main);
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* Header / Search Area */
        .hero {
            background: linear-gradient(180deg, #1e1b4b 0%, var(--bg-dark) 100%);
            padding: 4rem 1rem;
            text-align: center;
        }

        .search-container {
            max-width: 800px;
            margin: 2rem auto 0;
            position: relative;
            background: var(--card-bg);
            padding: 8px;
            border-radius: 20px;
            border: 1px solid var(--border);
            display: flex;
            box-shadow: 0 20px 40px rgba(0,0,0,0.4);
        }

        .search-container input {
            flex: 1;
            background: transparent;
            border: none;
            padding: 1rem 1.5rem;
            color: white;
            font-size: 1.1rem;
            outline: none;
        }

        .search-container button {
            background: var(--primary);
            color: white;
            border: none;
            padding: 0 2.5rem;
            border-radius: 14px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .search-container button:hover {
            background: var(--primary-light);
            transform: scale(1.02);
        }

        /* Results Layout */
        .results-wrapper {
            max-width: 1200px;
            margin: -40px auto 4rem;
            display: grid;
            grid-template-columns: 350px 1fr;
            gap: 30px;
            padding: 0 1rem;
            display: none; /* hidden initially */
        }

        .sidebar {
            background: var(--card-bg);
            border-radius: 24px;
            border: 1px solid var(--border);
            padding: 20px;
            height: fit-content;
            position: sticky;
            top: 20px;
        }

        .thumb-box {
            width: 100%;
            aspect-ratio: 16/9;
            border-radius: 16px;
            overflow: hidden;
            margin-bottom: 20px;
            position: relative;
        }

        .thumb-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .duration-badge {
            position: absolute;
            bottom: 10px;
            right: 10px;
            background: rgba(0,0,0,0.8);
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .video-title {
            font-size: 1.2rem;
            font-weight: 700;
            line-height: 1.4;
            margin-bottom: 15px;
        }

        /* Main Table */
        .main-content {
            background: var(--card-bg);
            border-radius: 24px;
            border: 1px solid var(--border);
            overflow: hidden;
        }

        .section-header {
            padding: 20px 25px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            gap: 12px;
            background: rgba(255,255,255,0.02);
        }

        .section-header h3 {
            font-size: 1.1rem;
            font-weight: 700;
        }

        .format-row {
            display: grid;
            grid-template-columns: 80px 100px 1fr 150px;
            padding: 18px 25px;
            align-items: center;
            border-bottom: 1px solid var(--border);
            transition: background 0.2s;
        }

        .format-row:hover {
            background: rgba(255,255,255,0.03);
        }

        .badge-ext {
            background: #f59e0b;
            color: black;
            padding: 4px 8px;
            border-radius: 6px;
            font-weight: 800;
            font-size: 0.75rem;
            text-align: center;
            width: fit-content;
        }

        .quality-text {
            font-weight: 700;
            font-size: 1.05rem;
        }

        .size-text {
            color: var(--text-dim);
            font-size: 0.9rem;
        }

        .dl-btn-premium {
            background: transparent;
            border: 2px solid var(--success);
            color: var(--success);
            padding: 10px 20px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 700;
            font-size: 0.9rem;
            text-align: center;
            transition: all 0.2s;
        }

        .dl-btn-premium:hover {
            background: var(--success);
            color: white;
            box-shadow: 0 0 20px rgba(16, 185, 129, 0.4);
        }

        .no-audio-tag {
            color: #ef4444;
            font-size: 0.7rem;
            font-weight: 600;
            display: block;
            margin-top: 2px;
        }

        /* Loader */
        .loader-box {
            display: none;
            text-align: center;
            padding: 4rem;
        }

        .spinner {
            width: 50px;
            height: 50px;
            border: 5px solid rgba(139, 92, 246, 0.1);
            border-top-color: var(--primary);
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto 20px;
        }

        @keyframes spin { to { transform: rotate(360deg); } }

        @media (max-width: 900px) {
            .results-wrapper { grid-template-columns: 1fr; }
            .sidebar { position: static; }
            .format-row { grid-template-columns: 60px 80px 1fr 100px; padding: 15px; }
            .dl-btn-premium { padding: 8px 12px; font-size: 0.8rem; }
        }
    </style>
</head>
<body>

    <section class="hero">
        <h1 style="font-size: 3rem; font-weight: 800; letter-spacing: -1px;">SocialDL</h1>
        <p style="color: var(--text-dim); margin-top: 10px;">The fastest way to download videos & music</p>
        
        <div class="search-container">
            <input type="text" id="videoUrl" placeholder="Paste link from YouTube, Instagram, etc..." autocomplete="off">
            <button id="downloadBtn">
                <span>Download</span>
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
            </button>
        </div>
    </section>

    <div class="loader-box" id="loader">
        <div class="spinner"></div>
        <p>Analyzing your link...</p>
    </div>

    <div id="error" style="color: #ef4444; text-align: center; margin-bottom: 2rem; display: none;"></div>

    <div class="results-wrapper" id="results">
        <aside class="sidebar">
            <div class="thumb-box">
                <img id="thumb" src="" alt="Thumbnail">
                <span class="duration-badge" id="duration">--:--</span>
            </div>
            <h2 class="video-title" id="title">Video Title</h2>
            <p style="color: var(--text-dim); font-size: 0.9rem;">Source: <span id="source" style="color: var(--primary-light);">YouTube</span></p>
        </aside>

        <main>
            <div class="main-content">
                <!-- Video Section -->
                <div class="section-header">
                    <svg width="24" height="24" fill="var(--primary)" viewBox="0 0 24 24"><path d="M17 10.5V7c0-.55-.45-1-1-1H4c-.55 0-1 .45-1 1v10c0 .55.45 1 1 1h12c.55 0 1-.45 1-1v-3.5l4 4v-11l-4 4z"></path></svg>
                    <h3>Video Downloads</h3>
                </div>
                <div id="video-list"></div>

                <!-- Audio Section -->
                <div class="section-header" style="margin-top: 20px;">
                    <svg width="24" height="24" fill="#f59e0b" viewBox="0 0 24 24"><path d="M12 3v10.55c-.59-.34-1.27-.55-2-.55-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4V7h4V3h-6z"></path></svg>
                    <h3>Music / Audio Only</h3>
                </div>
                <div id="audio-list"></div>
            </div>
        </main>
    </div>

    <script>
        const videoUrlInput = document.getElementById('videoUrl');
        const downloadBtn = document.getElementById('downloadBtn');
        const loader = document.getElementById('loader');
        const resultsBox = document.getElementById('results');
        const errorDiv = document.getElementById('error');

        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        downloadBtn.addEventListener('click', async () => {
            const url = videoUrlInput.value.trim();
            if (!url) return;

            loader.style.display = 'block';
            resultsBox.style.display = 'none';
            errorDiv.style.display = 'none';

            try {
                const response = await fetch('/extract', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                    body: JSON.stringify({ url: url })
                });

                const data = await response.json();
                if (data.error) throw new Error(data.error);

                renderResults(data);
            } catch (err) {
                errorDiv.textContent = err.message;
                errorDiv.style.display = 'block';
            } finally {
                loader.style.display = 'none';
            }
        });

        function renderResults(data) {
            document.getElementById('title').textContent = data.title;
            document.getElementById('thumb').src = `/thumbnail-proxy?url=${encodeURIComponent(data.thumbnail)}`;
            document.getElementById('source').textContent = data.source;
            document.getElementById('duration').textContent = data.duration || '00:00';

            const videoList = document.getElementById('video-list');
            const audioList = document.getElementById('audio-list');
            videoList.innerHTML = '';
            audioList.innerHTML = '';

            data.medias.forEach(media => {
                const row = document.createElement('div');
                row.className = 'format-row';
                
                const hasAudioTag = !media.has_audio && media.type === 'video' ? '<span class="no-audio-tag">MERGING AUDIO...</span>' : '';

                let downloadUrl;
                if (media.type === 'video' && !media.has_audio && data.best_audio_url) {
                    // Use merge route
                    downloadUrl = `/merge-download?video_url=${encodeURIComponent(media.url)}&audio_url=${encodeURIComponent(data.best_audio_url)}&title=${encodeURIComponent(data.title)}`;
                } else {
                    // Use proxy route
                    downloadUrl = `/proxy-download?url=${encodeURIComponent(media.url)}&title=${encodeURIComponent(data.title)}&ext=${encodeURIComponent(media.extension.toLowerCase())}`;
                }

                row.innerHTML = `
                    <div class="badge-ext">${media.extension}</div>
                    <div class="quality-text">${media.quality} ${hasAudioTag}</div>
                    <div class="size-text">${media.size || 'Unknown Size'}</div>
                    <a href="${downloadUrl}" target="_blank" class="dl-btn-premium">Download</a>
                `;

                if (media.type === 'video') {
                    videoList.appendChild(row);
                } else {
                    audioList.appendChild(row);
                }
            });

            resultsBox.style.display = 'grid';
            resultsBox.scrollIntoView({ behavior: 'smooth' });
        }

        videoUrlInput.addEventListener('keypress', (e) => { if (e.key === 'Enter') downloadBtn.click(); });
    </script>
</body>
</html>
