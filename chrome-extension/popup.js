document.addEventListener('DOMContentLoaded', () => {
    const fetchBtn = document.getElementById('fetchBtn');
    const urlInput = document.getElementById('urlInput');
    const loader = document.getElementById('loader');
    const errorMsg = document.getElementById('errorMsg');
    const resultArea = document.getElementById('resultArea');
    
    const videoThumb = document.getElementById('videoThumb');
    const videoDuration = document.getElementById('videoDuration');
    const videoTitle = document.getElementById('videoTitle');
    const platformName = document.getElementById('platformName');
    
    const videoFormatsContainer = document.getElementById('videoFormats');
    const audioFormatsContainer = document.getElementById('audioFormats');

    function startFetch(url) {
        if (!url) return;

        // Reset UI
        loader.classList.remove('hidden');
        errorMsg.classList.add('hidden');
        resultArea.classList.add('hidden');
        videoFormatsContainer.innerHTML = '';
        audioFormatsContainer.innerHTML = '';

        chrome.runtime.sendMessage(
            { action: 'fetchVideoInfo', url: url },
            (response) => {
                loader.classList.add('hidden');
                
                if (response && response.success && response.data) {
                    const data = response.data;
                    if (data.error) {
                        showError(data.error);
                        return;
                    }
                    renderResults(data, url);
                } else {
                    showError(response?.error || 'Failed to fetch video information.');
                }
            }
        );
    }

    // Attempt to autofill active tab URL and auto-fetch
    chrome.tabs.query({ active: true, currentWindow: true }, (tabs) => {
        if (tabs[0] && tabs[0].url && tabs[0].url.startsWith('http')) {
            urlInput.value = tabs[0].url;
            startFetch(tabs[0].url);
        }
    });

    fetchBtn.addEventListener('click', () => {
        startFetch(urlInput.value.trim());
    });

    function showError(message) {
        errorMsg.textContent = message;
        errorMsg.classList.remove('hidden');
    }

    function formatBytes(bytes, decimals = 2) {
        if (!bytes || bytes === 0) return '0 KB';
        const k = 1024;
        const dm = decimals < 0 ? 0 : decimals;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
    }
    
    function renderResults(data, originalUrl) {
        videoThumb.src = data.thumbnail || '';
        videoTitle.textContent = data.title || 'Unknown Video';
        platformName.textContent = data.source || 'Video';
        videoDuration.textContent = data.duration || '00:00';
        
        const videoMedias = (data.medias || []).filter(f => f.type === 'video').sort((a, b) => (b.height || 0) - (a.height || 0));
        const audioMedias = (data.medias || []).filter(f => f.type === 'audio').sort((a, b) => (b.bitrate || 0) - (a.bitrate || 0));

        const queuePlatforms = ['TikTok', 'Snapchat', 'tiktok', 'snapchat'];
        const needsQueue = queuePlatforms.includes(data.source || '');
        const needsProxy = !['Vimeo', 'vimeo'].includes(data.source || '');

        function generateDownloadUrl(m) {
            let dlUrl = '';
            const vcodecParam = m.vcodec ? `&vcodec=${encodeURIComponent(m.vcodec)}` : '';
            const heightParam = m.height ? `&height=${m.height}` : '';
            const uaParam = m.user_agent ? `&user_agent=${encodeURIComponent(m.user_agent)}` : '';
            const refParam = m.referer ? `&referer=${encodeURIComponent(m.referer)}` : '';
            const cookieParam = m.cookies ? `&cookies=${encodeURIComponent(m.cookies)}` : '';
            const formatIdParam = m.format_id ? `&format_id=${encodeURIComponent(m.format_id)}` : '';

            if (m.type === 'video' && m.has_audio === false) {
                if (audioMedias.length > 0) {
                    const bestAudioUrl = audioMedias[0].url;
                    dlUrl = `https://hdvideosaver.com/merge-download?video_url=${encodeURIComponent(m.url)}&audio_url=${encodeURIComponent(bestAudioUrl)}&title=${encodeURIComponent(data.title)}&source_url=${encodeURIComponent(originalUrl)}${vcodecParam}${heightParam}${uaParam}${refParam}${cookieParam}${formatIdParam}`;
                } else {
                    dlUrl = `https://hdvideosaver.com/merge-download?video_url=${encodeURIComponent(m.url)}&title=${encodeURIComponent(data.title)}&source_url=${encodeURIComponent(originalUrl)}${vcodecParam}${heightParam}${uaParam}${refParam}${cookieParam}${formatIdParam}`;
                }
            } else if (needsQueue && m.type === 'video') {
                dlUrl = `https://hdvideosaver.com/merge-download?video_url=${encodeURIComponent(m.url)}&title=${encodeURIComponent(data.title)}&source_url=${encodeURIComponent(originalUrl)}${vcodecParam}${heightParam}${uaParam}${refParam}${cookieParam}${formatIdParam}`;
            } else if (m.has_audio && !needsProxy) {
                dlUrl = `https://hdvideosaver.com/direct-download?url=${encodeURIComponent(m.url)}&title=${encodeURIComponent(data.title)}&ext=${m.extension}&quality=${encodeURIComponent(m.quality)}&source_url=${encodeURIComponent(originalUrl)}`;
            } else {
                dlUrl = `https://hdvideosaver.com/proxy-download?url=${encodeURIComponent(m.url)}&title=${encodeURIComponent(data.title)}&ext=${m.extension}&source_url=${encodeURIComponent(originalUrl)}${uaParam}${refParam}${cookieParam}${formatIdParam}`;
            }
            return dlUrl;
        }

        videoMedias.forEach(v => {
            const dlUrl = generateDownloadUrl(v);
            const item = createFormatItem(v.extension || 'MP4', v.quality, v.size, dlUrl);
            videoFormatsContainer.appendChild(item);
        });
        
        if (videoMedias.length === 0) videoFormatsContainer.innerHTML = '<p class="size">No video formats available</p>';

        audioMedias.forEach(a => {
            const dlUrl = generateDownloadUrl(a);
            const item = createFormatItem(a.extension || 'MP3', a.quality, a.size, dlUrl);
            audioFormatsContainer.appendChild(item);
        });

        if (audioMedias.length === 0) audioFormatsContainer.innerHTML = '<p class="size">No audio formats available</p>';

        resultArea.classList.remove('hidden');
    }

    function createFormatItem(badgeText, mainText, sizeText, downloadUrl) {
        const div = document.createElement('div');
        div.className = 'format-item';
        div.innerHTML = `
            <div class="format-details">
                <span class="badge">${badgeText}</span>
                <span class="quality">${mainText}</span>
                <span class="size">${sizeText}</span>
            </div>
            <a href="${downloadUrl}" target="_blank" class="download-btn">
                <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                Download
            </a>
        `;
        return div;
    }
});
