<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page — Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        *{margin:0;padding:0;box-sizing:border-box;}
        body{font-family:'Inter',sans-serif;background:#0F1117;color:#E2E8F0;display:flex;min-height:100vh;}
        .sidebar{width:260px;background:#161B27;border-right:1px solid rgba(255,255,255,0.06);display:flex;flex-direction:column;flex-shrink:0;position:fixed;height:100vh;z-index:100;}
        .sidebar-logo{padding:1.8rem 1.5rem;border-bottom:1px solid rgba(255,255,255,0.06);}
        .logo-wrap{display:flex;align-items:center;gap:0.8rem;}
        .logo-icon{width:42px;height:42px;background:linear-gradient(135deg,#FFB800,#FF8C00);border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:1.1rem;color:#fff;box-shadow:0 6px 20px rgba(255,184,0,0.35);}
        .logo-wrap h2{font-size:1.05rem;font-weight:700;color:#fff;}
        .logo-sub{font-size:0.72rem;color:rgba(255,255,255,0.35);}
        .sidebar-nav{padding:1.2rem 0.8rem;flex:1;overflow-y:auto;}
        .nav-label{font-size:0.65rem;font-weight:600;color:rgba(255,255,255,0.25);text-transform:uppercase;letter-spacing:0.1em;padding:0.5rem 0.7rem;margin-top:0.5rem;}
        .nav-item{display:flex;align-items:center;gap:0.8rem;padding:0.7rem 0.9rem;border-radius:10px;color:rgba(255,255,255,0.5);font-size:0.88rem;font-weight:500;transition:all 0.2s;text-decoration:none;margin-bottom:2px;}
        .nav-item:hover{background:rgba(255,255,255,0.06);color:#fff;}
        .nav-item.active{background:linear-gradient(135deg,rgba(255,184,0,0.15),rgba(255,140,0,0.1));color:#FFB800;border:1px solid rgba(255,184,0,0.15);}
        .nav-item i{width:18px;text-align:center;font-size:0.9rem;}
        .sidebar-footer{padding:1rem 1.2rem;border-top:1px solid rgba(255,255,255,0.06);}
        .admin-badge{display:flex;align-items:center;gap:0.8rem;}
        .admin-avatar{width:36px;height:36px;background:linear-gradient(135deg,#FFB800,#FF8C00);border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:0.85rem;color:#fff;font-weight:700;}
        .admin-info p{font-size:0.82rem;font-weight:600;color:#fff;}
        .admin-info span{font-size:0.72rem;color:rgba(255,255,255,0.3);}
        .logout-btn{margin-left:auto;background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.2);color:#FCA5A5;padding:0.35rem 0.7rem;border-radius:8px;font-size:0.75rem;text-decoration:none;transition:all 0.2s;}
        .logout-btn:hover{background:rgba(239,68,68,0.2);}

        .main{margin-left:260px;flex:1;display:flex;flex-direction:column;}
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
        .form-row{display:grid;grid-template-columns:1fr 1fr;gap:1.2rem;margin-bottom:1.2rem;}
        .form-row.full{grid-template-columns:1fr;margin-bottom:1.2rem;}
        .form-group label{display:block;font-size:0.75rem;font-weight:600;color:rgba(255,255,255,0.45);text-transform:uppercase;letter-spacing:0.06em;margin-bottom:0.5rem;}
        .form-group input{width:100%;background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.08);border-radius:10px;padding:0.8rem 1rem;font-size:0.88rem;color:#fff;font-family:'Inter',sans-serif;outline:none;transition:border 0.2s,background 0.2s;}
        .form-group input:focus{border-color:#FFB800;background:rgba(255,184,0,0.06);}
        .hint{font-size:0.72rem;color:rgba(255,255,255,0.25);margin-top:0.4rem;}

        /* CKEditor wrapper */
        .ck-wrap{border-radius:10px;overflow:hidden;border:1px solid rgba(255,255,255,0.08);}
        .ck-wrap:focus-within{border-color:#FFB800;}

        .alert-success{background:rgba(34,197,94,0.12);border:1px solid rgba(34,197,94,0.25);color:#4ADE80;padding:0.8rem 1.2rem;border-radius:10px;margin-bottom:1.5rem;display:flex;align-items:center;gap:0.6rem;font-size:0.85rem;}

        .preview-section{background:#161B27;border:1px solid rgba(255,255,255,0.07);border-radius:16px;padding:1.8rem;margin-bottom:1.5rem;}
        .preview-label{font-size:0.7rem;font-weight:600;color:rgba(255,255,255,0.3);text-transform:uppercase;letter-spacing:0.1em;margin-bottom:1rem;}
        .preview-mockup{background:linear-gradient(135deg,#1a1a2e,#16213e);border-radius:12px;padding:2rem 1.5rem;text-align:center;}
        .preview-h1{font-size:1.3rem;font-weight:800;color:#fff;margin-bottom:1rem;line-height:1.3;}
        .preview-btn-el{display:inline-block;background:linear-gradient(135deg,#FFB800,#FF8C00);color:#fff;padding:0.6rem 1.5rem;border-radius:25px;font-size:0.85rem;font-weight:700;text-decoration:none;}

        .btn-row{display:flex;align-items:center;gap:1rem;}
        .btn-save{background:linear-gradient(135deg,#FFB800,#FF8C00);color:#fff;border:none;border-radius:12px;padding:0.85rem 2.5rem;font-size:0.95rem;font-weight:700;font-family:'Inter',sans-serif;cursor:pointer;box-shadow:0 8px 25px rgba(255,184,0,0.3);transition:transform 0.2s,box-shadow 0.2s;}
        .btn-save:hover{transform:translateY(-2px);box-shadow:0 12px 30px rgba(255,184,0,0.45);}
        .btn-preview{background:rgba(255,255,255,0.06);color:rgba(255,255,255,0.7);border:1px solid rgba(255,255,255,0.1);border-radius:12px;padding:0.85rem 1.5rem;font-size:0.88rem;font-weight:600;font-family:'Inter',sans-serif;cursor:pointer;text-decoration:none;display:inline-flex;align-items:center;gap:0.4rem;transition:all 0.2s;}
        .btn-preview:hover{background:rgba(255,255,255,0.1);color:#fff;}
    </style>
</head>
<body>

<aside class="sidebar">
    <div class="sidebar-logo">
        <div class="logo-wrap">
            <div class="logo-icon"><i class="fas fa-download"></i></div>
            <div>
                <h2>Video Saver</h2>
                <p class="logo-sub">Admin Dashboard</p>
            </div>
        </div>
    </div>
    <nav class="sidebar-nav">
        <div class="nav-label">Main</div>
        <a href="{{ route('admin.dashboard') }}" class="nav-item"><i class="fas fa-th-large"></i> Dashboard</a>
        <a href="{{ route('admin.homepage') }}" class="nav-item active"><i class="fas fa-home"></i> Home Page</a>
        <a href="#" class="nav-item"><i class="fas fa-download"></i> Downloads</a>
        <a href="#" class="nav-item"><i class="fas fa-chart-bar"></i> Analytics</a>
        <div class="nav-label">Platforms</div>
        <a href="#" class="nav-item"><i class="fab fa-youtube"></i> YouTube</a>
        <a href="#" class="nav-item"><i class="fab fa-instagram"></i> Instagram</a>
        <a href="#" class="nav-item"><i class="fab fa-tiktok"></i> TikTok</a>
        <a href="#" class="nav-item"><i class="fab fa-facebook"></i> Facebook</a>
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
            <h1><i class="fas fa-home" style="color:#FFB800;margin-right:0.5rem;"></i> Home Page Settings</h1>
            <div class="breadcrumb"><a href="{{ route('admin.dashboard') }}">Dashboard</a> / Home Page</div>
        </div>
        <a href="/" target="_blank" class="btn-preview"><i class="fas fa-external-link-alt"></i> View Site</a>
    </div>

    <div class="content">

        @if(session('success'))
        <div class="alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('admin.homepage.save') }}">
            @csrf

            <div class="form-card">
                <div class="form-card-header">
                    <div class="hicon"><i class="fas fa-heading"></i></div>
                    <div>
                        <h3>Hero Section</h3>
                        <p>Edit homepage headline, button, and description</p>
                    </div>
                </div>

                <div class="form-row full">
                    <div class="form-group">
                        <label><i class="fas fa-heading"></i> Hero Heading (H1)</label>
                        <input type="text" name="hero_heading" id="heroHeading"
                            value="{{ $settings->hero_heading ?? 'HD Video & Music Downloader for Seamless Downloads' }}"
                            placeholder="Enter main heading...">
                        <p class="hint">Main H1 title shown at the top of homepage.</p>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label><i class="fas fa-mouse-pointer"></i> Button Text</label>
                        <input type="text" name="hero_button_text" id="heroBtnText"
                            value="{{ $settings->hero_button_text ?? 'Download Video Saver' }}"
                            placeholder="e.g. Download Now">
                    </div>
                    <div class="form-group">
                        <label><i class="fas fa-link"></i> Button URL</label>
                        <input type="text" name="hero_button_url"
                            value="{{ $settings->hero_button_url ?? '#' }}"
                            placeholder="https://play.google.com/... or #">
                        <p class="hint">Paste full URL or use # for anchor.</p>
                    </div>
                </div>

                <div class="form-row full">
                    <div class="form-group">
                        <label><i class="fas fa-align-left"></i> Description</label>
                        <div class="ck-wrap">
                            <textarea name="hero_description" id="ckeditor-desc">{{ $settings->hero_description ?? '' }}</textarea>
                        </div>
                        <p class="hint">Full-featured rich text editor — bold, italic, lists, links, tables, images & more.</p>
                    </div>
                </div>
            </div>

            <!-- SUPPORTED SITES SECTION -->
            <div class="form-card">
                <div class="form-card-header">
                    <div class="hicon"><i class="fas fa-globe"></i></div>
                    <div>
                        <h3>Supported Sites Section</h3>
                        <p>Platform icons grid shown below SEO content on homepage</p>
                    </div>
                </div>

                <div class="form-row full">
                    <div class="form-group">
                        <label><i class="fas fa-heading"></i> Section Heading</label>
                        <input type="text" name="sites_heading"
                            value="{{ $settings->sites_heading ?? 'Download Videos from More Supported Sites' }}"
                            placeholder="e.g. Download Videos from More Supported Sites">
                    </div>
                </div>

                <div class="form-row full">
                    <div class="form-group">
                        <label><i class="fas fa-align-left"></i> Section Description</label>
                        <textarea name="sites_description" style="background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.08);border-radius:10px;padding:0.8rem 1rem;font-size:0.88rem;color:#fff;font-family:'Inter',sans-serif;width:100%;min-height:80px;outline:none;" placeholder="Short description below heading...">{{ $settings->sites_description ?? '' }}</textarea>
                    </div>
                </div>

                <div class="form-row full">
                    <div class="form-group">
                        <label><i class="fas fa-th"></i> Platforms</label>

                        <!-- Hidden JSON field -->
                        <input type="hidden" name="platforms_data" id="platformsJson">

                        <!-- Repeater -->
                        <div id="platformRepeater" style="display:flex;flex-direction:column;gap:0.8rem;"></div>

                        <!-- Add Button -->
                        <button type="button" onclick="addPlatform()"
                            style="margin-top:0.8rem;background:rgba(255,184,0,0.1);border:1px dashed rgba(255,184,0,0.4);color:#FFB800;padding:0.6rem 1.2rem;border-radius:10px;font-size:0.82rem;font-weight:600;cursor:pointer;font-family:'Inter',sans-serif;width:100%;">
                            <i class="fas fa-plus"></i> Add Platform
                        </button>
                        <p class="hint" style="margin-top:0.5rem;">Add each platform with its image URL, display name, and link.</p>
                    </div>
                </div>

            </div>

            <!-- LIVE PREVIEW -->
            <div class="preview-section">
                <div class="preview-label"><i class="fas fa-eye"></i> Live Preview</div>
                <div class="preview-mockup">
                    <div class="preview-h1" id="previewH1">{{ $settings->hero_heading ?? 'HD Video & Music Downloader' }}</div>
                    <a class="preview-btn-el" href="#">{{ $settings->hero_button_text ?? 'Download Video Saver' }}</a>
                </div>
            </div>

            <div class="btn-row">
                <button type="submit" class="btn-save" onclick="buildPlatformsJson()"><i class="fas fa-save"></i> Save Changes</button>
                <a href="/" target="_blank" class="btn-preview"><i class="fas fa-external-link-alt"></i> Preview Live</a>
            </div>
        </form>
    </div>
</div>

<!-- CKEditor 4 CDN -->
<script src="https://cdn.ckeditor.com/4.22.1/full/ckeditor.js"></script>
<script>
    CKEDITOR.replace('ckeditor-desc', {
        height: 280,
        toolbar: [
            { name: 'basicstyles', items: ['Bold','Italic','Underline','Strike','RemoveFormat'] },
            { name: 'paragraph', items: ['NumberedList','BulletedList','-','Blockquote'] },
            { name: 'links', items: ['Link','Unlink'] },
            { name: 'insert', items: ['Table','HorizontalRule'] },
            { name: 'styles', items: ['Format','FontSize'] },
            { name: 'colors', items: ['TextColor','BGColor'] },
            { name: 'tools', items: ['Maximize'] },
            { name: 'document', items: ['Source'] },
        ],
    });

    // Live preview
    document.getElementById('heroHeading').addEventListener('input', function() {
        document.getElementById('previewH1').textContent = this.value;
    });
    document.getElementById('heroBtnText').addEventListener('input', function() {
        document.querySelector('.preview-btn-el').textContent = this.value;
    });

    // ── Platform Repeater ────────────────────────────────
    const existingPlatforms = @json(json_decode($settings->platforms_data ?? '[]', true) ?: []);

    function addPlatform(data = {}) {
        const wrap = document.getElementById('platformRepeater');
        const row = document.createElement('div');
        row.className = 'platform-row';
        row.style.cssText = 'display:grid;grid-template-columns:70px 1fr 1fr 110px 36px;gap:0.6rem;align-items:center;background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.07);border-radius:10px;padding:0.7rem;';
        row.innerHTML = `
            <div style="text-align:center;">
                <div id="iconPrev_${Date.now()}" style="width:42px;height:42px;border-radius:50%;background:${data.color||'#333'};display:flex;align-items:center;justify-content:center;margin:0 auto 4px;">
                    <i class="${data.icon||'fas fa-globe'}" style="font-size:1.1rem;color:#fff;"></i>
                </div>
                <input type="text" placeholder="Image URL (optional)" value="${data.img||''}"
                    style="width:100%;background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.08);border-radius:6px;padding:0.25rem 0.35rem;font-size:0.65rem;color:#fff;outline:none;"
                    class="p-img">
            </div>
            <input type="text" placeholder="Name (e.g. YouTube)" value="${data.name||''}"
                style="background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.08);border-radius:8px;padding:0.6rem 0.8rem;font-size:0.83rem;color:#fff;outline:none;font-family:'Inter',sans-serif;"
                class="p-name">
            <input type="text" placeholder="Link URL" value="${data.url||''}"
                style="background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.08);border-radius:8px;padding:0.6rem 0.8rem;font-size:0.83rem;color:#fff;outline:none;font-family:'Inter',sans-serif;"
                class="p-url">
            <div style="display:flex;gap:4px;">
                <input type="text" placeholder="fab fa-youtube" value="${data.icon||''}"
                    style="flex:1;background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.08);border-radius:6px;padding:0.4rem 0.5rem;font-size:0.68rem;color:#FFB800;outline:none;font-family:monospace;"
                    class="p-icon">
                <input type="color" value="${data.color||'#333333'}"
                    style="width:32px;height:32px;border:none;border-radius:6px;cursor:pointer;padding:2px;background:transparent;"
                    class="p-color">
            </div>
            <button type="button" onclick="this.closest('.platform-row').remove()"
                style="background:rgba(239,68,68,0.12);border:1px solid rgba(239,68,68,0.2);color:#FCA5A5;width:36px;height:36px;border-radius:8px;cursor:pointer;font-size:0.85rem;">
                <i class="fas fa-trash"></i>
            </button>`;
        wrap.appendChild(row);
    }

    function buildPlatformsJson() {
        const rows = document.querySelectorAll('.platform-row');
        const data = [];
        rows.forEach(row => {
            const img   = row.querySelector('.p-img').value.trim();
            const name  = row.querySelector('.p-name').value.trim();
            const url   = row.querySelector('.p-url').value.trim();
            const icon  = row.querySelector('.p-icon').value.trim();
            const color = row.querySelector('.p-color').value.trim();
            if (name) data.push({ img, name, url, icon, color });
        });
        document.getElementById('platformsJson').value = JSON.stringify(data);
    }

    // Load existing platforms on page load
    existingPlatforms.forEach(p => addPlatform(p));
</script>
</body>
</html>
