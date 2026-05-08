{{-- ── Reusable Downloader Section ── --}}
{{-- Include on any page with: @include('partials.downloader') --}}

<style>
    /* ── Search Box ── */
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
        background: var(--primary-hover, #e6a700);
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

    .tutorial-link i { font-size: 1.2rem; }

    .tutorial-link span {
        color: #6B7280;
        font-weight: 400;
        margin-left: 5px;
    }

    /* ── Tutorial Modal ── */
    .tutorial-dropdown {
        display: none;
        margin-top: 0.55rem;
        width: 100%;
        background: transparent;
        border: none;
        box-shadow: none;
        padding: 0.6rem 12.5rem 0.3rem;
    }

    .tutorial-dropdown.open {
        display: block;
    }

    .tutorial-steps {
        display: grid;
        grid-template-columns: repeat(5, minmax(0, 1fr));
        gap: 8px;
        margin-top: 0;
    }

    .tutorial-step {
        text-align: center;
    }

    .tutorial-step-num {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background: #FFB800;
        color: #111827;
        font-weight: 800;
        font-size: 1rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 12px;
    }

    .tutorial-step-card {
        border: 1.5px solid #F3E9C7;
        border-radius: 14px;
        background: #fff;
        padding: 8px 8px 10px;
        min-height: 208px;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .tutorial-thumb {
        width: 100%;
        max-width: 152px;
        height: 54px;
        border: 1px solid #F3E9C7;
        border-radius: 8px;
        background: #FFFCF2;
        margin-bottom: 10px;
        position: relative;
        overflow: hidden;
        padding: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .tutorial-thumb-ui {
        width: 100%;
        height: 100%;
        border-radius: 5px;
        border: 1px solid #E5E7EB;
        background: #fff;
        position: relative;
        overflow: hidden;
    }

    .tutorial-thumb-ui::before {
        content: "";
        position: absolute;
        left: 8px;
        top: 50%;
        transform: translateY(-50%);
        height: 6px;
        border-radius: 4px;
        background: #F7E7A5;
    }

    .tutorial-thumb.step-1 .tutorial-thumb-ui::before {
        right: 26px;
    }

    .tutorial-thumb.step-1 .tutorial-thumb-ui::after {
        content: "🔗";
        position: absolute;
        right: 6px;
        top: 50%;
        transform: translateY(-52%);
        font-size: 11px;
        opacity: 0.7;
    }

    .tutorial-thumb.step-2 .tutorial-thumb-ui::before {
        width: calc(100% - 56px);
    }

    .tutorial-thumb.step-2 .tutorial-thumb-ui::after {
        content: "➜";
        position: absolute;
        right: 0;
        top: 0;
        width: 42px;
        height: 100%;
        background: #FFB800;
        color: #fff;
        font-size: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
    }

    .tutorial-thumb.step-3 .tutorial-thumb-ui::before {
        right: 24px;
    }

    .tutorial-thumb.step-3 .tutorial-thumb-ui::after {
        content: "📋";
        position: absolute;
        right: 6px;
        top: 50%;
        transform: translateY(-52%);
        font-size: 11px;
        opacity: 0.75;
    }

    .tutorial-thumb.step-4 .tutorial-thumb-ui {
        border: none;
        background: transparent;
    }

    .tutorial-thumb.step-4 .tutorial-thumb-ui::before,
    .tutorial-thumb.step-4 .tutorial-thumb-ui::after {
        display: none;
    }

    .tutorial-thumb-row {
        height: 46%;
        border: 1px solid #E5E7EB;
        border-radius: 4px;
        background: #fff;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 3px;
    }

    .tutorial-thumb-row + .tutorial-thumb-row {
        margin-top: 2px;
    }

    .tutorial-badge {
        background: #1FBF63;
        color: #fff;
        border-radius: 2px;
        font-size: 7px;
        font-weight: 700;
        padding: 0 3px;
        line-height: 1.45;
    }

    .tutorial-txt {
        color: #374151;
        font-size: 6.5px;
        font-weight: 600;
        margin-left: 3px;
    }

    .tutorial-mini-btn {
        border: 1px solid #D1D5DB;
        border-radius: 2px;
        font-size: 6px;
        padding: 1px 3px;
        color: #111827;
        background: #fff;
        line-height: 1;
    }

    .tutorial-thumb.step-5 .tutorial-thumb-ui::before {
        display: none;
    }

    .tutorial-thumb.step-5 .tutorial-thumb-ui {
        display: flex;
        align-items: center;
        gap: 6px;
        padding: 0 6px;
    }

    .tutorial-dl-btn {
        border: 1px solid #E5E7EB;
        border-radius: 4px;
        padding: 2px 6px;
        font-size: 7px;
        font-weight: 700;
        color: #111827;
        background: #fff;
        white-space: nowrap;
    }

    .tutorial-arrow {
        font-size: 9px;
        color: #111827;
    }

    .tutorial-folder {
        font-size: 11px;
        opacity: 0.8;
    }

    .tutorial-step-card h4 {
        font-size: 0.9rem;
        font-weight: 700;
        color: #111827;
        margin-bottom: 5px;
        line-height: 1.25;
    }

    .tutorial-step-card p {
        font-size: 0.8rem;
        line-height: 1.45;
        color: #4B5563;
        margin: 0;
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
        to { transform: rotate(360deg); }
    }

    /* ── Error ── */
    #dl-error {
        display: none;
        color: #EF4444;
        background: #FEF2F2;
        padding: 1rem 2rem;
        border-radius: 12px;
        margin: 2rem auto 0;
        max-width: 700px;
        font-weight: 600;
        border: 1px solid #FEE2E2;
        text-align: center;
    }

    /* ── Results ── */
    .results-wrapper {
        max-width: 1100px;
        margin: 2rem auto 0;
        display: none;
        flex-direction: row;
        gap: 30px;
        padding: 0 2rem;
        align-items: flex-start;
    }

    .sidebar {
        background: white;
        padding: 15px;
        height: fit-content;
        width: 260px;
        flex-shrink: 0;
    }

    /* Play button overlay on thumbnail */
    .thumb-box {
        width: 100%;
        aspect-ratio: 16/9;
        border-radius: 8px;
        overflow: hidden;
        margin-bottom: 12px;
        background: #E0E0E0;
        position: relative;
        cursor: pointer;
    }

    .thumb-box::after {
        content: '\f144';
        font-family: 'Font Awesome 6 Free';
        font-weight: 900;
        position: absolute;
        inset: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
        color: rgba(255,255,255,0.9);
        background: rgba(0,0,0,0.25);
        transition: background 0.2s;
    }

    .thumb-box:hover::after {
        background: rgba(0,0,0,0.4);
    }

    .thumb-box.playing::after {
        display: none;
    }

    .thumb-box iframe,
    .thumb-box video {
        width: 100%;
        height: 100%;
        border: none;
        display: block;
    }

    .thumb-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .video-title {
        font-size: 0.85rem !important;
        font-weight: 700;
        margin-bottom: 10px !important;
        line-height: 1.3;
        color: #212121;
        display: block;
    }

    .duration-badge {
        background: #FFE082;
        color: #000;
        padding: 4px 10px;
        border-radius: 6px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-weight: 700;
        font-size: 0.8rem;
    }

    .main-content {
        background: white;
        padding: 0 5px;
        flex: 1;
    }

    .section-header {
        padding: 15px 0 8px 0;
        border-bottom: 1px solid #E0E0E0;
        font-size: 1.1rem;
        font-weight: 800;
        color: #000;
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 5px;
    }

    .section-header i {
        color: #FBC02D;
        font-size: 1.2rem;
    }

    .format-row {
        display: grid;
        grid-template-columns: 60px 70px 90px 1fr;
        padding: 12px 0;
        align-items: center;
        border-bottom: 1px solid #F5F5F5;
        gap: 8px;
    }

    .format-badge {
        background: #00C853;
        color: white;
        padding: 3px 0;
        border-radius: 4px;
        font-weight: 800;
        font-size: 0.7rem;
        text-align: center;
        width: 50px;
    }

    .quality-text {
        font-weight: 700;
        font-size: 0.85rem;
        color: #212121;
    }

    .size-text {
        color: #616161;
        font-size: 0.8rem;
        font-weight: 600;
    }

    .dl-btn {
        background: white;
        color: #000;
        border: 1.5px solid #FFC107;
        padding: 6px 15px;
        border-radius: 6px;
        text-decoration: none;
        font-weight: 700;
        font-size: 0.8rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        width: fit-content;
        justify-self: end;
        transition: all 0.2s;
    }

    .dl-btn i { color: #FFC107; font-size: 1rem; }
    .dl-btn:hover { background: #FFF9C4; }

    /* ── Mobile Responsive ── */
    @media (max-width: 768px) {
        /* Search box compact */
        .search-container {
            padding: 5px;
            border-radius: 12px;
        }

        .search-container i.fa-globe {
            margin-left: 0.5rem;
            font-size: 0.9rem;
        }

        .search-container input {
            padding: 0.5rem 0.4rem;
            font-size: 0.88rem;
            min-width: 0;
        }

        .search-container button {
            padding: 8px 10px;
            font-size: 0.8rem;
            border-radius: 10px;
            gap: 5px;
            white-space: nowrap;
            flex-shrink: 0;
        }

        .search-container button i {
            width: 18px;
            height: 18px;
            font-size: 0.6rem;
        }

        /* Results — stack sidebar above main content */
        .results-wrapper {
            flex-direction: column !important;
            padding: 12px;
            gap: 12px;
            background: #f9fafb;
            border-radius: 16px;
            overflow: hidden;
        }

        /* Sidebar — vertical: full image, title, duration */
        .sidebar {
            width: 100%;
            display: block;
            padding: 10px;
        }

        .thumb-box {
            width: 100%;
            height: auto;
            aspect-ratio: 16/9;
            margin-bottom: 10px;
            border-radius: 10px;
            flex-shrink: unset;
            min-width: unset;
        }

        .video-title {
            font-size: 0.9rem !important;
            margin-bottom: 8px !important;
            white-space: normal;
            display: block;
            overflow: visible;
        }

        /* Main content — full width */
        .main-content {
            width: 100%;
            padding: 0;
        }

        /* Format rows — 3 columns: badge, quality+size, download */
        .format-row {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 10px 0;
        }

        .format-row .format-badge { flex-shrink: 0; }

        .format-row .quality-text {
            flex: 1;
            font-size: 0.8rem;
            min-width: 0;
            white-space: normal;
        }

        .format-row .size-text {
            font-size: 0.75rem;
            flex-shrink: 0;
            white-space: nowrap;
        }

        .dl-btn {
            padding: 6px 10px;
            font-size: 0.75rem;
            flex-shrink: 0;
            white-space: nowrap;
        }

        .tutorial-dropdown {
            max-height: 80vh;
            overflow: auto;
            padding: 0.7rem 1rem;
        }

        .tutorial-steps {
            grid-template-columns: 1fr;
            gap: 12px;
        }

        .tutorial-step-card {
            min-height: auto;
        }

        .tutorial-thumb {
            max-width: 220px;
            height: 64px;
        }

        .tutorial-step-card h4 {
            font-size: 1rem;
        }

        .tutorial-step-card p {
            font-size: 0.85rem;
        }
    }
</style>

<section class="search-section" style="padding: 3rem 0; text-align: center;">
    <div style="max-width: 900px; margin: 0 auto; padding: 0 1.5rem;">
        <h2 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 1.2rem;">Paste Your Link &amp; Download Instantly</h2>

        <div class="search-box-wrap">
            <div class="search-container" id="searchBox">
                <i class="fas fa-globe"></i>
                <input type="text" id="videoUrl" placeholder="Paste your link here" autocomplete="off" spellcheck="false">
                <button id="fetchBtn">
                    <i class="fas fa-arrow-down"></i>
                    Download
                </button>
            </div>
        </div>

        <p style="margin-top: 0.8rem; text-align: center; font-size: 0.85rem;">
            <a href="#" class="tutorial-link">
                <i class="fab fa-youtube" style="color: #FF0000;"></i>
                How to download?
                <span>Watch the tutorial</span>
            </a>
        </p>

        <div class="loader-box" id="loader" style="margin-top: 2rem;">
            <div class="spinner"></div>
            <p style="margin-top: 15px; font-weight: 600; color: #6B7280;">Connecting to platform...</p>
        </div>

        <div id="dl-error"></div>

        <div class="results-wrapper" id="results" style="margin-top: 2rem;">
            <aside class="sidebar">
                <div class="thumb-box"><img id="thumb" src="" alt="thumbnail"></div>
                <h2 class="video-title" id="title">Video Title</h2>
                <div class="duration-badge">
                    <i class="far fa-clock"></i> <span id="duration">00:00</span>
                </div>
            </aside>
            <main class="main-content" style="background: transparent;">
                <div class="section-header">
                    <i class="fas fa-film" style="color: var(--primary);"></i> Video
                </div>
                <div id="video-list"></div>
                <div class="section-header" style="margin-top: 20px;">
                    <i class="fas fa-music" style="color: var(--primary);"></i> Music
                </div>
                <div id="audio-list"></div>
            </main>
        </div>
    </div>
</section>

<div class="tutorial-dropdown" id="tutorialDropdown" aria-hidden="true">
        <div class="tutorial-steps">
            <div class="tutorial-step">
                <div class="tutorial-step-num">1</div>
                <div class="tutorial-step-card">
                    <div class="tutorial-thumb step-1" aria-hidden="true">
                        <div class="tutorial-thumb-ui"></div>
                    </div>
                    <h4>Copy the Video Link</h4>
                    <p>Find the video you want and copy its link from YouTube, TikTok, Instagram, Facebook, or any
                        supported platform.</p>
                </div>
            </div>

            <div class="tutorial-step">
                <div class="tutorial-step-num">2</div>
                <div class="tutorial-step-card">
                    <div class="tutorial-thumb step-2" aria-hidden="true">
                        <div class="tutorial-thumb-ui"></div>
                    </div>
                    <h4>Open VideoSaver.com</h4>
                    <p>Launch your browser and go to VidsSaver.com the fastest online video downloader.</p>
                </div>
            </div>

            <div class="tutorial-step">
                <div class="tutorial-step-num">3</div>
                <div class="tutorial-step-card">
                    <div class="tutorial-thumb step-3" aria-hidden="true">
                        <div class="tutorial-thumb-ui"></div>
                    </div>
                    <h4>Paste Your Link</h4>
                    <p>Paste the copied video URL into the smart search box on our homepage. Auto-detects platform.</p>
                </div>
            </div>

            <div class="tutorial-step">
                <div class="tutorial-step-num">4</div>
                <div class="tutorial-step-card">
                    <div class="tutorial-thumb step-4" aria-hidden="true">
                        <div class="tutorial-thumb-ui">
                            <div class="tutorial-thumb-row">
                                <span class="tutorial-badge">MP4</span>
                                <span class="tutorial-txt">144p</span>
                                <span class="tutorial-txt">449.1 KB</span>
                                <span class="tutorial-mini-btn">Download</span>
                            </div>
                            <div class="tutorial-thumb-row">
                                <span class="tutorial-badge">MP3</span>
                                <span class="tutorial-txt">128kbps</span>
                                <span class="tutorial-txt">13.7 MB</span>
                                <span class="tutorial-mini-btn">Download</span>
                            </div>
                        </div>
                    </div>
                    <h4>Choose Format &amp; Quality</h4>
                    <p>Select MP4 (video) or MP3 (audio), and pick quality up to 4K Ultra HD based on source
                        availability.</p>
                </div>
            </div>

            <div class="tutorial-step">
                <div class="tutorial-step-num">5</div>
                <div class="tutorial-step-card">
                    <div class="tutorial-thumb step-5" aria-hidden="true">
                        <div class="tutorial-thumb-ui">
                            <span class="tutorial-dl-btn">↓ Download</span>
                            <span class="tutorial-arrow">➜</span>
                            <span class="tutorial-folder">📁</span>
                        </div>
                    </div>
                    <h4>Download &amp; Save</h4>
                    <p>Click "Download" file starts automatically. Find it in your device's "Downloads" folder
                        instantly.</p>
                </div>
            </div>
        </div>
</div>

<script>
    (function () {
        const input   = document.getElementById('videoUrl');
        const fetchBtn = document.getElementById('fetchBtn');
        const loader  = document.getElementById('loader');
        const resultsBox = document.getElementById('results');
        const errorDiv = document.getElementById('dl-error');
        const csrf    = document.querySelector('meta[name="csrf-token"]')?.content;
        const tutorialLink = document.querySelector('.tutorial-link');
        const tutorialDropdown = document.getElementById('tutorialDropdown');

        let originalUrl = '';

        function openTutorialDropdown() {
            tutorialDropdown.classList.add('open');
            tutorialDropdown.setAttribute('aria-hidden', 'false');
        }

        function closeTutorialDropdown() {
            tutorialDropdown.classList.remove('open');
            tutorialDropdown.setAttribute('aria-hidden', 'true');
        }

        async function fetchVideo(url) {
            if (!url) return;
            originalUrl = url;
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
                renderResults(data);
            } catch (e) {
                errorDiv.textContent = e.message;
                errorDiv.style.display = 'block';
            } finally {
                loader.style.display = 'none';
            }
        }

        function renderResults(data) {
            const thumbEl = document.getElementById('thumb');
            const thumbBox = thumbEl.parentElement;

            // Reset thumb box
            thumbBox.innerHTML = `<img id="thumb" src="" alt="thumbnail" style="width:100%;height:100%;object-fit:cover;">`;
            thumbBox.classList.remove('playing');

            document.getElementById('thumb').src = `/thumbnail-proxy?url=${encodeURIComponent(data.thumbnail)}`;
            document.getElementById('title').textContent = data.title;
            document.getElementById('duration').textContent = data.duration || '00:00';

            // Click to play inline
            thumbBox.onclick = () => {
                thumbBox.classList.add('playing');
                const ytMatch = originalUrl.match(/(?:v=|youtu\.be\/)([\w-]{11})/);
                if (ytMatch) {
                    thumbBox.innerHTML = `<iframe src="https://www.youtube.com/embed/${ytMatch[1]}?autoplay=1" allow="autoplay; encrypted-media" allowfullscreen></iframe>`;
                } else {
                    // Use first video stream URL for non-YouTube
                    const firstVid = (data.medias || []).find(m => m.type === 'video');
                    if (firstVid) {
                        thumbBox.innerHTML = `<video src="${firstVid.url}" controls autoplay style="width:100%;height:100%;object-fit:contain;background:#000;"></video>`;
                    }
                }
            };

            const videoMedias = (data.medias || []).filter(m => m.type === 'video');
            const audioMedias = (data.medias || []).filter(m => m.type === 'audio');

            function renderRow(m) {
                const dlUrl = `/proxy-download?url=${encodeURIComponent(m.url)}&title=${encodeURIComponent(data.title)}&ext=${m.extension}`;
                const row = document.createElement('div');
                row.className = 'format-row';
                row.innerHTML = `
                    <span class="format-badge">${m.extension.toUpperCase()}</span>
                    <span class="quality-text">${m.quality}</span>
                    <span class="size-text">${m.size || ''}</span>
                    <a href="${dlUrl}" class="dl-btn"><i class="fas fa-download"></i> Download</a>
                `;
                return row;
            }

            const videoList = document.getElementById('video-list');
            const audioList = document.getElementById('audio-list');
            videoList.innerHTML = '';
            audioList.innerHTML = '';

            if (videoMedias.length) videoMedias.forEach(m => videoList.appendChild(renderRow(m)));
            else videoList.innerHTML = '<p style="color:#6B7280;font-size:0.9rem;padding:10px 0">No video formats available.</p>';

            if (audioMedias.length) audioMedias.forEach(m => audioList.appendChild(renderRow(m)));
            else audioList.innerHTML = '<p style="color:#6B7280;font-size:0.9rem;padding:10px 0">No audio formats available.</p>';

            resultsBox.style.display = 'flex';
        }

        fetchBtn.addEventListener('click', () => fetchVideo(input.value.trim()));
        input.addEventListener('keydown', e => { if (e.key === 'Enter') fetchVideo(input.value.trim()); });

        if (tutorialLink && tutorialDropdown) {
            tutorialLink.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();
                if (tutorialDropdown.classList.contains('open')) {
                    closeTutorialDropdown();
                } else {
                    openTutorialDropdown();
                }
            });

            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape' && tutorialDropdown.classList.contains('open')) {
                    closeTutorialDropdown();
                }
            });

            document.addEventListener('click', (e) => {
                if (!tutorialDropdown.classList.contains('open')) return;
                if (!tutorialDropdown.contains(e.target) && !tutorialLink.contains(e.target)) {
                    closeTutorialDropdown();
                }
            });
        }
    })();
</script>