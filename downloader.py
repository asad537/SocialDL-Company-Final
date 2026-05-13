import sys
import json
import yt_dlp

def get_video_info(url):
    """
    Speed-optimized yt-dlp extraction.
    
    KEY OPTIMIZATIONS:
    - skip 'dash' + 'hls' manifests on YouTube → avoids fetching 30+ format entries
    - socket_timeout: 8s → no hanging on slow platforms
    - noplaylist: True → don't scan whole playlist
    - skip subtitles, thumbnails write, comments
    Result: ~1-3 sec instead of 8-15 sec
    """
    ydl_opts = {
        'quiet':             True,
        'no_warnings':       True,
        'nocheckcertificate': True,
        'ignoreerrors':      True,
        'noplaylist':        True,        # Never scan full playlists
        'socket_timeout':    8,           # Don't hang more than 8s
        'skip_download':     True,
        'writesubtitles':    False,
        'writeautomaticsub': False,
        'writethumbnail':    False,
        'geo_bypass':        True,
        'user_agent': (
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64) '
            'AppleWebKit/537.36 (KHTML, like Gecko) '
            'Chrome/124.0.0.0 Safari/537.36'
        ),
        # ── BIGGEST SPEEDUP: skip DASH/HLS manifest on YouTube ──────────────
        # This skips fetching 30+ split format entries and saves 4-6 seconds.
        # Tradeoff: no 1080p+ (those need DASH merging anyway).
        'extractor_args': {
            'youtube': {
                'skip': ['dash', 'hls'],
            },
        },
        # ── COMPATIBILITY: Force H.264 to ensure Mac/iPhone playback ────────
        'format_sort': ['vcodec:h264', 'res', 'acodec:m4a'],
    }

    try:
        with yt_dlp.YoutubeDL(ydl_opts) as ydl:
            info = ydl.extract_info(url, download=False)

            if not info:
                return {'error': 'Could not extract info from this URL.'}

            # Playlist/profile → take first entry
            if 'entries' in info and info['entries']:
                info = info['entries'][0]
                if not info:
                    return {'error': 'No media found in this link.'}

            formats = info.get('formats', [])

            # ── Best thumbnail ───────────────────────────────────────────────
            thumbnails = info.get('thumbnails', [])
            best_thumb = info.get('thumbnail', '')
            if thumbnails:
                # Prefer highest resolution thumbnail
                sorted_thumbs = sorted(
                    [t for t in thumbnails if t.get('url')],
                    key=lambda t: (t.get('width') or 0) * (t.get('height') or 0),
                    reverse=True
                )
                best_thumb = sorted_thumbs[0]['url'] if sorted_thumbs else best_thumb

            # ── Duration ────────────────────────────────────────────────────
            duration_str = ''
            duration = info.get('duration')
            if duration:
                mins, secs = divmod(int(duration), 60)
                hours, mins = divmod(mins, 60)
                duration_str = (
                    f"{hours:02}:{mins:02}:{secs:02}" if hours
                    else f"{mins:02}:{secs:02}"
                )

            result = {
                'title':          info.get('title') or info.get('description', 'Video')[:60],
                'thumbnail':      best_thumb,
                'source':         info.get('extractor_key') or 'Social Media',
                'duration':       duration_str,
                'best_audio_url': '',
                'medias':         [],
            }

            processed = set()

            # ── Best audio stream ────────────────────────────────────────────
            audio_formats = [
                f for f in formats
                if f.get('vcodec') == 'none' and f.get('acodec') not in (None, 'none')
            ]
            if audio_formats:
                best_audio = max(audio_formats, key=lambda f: f.get('abr') or 0)
                result['best_audio_url'] = best_audio.get('url', '')

            # ── 1. Root URL (TikTok, Snapchat, FB direct) ───────────────────
            root_url = info.get('url')
            if root_url and root_url.startswith('http'):
                result['medias'].append({
                    'url':       root_url,
                    'quality':   'Best Quality',
                    'extension': (info.get('ext') or 'mp4').upper(),
                    'size':      '',
                    'raw_size':  0,
                    'type':      'video',
                    'has_audio': True,
                })
                processed.add('best_root')

            # ── 2. Format list ───────────────────────────────────────────────
            for f in formats:
                vcodec  = f.get('vcodec')
                acodec  = f.get('acodec')
                f_url   = f.get('url', '')
                ext     = (f.get('ext') or 'mp4')

                if not f_url or not f_url.startswith('http'):
                    continue

                # File size string
                filesize = f.get('filesize') or f.get('filesize_approx')
                size_str = ''
                sz = 0
                if filesize:
                    sz = float(filesize)
                    for unit in ['B', 'KB', 'MB', 'GB']:
                        if sz < 1024.0:
                            size_str = f"{sz:.1f} {unit}"
                            break
                        sz /= 1024.0

                is_video = vcodec not in (None, 'none')
                is_audio = acodec not in (None, 'none')

                if is_video:
                    quality = (
                        f.get('format_note')
                        or f.get('resolution')
                        or f.get('format_id')
                        or 'HD'
                    )
                    
                    # Skip 'storyboard' or 'm3u8'/'dash' manifests as they aren't direct video files
                    if 'storyboard' in quality.lower() or ext.lower() in ['m3u8', 'mpd']:
                        continue

                    # Fallback to direct MP4 download if missing format_note
                    if quality == 'HD' and 'mp4' in ext.lower():
                        quality = 'MP4 Video'

                    # Deduplicate by quality and approximate size
                    approx_size = round(sz) if size_str and sz else 0
                    key = f"v-{quality}-{is_audio}-{approx_size}"
                    if key not in processed:
                        result['medias'].append({
                            'url':       f_url,
                            'quality':   quality,
                            'extension': ext.upper(),
                            'size':      size_str,
                            'raw_size':  float(filesize) if filesize else 0,
                            'type':      'video',
                            'has_audio': is_audio,
                        })
                        processed.add(key)

                elif is_audio:
                    abr = int(f.get('abr') or 128)
                    key = f"a-{abr}"
                    if key not in processed:
                        result['medias'].append({
                            'url':       f_url,
                            'quality':   f"{abr}kbps",
                            'extension': ext.upper(),
                            'size':      size_str,
                            'raw_size':  float(filesize) if filesize else 0,
                            'type':      'audio',
                            'has_audio': True,
                        })
                        processed.add(key)

            # ── Sort: Video+Audio → Video Only → Audio ─────────────
            def sort_key(m):
                if m['type'] == 'video':
                    type_score = 2 if m.get('has_audio') else 1
                else:
                    type_score = 0
                return (type_score, m.get('raw_size') or 0)

            result['medias'].sort(key=sort_key, reverse=True)

            # For non-YouTube platforms, users usually just want the single best video.
            # Hide the clutter of raw DASH chunks.
            if 'youtube.com' not in url and 'youtu.be' not in url:
                best_video = next((m for m in result['medias'] if m['type'] == 'video'), None)
                best_audio = next((m for m in result['medias'] if m['type'] == 'audio'), None)
                filtered = []
                if best_video:
                    # Give it a clean name
                    best_video['quality'] = 'Best Quality'
                    filtered.append(best_video)
                if best_audio:
                    filtered.append(best_audio)
                result['medias'] = filtered

            if not result['medias']:
                return {'error': 'No downloadable formats found for this URL.'}

            return result

    except Exception as e:
        return {'error': str(e)}


if __name__ == '__main__':
    if len(sys.argv) < 2:
        print(json.dumps({'error': 'No URL provided'}))
        sys.exit(1)

    result = get_video_info(sys.argv[1])
    print(json.dumps(result, ensure_ascii=False))
