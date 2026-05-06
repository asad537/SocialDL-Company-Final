    <!-- CSRF & Editor.js Upload URL -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="editorjs-upload-url" content="{{ route('admin.cms.upload-editor-image') }}">

    <!-- Editor.js Core -->
    <script src="https://cdn.jsdelivr.net/npm/@editorjs/editorjs@latest"></script>
    <!-- Editor.js Tools -->
    <script src="https://cdn.jsdelivr.net/npm/@editorjs/header@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/@editorjs/paragraph@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/@editorjs/nested-list@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/@editorjs/checklist@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/@editorjs/quote@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/@editorjs/code@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/@editorjs/delimiter@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/@editorjs/table@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/@editorjs/image@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/@editorjs/embed@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/@editorjs/link@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/@editorjs/marker@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/@editorjs/inline-code@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/@editorjs/underline@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/@editorjs/raw@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/@editorjs/warning@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/@editorjs/attaches@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/editorjs-drag-drop@latest"></script>
    
    <!-- Custom Editor.js Manager -->
    <script src="{{ asset('assets/js/editorjs-manager.js') }}"></script>

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
        .form-row{display:grid;grid-template-columns:1fr 1fr;gap:1.2rem;margin-bottom:1.2rem;}
        .form-row.full{grid-template-columns:1fr;margin-bottom:1.2rem;}
        .form-group label{display:block;font-size:0.75rem;font-weight:600;color:rgba(255,255,255,0.45);text-transform:uppercase;letter-spacing:0.06em;margin-bottom:0.5rem;}
        .form-group input{width:100%;background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.08);border-radius:10px;padding:0.8rem 1rem;font-size:0.88rem;color:#fff;font-family:'Inter',sans-serif;outline:none;transition:border 0.2s,background 0.2s;}
        .form-group input:focus{border-color:#FFB800;background:rgba(255,184,0,0.06);}
        .hint{font-size:0.72rem;color:rgba(255,255,255,0.25);margin-top:0.4rem;}

        /* Editor.js Paper Mode Styling */
        #hero_description_editor {
            background: #ffffff;
            border: 1px solid #E2E8F0;
            border-radius: 12px;
            padding: 3rem 2rem;
            min-height: 400px;
            color: #1E293B; /* Dark text for clarity */
            box-shadow: inset 0 2px 4px rgba(0,0,0,0.02);
        }
        
        /* Heading distinction in editor */
        .ce-header {
            color: #0F172A;
            font-weight: 800 !important;
            margin-bottom: 0.8em;
        }
        .ce-paragraph {
            color: #334155;
            line-height: 1.8;
            font-size: 1rem;
        }

        .ce-block__content, .ce-toolbar__content {
            max-width: 800px;
        }
        
        /* Toolbar adjustments for white background */
        .ce-toolbar__plus, .ce-toolbar__settings-btn {
            background-color: #F1F5F9;
            color: #475569;
        }
        .ce-toolbar__plus:hover, .ce-toolbar__settings-btn:hover {
            background-color: #E2E8F0;
        }
        
        /* Popovers should remain dark or themed */
        .ce-popover {
            background: #ffffff;
            border: 1px solid #E2E8F0;
            color: #1E293B;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }
        .ce-popover__item-icon {
            background: #F1F5F9;
            color: #475569;
        }
        .ce-popover__item-label {
            color: #1E293B;
        }
        .ce-popover__item:hover {
            background: #F8FAFC;
        }
        /* Fix for ALL EditorJS inputs/popups on white background */
        .ce-code__textarea, .ce-input, .cdx-input, .ce-link-autocomplete__input, 
        .ce-inline-tool-input, .ce-inline-toolbar input, .ce-toolbar input {
            color: #1E293B !important;
            background: #ffffff !important;
            border: 1px solid #CBD5E1 !important;
        }
        
        .ce-inline-tool-input {
            color: #1E293B !important;
        }

        /* Two Column Block Styling */
        .cdx-two-column {
            display: flex;
            gap: 20px;
            margin: 10px 0;
            background: #F8FAFC;
            padding: 20px;
            border-radius: 12px;
            border: 1px solid #E2E8F0;
        }
        .cdx-two-column--reverse {
            flex-direction: row-reverse;
        }
        .cdx-two-column__text {
            flex: 1;
            min-height: 100px;
            outline: none;
            color: #1E293B;
        }
        .cdx-two-column__image {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .cdx-two-column__image-wrapper {
            width: 100%;
            height: 200px;
            border: 2px dashed #CBD5E1;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            background: #fff;
        }
        .cdx-two-column__image-wrapper--filled {
            border: none;
        }
        .cdx-two-column__preview {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }
        .cdx-two-column__upload-btn {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
            color: rgba(255,255,255,0.4);
        }
        .cdx-two-column__remove-btn {
            position: absolute;
            top: 5px;
            right: 5px;
            background: rgba(239,68,68,0.8);
            color: white;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            cursor: pointer;
            z-index: 10;
        }

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
        <a href="{{ route('admin.faqs') }}" class="nav-item"><i class="fas fa-question-circle"></i> Home FAQs</a>
        <a href="{{ route('admin.faq_page') }}" class="nav-item"><i class="fas fa-list-ul"></i> FAQ Page</a>
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
            <h1><i class="fas fa-home" style="color:#FFB800;margin-right:0.5rem;"></i> Home Page Settings</h1>
            <div class="breadcrumb"><a href="{{ route('admin.dashboard') }}">Dashboard</a> / Home Page</div>
        </div>
        <a href="/" target="_blank" class="btn-preview"><i class="fas fa-external-link-alt"></i> View Site</a>
    </div>

    <div class="content">

        @if(session('success'))
        <div class="alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
        @endif

        <form id="homepageForm" method="POST" action="{{ route('admin.homepage.save') }}">
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
                        <label><i class="fas fa-align-left"></i> Description (Editor.js)</label>
                        <div id="hero_description_editor"></div>
                        <input type="hidden" name="hero_description" id="hero_description_input">
                        <p class="hint">Block-based editor — rich text, images, columns & more.</p>
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
                <button type="submit" class="btn-save"><i class="fas fa-save"></i> Save Changes</button>
                <a href="/" target="_blank" class="btn-preview"><i class="fas fa-external-link-alt"></i> Preview Live</a>
            </div>
        </form>

        <!-- ── FAQ Management Section ──────────────────────────── -->

        <!-- Add FAQ Form -->
        <div class="form-card">
            <div class="form-card-header">
                <div class="hicon"><i class="fas fa-question-circle"></i></div>
                <div>
                    <h3>FAQ Management</h3>
                    <p>Add or remove questions shown on homepage</p>
                </div>
            </div>

            <form method="POST" action="{{ route('admin.faqs.store') }}" style="display:grid;grid-template-columns:1fr 1fr auto;gap:0.8rem;align-items:start;">
                @csrf
                <div class="form-group">
                    <label><i class="fas fa-question"></i> Question</label>
                    <input type="text" name="question" required placeholder="e.g. How do I download videos?">
                </div>
                <div class="form-group">
                    <label><i class="fas fa-align-left"></i> Answer</label>
                    <input type="text" name="answer" required placeholder="Write the answer...">
                </div>
                <div style="padding-top:1.55rem;">
                    <button type="submit" class="btn-save" style="padding:0.78rem 1.5rem;font-size:0.88rem;">
                        <i class="fas fa-plus"></i> Add
                    </button>
                </div>
            </form>

            <!-- FAQ List -->
            @if(count($faqs) > 0)
            <div style="margin-top:1.2rem;border-top:1px solid rgba(255,255,255,0.06);padding-top:1.2rem;">
                <p style="font-size:0.72rem;font-weight:600;color:rgba(255,255,255,0.25);text-transform:uppercase;letter-spacing:0.1em;margin-bottom:0.8rem;">
                    <i class="fas fa-list"></i> Current FAQs ({{ count($faqs) }})
                </p>
                <div style="display:flex;flex-direction:column;gap:0.5rem;">
                    @foreach($faqs as $faq)
                    <div style="display:flex;align-items:center;gap:0.8rem;background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.06);border-radius:10px;padding:0.75rem 1rem;">
                        <div style="width:24px;height:24px;background:rgba(255,184,0,0.12);border-radius:6px;display:flex;align-items:center;justify-content:center;font-size:0.7rem;font-weight:700;color:#FFB800;flex-shrink:0;">{{ $loop->iteration }}</div>
                        <div style="flex:1;min-width:0;">
                            <p style="font-size:0.87rem;font-weight:600;color:#E2E8F0;margin:0 0 0.15rem;">{{ $faq->question }}</p>
                            <p style="font-size:0.77rem;color:rgba(255,255,255,0.3);margin:0;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ Str::limit($faq->answer, 100) }}</p>
                        </div>
                        <form method="POST" action="{{ route('admin.faqs.delete', $faq->id) }}" onsubmit="return confirm('Delete this FAQ?')" style="flex-shrink:0;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.2);color:#FCA5A5;padding:0.35rem 0.7rem;border-radius:8px;font-size:0.75rem;cursor:pointer;font-family:'Inter',sans-serif;">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

    </div>
</div>

<script>
    let heroEditor;

    document.addEventListener('DOMContentLoaded', async () => {
        try {
            // Prepare initial data
            let initialData = { blocks: [] };
            const rawContent = @json($settings->hero_description ?? '');
            
            if (rawContent) {
                try {
                    // Try parsing as JSON first
                    const parsed = typeof rawContent === 'string' ? JSON.parse(rawContent) : rawContent;
                    if (parsed && (parsed.blocks || Array.isArray(parsed))) {
                        initialData = parsed;
                    } else {
                        throw new Error('Not valid Editor.js JSON');
                    }
                } catch (e) {
                    // Fallback to HTML conversion if it looks like HTML
                    if (typeof rawContent === 'string' && rawContent.includes('<')) {
                        initialData = editorJSManager.fromHTML(rawContent);
                    } else if (rawContent) {
                        // Just wrap plain text in a paragraph
                        initialData = {
                            blocks: [{ type: 'paragraph', data: { text: rawContent } }]
                        };
                    }
                }
            }

            heroEditor = await editorJSManager.init('hero_description_editor', {
                placeholder: 'Enter homepage SEO description...',
                minHeight: 300,
                data: initialData
            });
            console.log('Homepage Editor.js initialized');
        } catch (e) {
            console.error('Editor.js initialization failed:', e);
        }
    });

    // Form submission
    document.getElementById('homepageForm').onsubmit = async function(e) {
        e.preventDefault();
        try {
            // Save Editor.js data
            if (heroEditor) {
                const contentData = await editorJSManager.save('hero_description_editor');
                document.getElementById('hero_description_input').value = JSON.stringify(contentData);
            }
            
            // Build platforms JSON
            buildPlatformsJson();
            
            // Submit form
            this.submit();
        } catch (error) {
            console.error('Saving failed: ', error);
            alert('Something went wrong while saving.');
        }
    };

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
