<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $blog->title }} — Blog</title>
    <meta name="description" content="{{ $blog->meta_description }}">
    <meta name="keywords" content="{{ $blog->meta_keywords }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    
    <style>
        :root {
            --primary: #FFB800;
            --primary-dark: #FF8C00;
            --text-main: #1E293B;
            --text-muted: #64748B;
            --bg-light: #F8FAFC;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Inter', sans-serif;
            color: var(--text-main);
            background: #fff;
            line-height: 1.6;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 0 1.5rem;
        }

        /* Header Area */
        .post-header {
            padding: 4rem 0 3rem;
            text-align: center;
        }

        .post-category {
            display: inline-block;
            background: rgba(255, 184, 0, 0.1);
            color: var(--primary-dark);
            padding: 0.4rem 1rem;
            border-radius: 30px;
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 1.5rem;
        }

        .post-header h1 {
            font-size: 2.8rem;
            font-weight: 800;
            line-height: 1.2;
            color: #0F172A;
            margin-bottom: 1.5rem;
            letter-spacing: -0.02em;
        }

        .post-meta {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1.5rem;
            font-size: 0.9rem;
            color: var(--text-muted);
            font-weight: 500;
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .meta-item i {
            color: var(--primary);
        }

        /* Featured Image */
        .featured-image-container {
            margin-bottom: 3.5rem;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.1);
        }

        .featured-image-container img {
            width: 100%;
            height: auto;
            display: block;
        }

        /* Content Area */
        .post-content {
            font-size: 1.125rem;
            color: #334155;
            line-height: 1.8;
        }

        .post-content p {
            margin-bottom: 1.8rem;
        }

        /* Sidebar/Related Area */
        .related-section {
            background: var(--bg-light);
            padding: 5rem 0;
            margin-top: 5rem;
        }

        .related-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-bottom: 2.5rem;
        }

        .related-header h2 {
            font-size: 1.8rem;
            font-weight: 800;
            color: #0F172A;
        }

        .related-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
        }

        .related-card {
            background: #fff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease;
            text-decoration: none;
            display: flex;
            flex-direction: column;
        }

        .related-card:hover {
            transform: translateY(-8px);
        }

        .card-img {
            width: 100%;
            aspect-ratio: 16/9;
            object-fit: cover;
        }

        .card-body {
            padding: 1.2rem;
            flex: 1;
        }

        .card-body h4 {
            font-size: 1rem;
            font-weight: 700;
            color: #0F172A;
            line-height: 1.4;
            margin-bottom: 0.5rem;
        }

        @media (max-width: 768px) {
            .post-header h1 { font-size: 2rem; }
            .related-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

    @include('partials.header')

    <article class="container">
        <header class="post-header">
            <span class="post-category">Blog Post</span>
            <h1>{{ $blog->title }}</h1>
            <div class="post-meta">
                <div class="meta-item">
                    <i class="fas fa-user-circle"></i>
                    <span>{{ $blog->author_name ?: 'Admin' }}</span>
                </div>
                <div class="meta-item">
                    <i class="fas fa-calendar-alt"></i>
                    <span>{{ $blog->created_at->format('M d, Y') }}</span>
                </div>
                <div class="meta-item">
                    <i class="fas fa-clock"></i>
                    <span>{{ $blog->reading_time ?: '5 min read' }}</span>
                </div>
            </div>
        </header>

        @if($blog->featured_image)
        <div class="featured-image-container">
            <img src="{{ $blog->featured_image }}" alt="{{ $blog->image_alt }}">
        </div>
        @endif

        <div class="post-content">
            {!! $blog->renderContent() !!}
        </div>

        @if($blog->tags)
        <div style="margin-top:3rem; padding-top:2rem; border-top:1px solid #E2E8F0; display:flex; gap:0.8rem; flex-wrap:wrap;">
            @foreach(explode(',', $blog->tags) as $tag)
                <span style="background:#F1F5F9; color:#475569; padding:0.4rem 0.8rem; border-radius:6px; font-size:0.85rem; font-weight:600;">#{{ trim($tag) }}</span>
            @endforeach
        </div>
        @endif
    </article>

    @if(isset($related) && count($related) > 0)
    <section class="related-section">
        <div class="container" style="max-width:1100px;">
            <div class="related-header">
                <h2>Keep Reading</h2>
                <a href="/blogs" style="color:var(--primary-dark); font-weight:700; text-decoration:none; font-size:0.95rem;">View all posts →</a>
            </div>
            <div class="related-grid">
                @foreach($related as $post)
                <a href="{{ route('blog.show', $post->slug) }}" class="related-card">
                    <img src="{{ $post->featured_image ?: 'https://via.placeholder.com/400x225' }}" alt="" class="card-img">
                    <div class="card-body">
                        <h4>{{ Str::limit($post->title, 60) }}</h4>
                        <div style="font-size:0.8rem; color:var(--text-muted); font-weight:500;">{{ $post->created_at->format('M d, Y') }}</div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    @include('partials.footer')

</body>
</html>
