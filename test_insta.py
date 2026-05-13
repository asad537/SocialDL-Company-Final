import yt_dlp
import json

ydl_opts = {'quiet': True, 'nocheckcertificate': True}
with yt_dlp.YoutubeDL(ydl_opts) as ydl:
    info = ydl.extract_info("https://www.instagram.com/p/C6rI-KDoA_Z/", download=False)
    
    print("Has root URL:", bool(info.get('url')))
    print("Formats:")
    for f in info.get('formats', []):
        print(f.get('format_id'), f.get('vcodec'), f.get('acodec'), f.get('filesize'), f.get('ext'), f.get('url')[:30])
