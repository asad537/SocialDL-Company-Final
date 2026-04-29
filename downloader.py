import sys
import json
import yt_dlp

def get_video_info(url):
    ydl_opts = {
        'quiet': True,
        'no_warnings': True,
        'nocheckcertificate': True,
        'user_agent': 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/119.0.0.0 Safari/537.36',
    }
    
    try:
        with yt_dlp.YoutubeDL(ydl_opts) as ydl:
            info = ydl.extract_info(url, download=False)
            
            formats = info.get('formats', [])
            
            # Format the response
            thumbnails = info.get('thumbnails', [])
            best_thumb = info.get('thumbnail')
            if thumbnails:
                # Pick the last one in the list (usually highest resolution)
                best_thumb = thumbnails[-1].get('url')

            results = {
                'title': info.get('title'),
                'thumbnail': best_thumb,
                'source': info.get('extractor_key'),
                'duration': '',
                'best_audio_url': '',
                'medias': []
            }

            # Find best audio URL for merging later
            best_audio = next((f for f in formats if f.get('vcodec') == 'none' and f.get('acodec') != 'none'), None)
            if best_audio:
                results['best_audio_url'] = best_audio.get('url')

            # Get duration
            duration = info.get('duration')
            if duration:
                mins, secs = divmod(duration, 60)
                hours, mins = divmod(mins, 60)
                results['duration'] = f"{int(hours):02}:{int(mins):02}:{int(secs):02}" if hours else f"{int(mins):02}:{int(secs):02}"

            processed_qualities = set()
            
            # Sort formats to put best ones first
            formats.sort(key=lambda x: (x.get('ext') == 'mp4', x.get('tbr') or 0), reverse=True)

            for f in formats:
                vcodec = f.get('vcodec')
                acodec = f.get('acodec')
                url = f.get('url')
                filesize = f.get('filesize') or f.get('filesize_approx')
                
                if not url: continue

                # Human readable size
                size_str = ""
                if filesize:
                    temp_size = float(filesize)
                    for unit in ['B', 'KB', 'MB', 'GB']:
                        if temp_size < 1024:
                            size_str = f"{temp_size:.2f} {unit}"
                            break
                        temp_size /= 1024

                # 1. Handle Video Formats
                if vcodec != 'none':
                    quality = f.get('format_note') or f.get('resolution') or 'Standard'
                    ext = f.get('ext')
                    has_audio = acodec != 'none'
                    
                    key = f"v-{quality}-{has_audio}"
                    if key not in processed_qualities:
                        results['medias'].append({
                            'url': url,
                            'quality': quality,
                            'extension': ext.upper(),
                            'size': size_str,
                            'type': 'video',
                            'has_audio': has_audio
                        })
                        processed_qualities.add(key)

                # 2. Handle Audio-only Formats
                elif acodec != 'none' and vcodec == 'none':
                    abr = f.get('abr') or 128
                    ext = f.get('ext')
                    key = f"a-{abr}"
                    if key not in processed_qualities:
                        results['medias'].append({
                            'url': url,
                            'quality': f"{int(abr)}kbps",
                            'extension': ext.upper(),
                            'size': size_str,
                            'type': 'audio',
                            'has_audio': True
                        })
                        processed_qualities.add(key)
            
            # Sort medias
            def get_sort_val(m):
                if m['type'] == 'audio': return -1
                import re
                match = re.search(r'(\d+)', str(m['quality']))
                return int(match.group(1)) if match else 0
            
            results['medias'].sort(key=get_sort_val, reverse=True)
            return results
            
    except Exception as e:
        return {'error': str(e)}

if __name__ == "__main__":
    if len(sys.argv) < 2:
        print(json.dumps({'error': 'No URL provided'}))
        sys.exit(1)
    
    url = sys.argv[1]
    result = get_video_info(url)
    print(json.dumps(result))
