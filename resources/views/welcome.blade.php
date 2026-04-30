<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SocialDL Pro - Universal Video Downloader</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #6366f1;
            --primary-light: #818cf8;
            --bg-dark: #0f172a;
            --card-bg: #1e293b;
            --border: #334155;
            --text-main: #f8fafc;
            --text-dim: #94a3b8;
            --success: #22c55e;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Plus Jakarta Sans', sans-serif; }
        body { background-color: var(--bg-dark); color: var(--text-main); min-height: 100vh; }

        /* ── Hero ── */
        .hero {
            background: linear-gradient(180deg, #1e1b4b 0%, var(--bg-dark) 100%);
            padding: 5rem 1rem 6rem;
            text-align: center;
        }

        /* ── Search bar ── */
        .search-wrap { position: relative; max-width: 800px; margin: 2.5rem auto 0; }
        .auto-hint {
            position: absolute; top: -30px; left: 50%; transform: translateX(-50%);
            background: rgba(99,102,241,0.15); border: 1px solid rgba(99,102,241,0.35);
            color: var(--primary-light); font-size: 0.78rem; font-weight: 600;
            padding: 3px 14px; border-radius: 20px; white-space: nowrap;
            opacity: 0; transition: opacity 0.2s; pointer-events: none;
        }
        .auto-hint.visible { opacity: 1; }

        .search-container {
            background: var(--card-bg); padding: 8px; border-radius: 20px;
            border: 1px solid var(--border); display: flex;
            box-shadow: 0 20px 40px rgba(0,0,0,0.35);
            transition: border-color 0.3s, box-shadow 0.3s;
        }
        .search-container.detecting {
            border-color: var(--primary);
            animation: borderPulse 1.2s ease-in-out infinite;
        }
        @keyframes borderPulse {
            0%,100% { box-shadow: 0 0 0 3px rgba(99,102,241,0.2), 0 20px 40px rgba(0,0,0,0.35); }
            50%      { box-shadow: 0 0 0 7px rgba(99,102,241,0.06), 0 20px 40px rgba(0,0,0,0.35); }
        }
        .search-container input {
            flex: 1; background: transparent; border: none;
            padding: 1rem 1.5rem; color: white; font-size: 1.05rem; outline: none;
        }
        .search-container input::placeholder { color: var(--text-dim); }
        .search-container button {
            background: var(--primary); color: white; border: none;
            padding: 0 2rem; border-radius: 14px; font-weight: 700;
            font-size: 0.95rem; cursor: pointer; transition: all 0.2s; white-space: nowrap;
        }
        .search-container button:hover:not(:disabled) { background: var(--primary-light); transform: translateY(-2px); }
        .search-container button:disabled { opacity: 0.5; cursor: not-allowed; }

        /* ── Spinner loader ── */
        .loader-box { display: none; text-align: center; padding: 3rem 1rem; }
        .spinner {
            width: 44px; height: 44px;
            border: 4px solid rgba(99,102,241,0.1);
            border-top-color: var(--primary);
            border-radius: 50%; animation: spin 0.9s linear infinite;
            margin: 0 auto 16px;
        }
        @keyframes spin { to { transform: rotate(360deg); } }
        .loader-title { font-weight: 600; font-size: 1rem; }
        .loader-status { font-size: 0.85rem; color: var(--text-dim); margin-top: 6px; min-height: 1.2em; }

        /* ── Skeleton loader (shows INSTANTLY, 0ms) ── */
        .skeleton-wrapper {
            max-width: 1100px; margin: -40px auto 4rem;
            display: none; grid-template-columns: 320px 1fr;
            gap: 30px; padding: 0 1rem;
        }
        .skeleton-box {
            background: var(--card-bg); border-radius: 24px;
            border: 1px solid var(--border); padding: 20px;
        }
        .skel {
            background: linear-gradient(90deg, #1e293b 25%, #263148 50%, #1e293b 75%);
            background-size: 200% 100%;
            animation: shimmer 1.4s infinite;
            border-radius: 8px;
        }
        @keyframes shimmer {
            0%   { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }
        .skel-thumb  { width:100%; aspect-ratio:16/9; border-radius:16px; margin-bottom:16px; }
        .skel-line   { height:14px; margin-bottom:10px; }
        .skel-line.w80  { width:80%; }
        .skel-line.w50  { width:50%; }
        .skel-row    { display:grid; grid-template-columns:80px 120px 1fr 180px; gap:12px; padding:16px 24px; border-bottom:1px solid var(--border); align-items:center; }
        .skel-row .skel { height:14px; border-radius:6px; }

        /* ── Error ── */
        #error {
            color: #ef4444; text-align: center; margin: 2rem 1rem;
            display: none; font-weight: 600; font-size: 0.95rem;
            background: rgba(239,68,68,0.08); border: 1px solid rgba(239,68,68,0.2);
            padding: 1rem 1.5rem; border-radius: 12px; max-width: 700px; margin: 2rem auto;
        }

        /* ── Results ── */
        .results-wrapper {
            max-width: 1100px; margin: -40px auto 4rem;
            display: none; grid-template-columns: 320px 1fr;
            gap: 30px; padding: 0 1rem;
        }
        .sidebar {
            background: var(--card-bg); border-radius: 24px;
            border: 1px solid var(--border); padding: 20px; height: fit-content;
        }
        .thumb-box {
            width: 100%; aspect-ratio: 16/9; border-radius: 16px;
            overflow: hidden; margin-bottom: 20px; position: relative;
            background: #0f172a;
        }
        .thumb-box img { width: 100%; height: 100%; object-fit: cover; }
        .duration-badge {
            position: absolute; bottom: 10px; right: 10px;
            background: rgba(0,0,0,0.8); padding: 4px 8px;
            border-radius: 6px; font-size: 0.8rem; font-weight: 600;
        }
        .video-title { font-size: 1rem; font-weight: 700; margin-bottom: 10px; line-height: 1.4; }

        .main-content {
            background: var(--card-bg); border-radius: 24px;
            border: 1px solid var(--border); overflow: hidden;
        }
        .section-header {
            padding: 14px 24px; border-bottom: 1px solid var(--border);
            display: flex; align-items: center; gap: 8px;
            background: rgba(255,255,255,0.025); font-size: 0.95rem; font-weight: 700;
        }
        .format-row {
            display: grid; grid-template-columns: 72px 110px 1fr 210px;
            padding: 14px 24px; align-items: center;
            border-bottom: 1px solid var(--border);
            transition: background 0.15s;
        }
        .format-row:hover { background: rgba(255,255,255,0.03); }
        .badge-ext {
            background: #f59e0b; color: #000; padding: 3px 7px;
            border-radius: 6px; font-weight: 800; font-size: 0.68rem;
            width: fit-content; letter-spacing: 0.03em;
        }
        .dl-btn {
            background: transparent; border: 2px solid var(--success);
            color: var(--success); padding: 7px 14px; border-radius: 10px;
            text-decoration: none; font-weight: 700; font-size: 0.82rem;
            text-align: center; transition: all 0.18s; display: inline-block;
        }
        .dl-btn:hover { background: var(--success); color: white; }
        .proxy-btn {
            border-color: #6366f1; color: #6366f1;
            font-size: 0.75rem; padding: 6px 10px;
        }
        .proxy-btn:hover { background: #6366f1; color: white; }
    </style>
</head>
<body>

    <section class="hero">
        <h1 style="font-size: 2.6rem; font-weight: 800; letter-spacing: -0.5px;">SocialDL Pro</h1>
        <p style="color: var(--text-dim); margin-top: 10px; font-size: 1.05rem;">
            Paste any link — results appear <strong style="color:var(--primary-light);">automatically</strong>
        </p>
        <div class="search-wrap">
            <span class="auto-hint" id="autoHint">⚡ Link detected — fetching...</span>
            <div class="search-container" id="searchBox">
                <input type="text" id="videoUrl"
                    placeholder="Paste YouTube / Instagram / TikTok / Facebook link here..."
                    autocomplete="off" spellcheck="false">
                <button id="fetchBtn">Fetch Now</button>
            </div>
        </div>
    </section>

    <div class="loader-box" id="loader">
        <div class="spinner"></div>
        <p class="loader-title">Fetching video info...</p>
        <p class="loader-status" id="loaderStatus">Connecting to platform...</p>
    </div>

    {{-- Skeleton: shows INSTANTLY (0ms) when URL is pasted --}}
    <div class="skeleton-wrapper" id="skeleton">
        <div class="skeleton-box">
            <div class="skel skel-thumb"></div>
            <div class="skel skel-line w80"></div>
            <div class="skel skel-line w50"></div>
        </div>
        <div class="skeleton-box" style="padding:0;overflow:hidden">
            <div style="padding:14px 24px;border-bottom:1px solid var(--border);background:rgba(255,255,255,0.025)">
                <div class="skel skel-line w50" style="margin:0"></div>
            </div>
            <div class="skel-row"><div class="skel"></div><div class="skel"></div><div class="skel"></div><div class="skel"></div></div>
            <div class="skel-row"><div class="skel"></div><div class="skel"></div><div class="skel"></div><div class="skel"></div></div>
            <div class="skel-row"><div class="skel"></div><div class="skel"></div><div class="skel"></div><div class="skel"></div></div>
            <div style="padding:14px 24px;border-bottom:1px solid var(--border);background:rgba(255,255,255,0.025);margin-top:1px">
                <div class="skel skel-line w50" style="margin:0"></div>
            </div>
            <div class="skel-row"><div class="skel"></div><div class="skel"></div><div class="skel"></div><div class="skel"></div></div>
        </div>
    </div>

    <div id="error"></div>

    <div class="results-wrapper" id="results">
        <aside class="sidebar">
            <div class="thumb-box">
                <img id="thumb" src="" alt="thumbnail">
                <span class="duration-badge" id="duration">--:--</span>
            </div>
            <h2 class="video-title" id="title">Video Title</h2>
            <p style="color: var(--text-dim); font-size: 0.82rem;">
                Platform: <span id="source" style="color: var(--primary-light); font-weight:600;">—</span>
            </p>
        </aside>

        <main class="main-content">
            <div class="section-header">🎬 Video Files</div>
            <div id="video-list"></div>
            <div class="section-header" style="margin-top:1px;">🎵 Audio Files</div>
            <div id="audio-list"></div>
        </main>
    </div>

    <script>
        const input        = document.getElementById('videoUrl');
        const fetchBtn     = document.getElementById('fetchBtn');
        const searchBox    = document.getElementById('searchBox');
        const autoHint     = document.getElementById('autoHint');
        const skeleton     = document.getElementById('skeleton');
        const loader       = document.getElementById('loader');
        const loaderStatus = document.getElementById('loaderStatus');
        const resultsBox   = document.getElementById('results');
        const errorDiv     = document.getElementById('error');
        const csrf         = document.querySelector('meta[name="csrf-token"]').content;

        let timer     = null;
        let busy      = false;

        /* ── URL validator ─────────────────────────────────── */
        const isUrl = s => /^https?:\/\/.{8,}/.test(s.trim());

        /* ── Helper: hide all loading states ──────────────── */
        function hideLoading() {
            skeleton.style.display    = 'none';
            loader.style.display      = 'none';
            busy                      = false;
            fetchBtn.disabled         = false;
            fetchBtn.textContent      = 'Fetch Now';
        }

        /* ── Status cycling messages ───────────────────────── */
        const STATUSES = [
            'Connecting to platform...',
            'Extracting video metadata...',
            'Scanning available formats...',
            'Almost ready...'
        ];

        /* ── Main fetch ────────────────────────────────────── */
        async function fetchVideo(url) {
            if (busy) return;
            busy = true;

            // UI: loading state
            searchBox.classList.remove('detecting');
            autoHint.classList.remove('visible');
            fetchBtn.disabled = true;
            fetchBtn.textContent = 'Fetching...';
            errorDiv.style.display = 'none';
            resultsBox.style.display = 'none';

            // ★ Show skeleton INSTANTLY (0ms) so user sees activity right away
            skeleton.style.display = 'grid';
            skeleton.scrollIntoView({ behavior: 'smooth', block: 'start' });

            // Cycle status text
            let si = 0;
            loaderStatus.textContent = STATUSES[0];
            const tick = setInterval(() => {
                si = Math.min(si + 1, STATUSES.length - 1);
                loaderStatus.textContent = STATUSES[si];
            }, 2500);

            try {
                const res  = await fetch('/extract', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf },
                    body: JSON.stringify({ url })
                });
                const data = await res.json();
                if (data.error) throw new Error(data.error);
                render(data);
            } catch (e) {
                errorDiv.innerHTML = `❌ ${e.message}`;
                errorDiv.style.display = 'block';
            } finally {
                clearInterval(tick);
                hideLoading();
            }
        }

        /* ── Paste → instant fetch (300ms settle delay) ────── */
        input.addEventListener('paste', e => {
            const pasted = (e.clipboardData || window.clipboardData).getData('text').trim();
            if (!isUrl(pasted)) return;
            clearTimeout(timer);
            autoHint.textContent = '⚡ Link detected — fetching...';
            autoHint.classList.add('visible');
            searchBox.classList.add('detecting');
            timer = setTimeout(() => fetchVideo(pasted), 350);
        });

        /* ── Manual typing → 1.2s debounce ────────────────── */
        input.addEventListener('input', () => {
            clearTimeout(timer);
            const val = input.value.trim();
            if (!isUrl(val)) {
                searchBox.classList.remove('detecting');
                autoHint.classList.remove('visible');
                return;
            }
            autoHint.textContent = '⏳ Auto-fetching in 1s...';
            autoHint.classList.add('visible');
            searchBox.classList.add('detecting');
            timer = setTimeout(() => fetchVideo(val), 1200);
        });

        /* ── Button click ──────────────────────────────────── */
        fetchBtn.addEventListener('click', () => {
            clearTimeout(timer);
            const val = input.value.trim();
            if (val) fetchVideo(val);
        });

        /* ── Enter key ─────────────────────────────────────── */
        input.addEventListener('keydown', e => {
            if (e.key === 'Enter') {
                clearTimeout(timer);
                const val = input.value.trim();
                if (val) fetchVideo(val);
            }
        });

        /* ── Render results ────────────────────────────────── */
        function render(data) {
            document.getElementById('title').textContent    = data.title;
            document.getElementById('thumb').src            = `/thumbnail-proxy?url=${encodeURIComponent(data.thumbnail)}`;
            document.getElementById('source').textContent   = data.source;
            document.getElementById('duration').textContent = data.duration || '00:00';

            const vList = document.getElementById('video-list');
            const aList = document.getElementById('audio-list');
            vList.innerHTML = aList.innerHTML = '';

            data.medias.forEach(m => {
                const needsMerge = m.type === 'video' && !m.has_audio && data.best_audio_url;

                const dlUrl = needsMerge
                    ? `/merge-download?video_url=${enc(m.url)}&audio_url=${enc(data.best_audio_url)}&title=${enc(data.title)}`
                    : `/direct-download?url=${enc(m.url)}&title=${enc(data.title)}&ext=${enc(m.extension.toLowerCase())}`;

                const proxyUrl = needsMerge ? null
                    : `/proxy-download?url=${enc(m.url)}&title=${enc(data.title)}&ext=${enc(m.extension.toLowerCase())}`;

                const badge = (!m.has_audio && m.type === 'video')
                    ? '<small style="color:#f59e0b;display:block;font-size:0.68rem;margin-top:2px;">+Audio merge</small>' : '';

                const proxyBtn = proxyUrl
                    ? `<a href="${proxyUrl}" target="_blank" class="dl-btn proxy-btn" title="Fallback: stream via server">Proxy</a>`
                    : '';

                const row = document.createElement('div');
                row.className = 'format-row';
                row.innerHTML = `
                    <div class="badge-ext">${m.extension}</div>
                    <div style="font-weight:700;line-height:1.3">${m.quality}${badge}</div>
                    <div style="color:var(--text-dim);font-size:0.85rem">${m.size || ''}</div>
                    <div style="display:flex;align-items:center;gap:6px">
                        <a href="${dlUrl}" target="_blank" class="dl-btn">⬇ Download</a>${proxyBtn}
                    </div>`;
                (m.type === 'video' ? vList : aList).appendChild(row);
            });

            resultsBox.style.display = 'grid';
            resultsBox.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }

        const enc = encodeURIComponent;
    </script>
</body>
</html>
