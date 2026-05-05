<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQ Page — Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        *{margin:0;padding:0;box-sizing:border-box;}
        body{font-family:'Inter',sans-serif;background:#0F1117;color:#E2E8F0;display:flex;min-height:100vh;}
        .sidebar{width:220px;background:#161B27;border-right:1px solid rgba(255,255,255,0.06);display:flex;flex-direction:column;flex-shrink:0;position:fixed;height:100vh;z-index:100;}
        .sidebar-logo{padding:1.5rem 1.2rem;border-bottom:1px solid rgba(255,255,255,0.06);}
        .logo-wrap{display:flex;align-items:center;gap:0.6rem;}
        .logo-icon{width:38px;height:38px;background:linear-gradient(135deg,#FFB800,#FF8C00);border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:1rem;color:#fff;box-shadow:0 6px 20px rgba(255,184,0,0.35);}
        .logo-wrap h2{font-size:0.95rem;font-weight:700;color:#fff;}
        .logo-sub{font-size:0.68rem;color:rgba(255,255,255,0.35);}
        .sidebar-nav{padding:1rem 0.6rem;flex:1;overflow-y:auto;}
        .nav-label{font-size:0.6rem;font-weight:600;color:rgba(255,255,255,0.2);text-transform:uppercase;letter-spacing:0.1em;padding:0.5rem 0.7rem;margin-top:0.5rem;}
        .nav-item{display:flex;align-items:center;gap:0.7rem;padding:0.6rem 0.8rem;border-radius:8px;color:rgba(255,255,255,0.45);font-size:0.82rem;font-weight:500;transition:all 0.2s;text-decoration:none;margin-bottom:2px;}
        .nav-item:hover{background:rgba(255,255,255,0.04);color:#fff;}
        .nav-item.active{background:linear-gradient(135deg,rgba(255,184,0,0.12),rgba(255,140,0,0.08));color:#FFB800;border:1px solid rgba(255,184,0,0.1);}
        .nav-item i{width:16px;text-align:center;font-size:0.85rem;}
        .sidebar-footer{padding:0.8rem 1rem;border-top:1px solid rgba(255,255,255,0.06);}
        .admin-badge{display:flex;align-items:center;gap:0.6rem;}
        .admin-avatar{width:32px;height:32px;background:linear-gradient(135deg,#FFB800,#FF8C00);border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:0.75rem;color:#fff;font-weight:700;}
        .admin-info p{font-size:0.78rem;font-weight:600;color:#fff;}
        .admin-info span{font-size:0.68rem;color:rgba(255,255,255,0.25);}
        .logout-btn{margin-left:auto;background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.2);color:#FCA5A5;padding:0.3rem 0.6rem;border-radius:6px;font-size:0.7rem;text-decoration:none;transition:all 0.2s;}
        .logout-btn:hover{background:rgba(239,68,68,0.2);}

        .main{margin-left:220px;flex:1;display:flex;flex-direction:column;}
        .topbar{background:#161B27;border-bottom:1px solid rgba(255,255,255,0.06);padding:1rem 2rem;display:flex;align-items:center;justify-content:space-between;position:sticky;top:0;z-index:50;}
        .topbar-left h1{font-size:1.2rem;font-weight:700;color:#fff;}
        .breadcrumb{font-size:0.78rem;color:rgba(255,255,255,0.3);}
        .breadcrumb a{color:rgba(255,255,255,0.35);text-decoration:none;}
        .breadcrumb a:hover{color:#FFB800;}
        .content{padding:2rem;flex:1;}

        .form-card{background:#161B27;border:1px solid rgba(255,255,255,0.07);border-radius:16px;padding:1.8rem;margin-bottom:1.5rem;}
        .form-card-header{display:flex;align-items:center;gap:0.7rem;margin-bottom:1.5rem;padding-bottom:1rem;border-bottom:1px solid rgba(255,255,255,0.06);}
        .hicon{width:36px;height:36px;border-radius:10px;background:rgba(255,184,0,0.12);color:#FFB800;display:flex;align-items:center;justify-content:center;font-size:0.95rem;}
        .form-card-header h3{font-size:0.95rem;font-weight:700;color:#fff;}
        .form-card-header p{font-size:0.75rem;color:rgba(255,255,255,0.35);}
        .form-group label{display:block;font-size:0.75rem;font-weight:600;color:rgba(255,255,255,0.45);text-transform:uppercase;letter-spacing:0.06em;margin-bottom:0.5rem;}
        .form-group input, .form-group textarea, .form-group select{width:100%;background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.08);border-radius:10px;padding:0.8rem 1rem;font-size:0.88rem;color:#fff;font-family:'Inter',sans-serif;outline:none;transition:border 0.2s;}
        .form-group input:focus,.form-group textarea:focus,.form-group select:focus{border-color:#FFB800;background:rgba(255,184,0,0.06);}
        .form-group{margin-bottom:1.2rem;}

        .alert-success{background:rgba(34,197,94,0.12);border:1px solid rgba(34,197,94,0.25);color:#4ADE80;padding:0.8rem 1.2rem;border-radius:10px;margin-bottom:1.5rem;display:flex;align-items:center;gap:0.6rem;font-size:0.85rem;}
        .btn-save{background:linear-gradient(135deg,#FFB800,#FF8C00);color:#fff;border:none;border-radius:12px;padding:0.85rem 2.5rem;font-size:0.95rem;font-weight:700;font-family:'Inter',sans-serif;cursor:pointer;box-shadow:0 8px 25px rgba(255,184,0,0.3);transition:transform 0.2s;}
        .btn-save:hover{transform:translateY(-2px);}
        .btn-preview{background:rgba(255,255,255,0.06);color:rgba(255,255,255,0.7);border:1px solid rgba(255,255,255,0.1);border-radius:12px;padding:0.85rem 1.5rem;font-size:0.88rem;font-weight:600;font-family:'Inter',sans-serif;cursor:pointer;text-decoration:none;display:inline-flex;align-items:center;gap:0.4rem;transition:all 0.2s;}
        .btn-preview:hover{background:rgba(255,255,255,0.1);color:#fff;}

        /* FAQ list */
        .category-block{margin-bottom:2.5rem;}
        .category-title{font-size:1.1rem;font-weight:800;color:#FFB800;margin-bottom:1.2rem;display:flex;align-items:center;gap:0.8rem;}
        .category-title::after{content:'';flex:1;height:1px;background:rgba(255,255,255,0.06);}
        .faq-list{display:flex;flex-direction:column;gap:0.8rem;}
        .faq-item{background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.08);border-radius:12px;padding:1rem 1.2rem;display:flex;align-items:flex-start;gap:1rem;}
        .faq-item-body{flex:1;}
        .faq-item-body strong{font-size:0.9rem;color:#fff;display:block;margin-bottom:0.3rem;}
        .faq-item-body span{font-size:0.82rem;color:rgba(255,255,255,0.4);line-height:1.5;}
        .btn-del{background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.2);color:#FCA5A5;padding:0.4rem 0.8rem;border-radius:8px;font-size:0.78rem;cursor:pointer;font-family:'Inter',sans-serif;flex-shrink:0;transition:all 0.2s;}
        .btn-del:hover{background:rgba(239,68,68,0.2);}
    </style>
</head>
<body>

<aside class="sidebar">
    <div class="sidebar-logo">
        <div class="logo-wrap">
            <div class="logo-icon"><i class="fas fa-download"></i></div>
            <div><h2>Video Saver</h2><p class="logo-sub">Admin Dashboard</p></div>
        </div>
    </div>
    <nav class="sidebar-nav">
        <div class="nav-label">Main</div>
        <a href="{{ route('admin.dashboard') }}" class="nav-item"><i class="fas fa-th-large"></i> Dashboard</a>
        <a href="{{ route('admin.homepage') }}" class="nav-item"><i class="fas fa-home"></i> Home Page</a>
        <a href="{{ route('admin.faqs') }}" class="nav-item"><i class="fas fa-question-circle"></i> Home FAQs</a>
        <a href="{{ route('admin.faq_page') }}" class="nav-item active"><i class="fas fa-list-ul"></i> FAQ Page</a>
        <a href="{{ route('admin.blogs.index') }}" class="nav-item {{ Request::is('admin/blogs*') ? 'active' : '' }}"><i class="fas fa-blog"></i> Blogs</a>
        <a href="{{ route('admin.guides.index') }}" class="nav-item {{ Request::is('admin/guides*') ? 'active' : '' }}"><i class="fas fa-book"></i> Guides</a>
        <div class="nav-label">System</div>
        <a href="#" class="nav-item"><i class="fas fa-cog"></i> Settings</a>
    </nav>
    <div class="sidebar-footer">
        <div class="admin-badge">
            <div class="admin-avatar">A</div>
            <div class="admin-info"><p>Administrator</p><span>Super Admin</span></div>
            <a href="{{ route('admin.logout') }}" class="logout-btn"><i class="fas fa-sign-out-alt"></i></a>
        </div>
    </div>
</aside>

<div class="main">
    <div class="topbar">
        <div class="topbar-left">
            <h1><i class="fas fa-list-ul" style="color:#FFB800;margin-right:0.5rem;"></i> FAQ Page Management</h1>
            <div class="breadcrumb"><a href="{{ route('admin.dashboard') }}">Dashboard</a> / FAQ Page</div>
        </div>
        <a href="{{ route('public.faqs') }}" target="_blank" class="btn-preview"><i class="fas fa-external-link-alt"></i> View Page</a>
    </div>

    <div class="content">

        @if(session('success'))
        <div class="alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
        @endif

        <!-- FAQ Page SEO Settings -->
        <div class="form-card">
            <div class="form-card-header">
                <div class="hicon"><i class="fas fa-search"></i></div>
                <div><h3>FAQ Page SEO Settings</h3><p>Manage how this page appears in Google search results</p></div>
            </div>
            <form method="POST" action="{{ route('admin.faq_page.seo.save') }}">
                @csrf
                <div class="form-group">
                    <label><i class="fas fa-heading"></i> Meta Title</label>
                    <input type="text" name="faq_meta_title" value="{{ $settings->faq_meta_title ?? '' }}" placeholder="e.g. Frequently Asked Questions — Video Saver">
                </div>
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:1.2rem;">
                    <div class="form-group">
                        <label><i class="fas fa-file-alt"></i> Meta Description</label>
                        <textarea name="faq_meta_description" rows="3" placeholder="Brief summary for search engines...">{{ $settings->faq_meta_description ?? '' }}</textarea>
                    </div>
                    <div class="form-group">
                        <label><i class="fas fa-key"></i> Meta Keywords</label>
                        <textarea name="faq_meta_keywords" rows="3" placeholder="e.g. faq, video downloader help, how to download...">{{ $settings->faq_meta_keywords ?? '' }}</textarea>
                    </div>
                </div>
                <button type="submit" class="btn-save"><i class="fas fa-save"></i> Save SEO Settings</button>
            </form>
        </div>

        <!-- Add New FAQ -->
        <div class="form-card">
            <div class="form-card-header">
                <div class="hicon"><i class="fas fa-plus"></i></div>
                <div><h3>Add New FAQ to Page</h3><p>Select or create a category and add a question</p></div>
            </div>
            <form method="POST" action="{{ route('admin.faq_page.store') }}">
                @csrf
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:1.2rem;">
                    <div class="form-group">
                        <label><i class="fas fa-tags"></i> Category</label>
                        <input type="text" name="category" list="categories" placeholder="e.g. Getting Started" required>
                        <datalist id="categories">
                            @foreach($categories as $cat)
                                <option value="{{ $cat }}">
                            @endforeach
                        </datalist>
                    </div>
                    <div class="form-group">
                        <label><i class="fas fa-question"></i> Question</label>
                        <input type="text" name="question" placeholder="Enter question..." required>
                    </div>
                </div>
                <div class="form-group">
                    <label><i class="fas fa-align-left"></i> Answer</label>
                    <textarea name="answer" rows="3" placeholder="Write the answer here..." required style="resize:vertical;"></textarea>
                </div>
                <button type="submit" class="btn-save"><i class="fas fa-plus"></i> Add to FAQ Page</button>
            </form>
        </div>

        <!-- Existing FAQs Grouped by Category -->
        <div class="form-card">
            <div class="form-card-header">
                <div class="hicon"><i class="fas fa-list"></i></div>
                <div><h3>FAQ Page Content</h3><p>Grouped by categories as shown in Figma</p></div>
            </div>

            @php $currentCat = null; @endphp
            @forelse($faqs as $faq)
                @if($currentCat !== $faq->category)
                    @if($currentCat !== null) </div></div> @endif
                    @php $currentCat = $faq->category; @endphp
                    <div class="category-block">
                        <div class="category-title">{{ $currentCat }}</div>
                        <div class="faq-list">
                @endif
                
                <div class="faq-item">
                    <div class="faq-item-body">
                        <strong>{{ $faq->question }}</strong>
                        <span>{{ Str::limit($faq->answer, 150) }}</span>
                    </div>
                    <form method="POST" action="{{ route('admin.faq_page.delete', $faq->id) }}" onsubmit="return confirm('Delete this FAQ?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-del"><i class="fas fa-trash"></i></button>
                    </form>
                </div>

                @if($loop->last) </div></div> @endif
            @empty
                <p style="color:rgba(255,255,255,0.3);font-size:0.88rem;text-align:center;padding:2rem;">No FAQs on the dedicated page yet. Add some above!</p>
            @endforelse
        </div>

    </div>
</div>

</body>
</html>
