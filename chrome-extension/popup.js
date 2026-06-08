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

    // Attempt to autofill active tab URL
    chrome.tabs.query({ active: true, currentWindow: true }, (tabs) => {
        if (tabs[0] && tabs[0].url && tabs[0].url.startsWith('http')) {
            urlInput.value = tabs[0].url;
        }
    });

    fetchBtn.addEventListener('click', () => {
        const url = urlInput.value.trim();
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
    
    function formatDuration(seconds) {
        if (!seconds) return '0:00';
        const h = Math.floor(seconds / 3600);
        const m = Math.floor((seconds % 3600) / 60);
        const s = Math.floor(seconds % 60);
        if (h > 0) return `${h}:${m.toString().padStart(2, '0')}:${s.toString().padStart(2, '0')}`;
        return `${m}:${s.toString().padStart(2, '0')}`;
    }

    function renderResults(data, originalUrl) {
        videoThumb.src = data.thumbnail || '';
        videoTitle.textContent = data.title || 'Unknown Video';
        platformName.textContent = data.extractor || 'Video';
        videoDuration.textContent = formatDuration(data.duration);
        
        // Video processing
        const videos = (data.formats || []).filter(f => f.has_video).sort((a, b) => (b.height || 0) - (a.height || 0));
        const uniqueVideos = [];
        const seenRes = new Set();
        for (let v of videos) {
            const res = v.height ? `${v.height}P` : 'HD';
            if (!seenRes.has(res)) {
                seenRes.add(res);
                uniqueVideos.push({
                    resolution: res,
                    size: formatBytes(v.filesize || v.filesize_approx),
                    ext: (v.ext || 'MP4').toUpperCase(),
                    format_id: v.format_id
                });
            }
        }
        
        uniqueVideos.forEach(v => {
            const dlUrl = `https://hdvideosaver.com/merge-download?url=${encodeURIComponent(originalUrl)}&format_id=${v.format_id}`;
            const item = createFormatItem(v.ext, v.resolution, v.size, dlUrl);
            videoFormatsContainer.appendChild(item);
        });
        
        if (uniqueVideos.length === 0) videoFormatsContainer.innerHTML = '<p class="size">No video formats available</p>';

        // Audio processing
        const audios = (data.formats || []).filter(f => !f.has_video && f.has_audio).sort((a, b) => (b.abr || 0) - (a.abr || 0));
        const uniqueAudios = [];
        const seenAbr = new Set();
        for (let a of audios) {
            const br = a.abr ? `${Math.round(a.abr)}KBPS` : 'Audio';
            if (!seenAbr.has(br)) {
                seenAbr.add(br);
                uniqueAudios.push({
                    bitrate: br,
                    size: formatBytes(a.filesize || a.filesize_approx),
                    ext: 'MP3',
                    format_id: a.format_id
                });
            }
        }

        uniqueAudios.forEach(a => {
            const dlUrl = `https://hdvideosaver.com/merge-download?url=${encodeURIComponent(originalUrl)}&format_id=${a.format_id}`;
            const item = createFormatItem(a.ext, a.bitrate, a.size, dlUrl);
            audioFormatsContainer.appendChild(item);
        });

        if (uniqueAudios.length === 0) audioFormatsContainer.innerHTML = '<p class="size">No audio formats available</p>';

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
