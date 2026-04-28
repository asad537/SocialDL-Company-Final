import sys
import json
import yt_dlp

def get_video_info(url):
    ydl_opts = {
        'quiet': True,
        'no_warnings': True,
        'format': 'best',
    }
    
    try:
        with yt_dlp.YoutubeDL(ydl_opts) as ydl:
            info = ydl.extract_info(url, download=False)
            
            # Format the response
            results = {
                'title': info.get('title'),
                'thumbnail': info.get('thumbnail'),
                'source': info.get('extractor_key'),
                'medias': []
            }
            
            # Extract available formats
            formats = info.get('formats', [])
            for f in formats:
                # Filter for useful formats (with both audio and video, or just good video)
                if f.get('url') and (f.get('vcodec') != 'none'):
                    results['medias'].append({
                        'url': f.get('url'),
                        'quality': f.get('format_note') or f.get('resolution') or 'Standard',
                        'extension': f.get('ext'),
                        'type': 'video'
                    })
            
            # Sort by quality if possible (heuristic)
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
