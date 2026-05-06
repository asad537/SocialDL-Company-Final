<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Guide — Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    
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
        
        /* SIDEBAR */
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
        
        .grid-2{display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;}
        .form-group{margin-bottom:1.5rem;}
        .form-group label{display:block;font-size:0.75rem;font-weight:600;color:rgba(255,255,255,0.45);text-transform:uppercase;letter-spacing:0.06em;margin-bottom:0.6rem;}
        .form-group input, .form-group textarea, .form-group select{width:100%;background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.08);border-radius:10px;padding:0.8rem 1rem;font-size:0.88rem;color:#fff;font-family:'Inter',sans-serif;outline:none;transition:border 0.2s;}
        .form-group input:focus,.form-group textarea:focus,.form-group select:focus{border-color:#FFB800;background:rgba(255,184,0,0.06);}
        
        /* Editor.js Paper Mode Styling */
        #editor {
            background: #ffffff;
            border: 1px solid #E2E8F0;
            border-radius: 12px;
            padding: 3rem 2rem;
            min-height: 500px;
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

        .btn-save{background:linear-gradient(135deg,#FFB800,#FF8C00);color:#fff;border:none;border-radius:12px;padding:0.85rem 2.5rem;font-size:0.95rem;font-weight:700;font-family:'Inter',sans-serif;cursor:pointer;box-shadow:0 8px 25px rgba(255,184,0,0.3);transition:transform 0.2s;}
        .btn-save:hover{transform:translateY(-2px);}
        .btn-back{background:rgba(255,255,255,0.06);color:rgba(255,255,255,0.7);border:1px solid rgba(255,255,255,0.1);border-radius:12px;padding:0.6rem 1rem;font-size:0.82rem;font-weight:600;text-decoration:none;display:inline-flex;align-items:center;gap:0.4rem;}

        .current-img{margin-top:1rem;display:flex;flex-direction:column;gap:0.5rem;}
        .current-img img{width:120px;height:120px;border-radius:10px;object-fit:cover;border:1px solid rgba(255,255,255,0.1);}
        .current-img span{font-size:0.7rem;color:rgba(255,255,255,0.4);}
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
        <a href="{{ route('admin.faq_page') }}" class="nav-item"><i class="fas fa-list-ul"></i> FAQ Page</a>
        <a href="{{ route('admin.guides.index') }}" class="nav-item active"><i class="fas fa-guide"></i> Guides</a>
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
            <h1><i class="fas fa-edit" style="color:#FFB800;margin-right:0.5rem;"></i> Edit Post</h1>
            <div class="breadcrumb"><a href="{{ route('admin.dashboard') }}">Dashboard</a> / <a href="{{ route('admin.guides.index') }}">Guides</a> / Edit</div>
        </div>
        <a href="{{ route('admin.guides.index') }}" class="btn-back"><i class="fas fa-arrow-left"></i> Back to List</a>
    </div>

    <div class="content">
        <form id="guideForm" method="POST" action="{{ route('admin.guides.update', $guide->id) }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="content" id="contentInput">
            
            <div class="form-card">
                <div class="form-card-header">
                    <div class="hicon"><i class="fas fa-file-alt"></i></div>
                    <div><h3>Basic Information</h3></div>
                </div>
                
                <div class="form-group">
                    <label>Title</label>
                    <input type="text" name="title" value="{{ $guide->title }}" required>
                </div>
                
                <div class="grid-2">
                    <div class="form-group">
                        <label>Slug</label>
                        <input type="text" name="slug" value="{{ $guide->slug }}">
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status">
                            <option value="1" {{ $guide->status ? 'selected' : '' }}>Published</option>
                            <option value="0" {{ !$guide->status ? 'selected' : '' }}>Draft</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label>Short Description</label>
                    <textarea name="description" rows="3">{{ $guide->description }}</textarea>
                </div>
            </div>

            <div class="form-card">
                <div class="form-card-header">
                    <div class="hicon"><i class="fas fa-pen-nib"></i></div>
                    <div><h3>Content (Editor.js)</h3></div>
                </div>
                <div class="form-group">
                    <div id="editor"></div>
                </div>
            </div>

            <div class="form-card">
                <div class="form-card-header">
                    <div class="hicon"><i class="fas fa-image"></i></div>
                    <div><h3>Media & Author</h3></div>
                </div>
                <div class="grid-2">
                    <div class="form-group">
                        <label>Featured Image (Leave empty to keep current)</label>
                        <input type="file" name="featured_image" accept="image/*">
                        @if($guide->featured_image)
                        <div class="current-img">
                            <span>Current image:</span>
                            <img src="{{ $guide->featured_image }}" alt="">
                        </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>Image Alt Text</label>
                        <input type="text" name="image_alt" value="{{ $guide->image_alt }}">
                    </div>
                </div>
                <div class="grid-2">
                    <div class="form-group">
                        <label>Author Name</label>
                        <input type="text" name="author_name" value="{{ $guide->author_name }}">
                    </div>
                    <div class="form-group">
                        <label>Reading Time</label>
                        <input type="text" name="reading_time" value="{{ $guide->reading_time }}">
                    </div>
                </div>
                <div class="form-group">
                    <label>Video URL</label>
                    <input type="url" name="video_url" value="{{ $guide->video_url }}">
                </div>
            </div>

            <div class="form-card">
                <div class="form-card-header">
                    <div class="hicon"><i class="fas fa-search"></i></div>
                    <div><h3>SEO Metadata</h3></div>
                </div>
                <div class="form-group">
                    <label>Meta Description</label>
                    <textarea name="meta_description" rows="3" required>{{ $guide->meta_description }}</textarea>
                </div>
                <div class="form-group">
                    <label>Meta Keywords</label>
                    <input type="text" name="meta_keywords" value="{{ $guide->meta_keywords }}">
                </div>
                <div class="grid-2">
                    <div class="form-group">
                        <label>Tags</label>
                        <input type="text" name="tags" value="{{ $guide->tags }}">
                    </div>
                    <div class="form-group">
                        <label>Tags Cloud</label>
                        <input type="text" name="tags_cloud" value="{{ $guide->tags_cloud }}">
                    </div>
                </div>
            </div>

            <div style="margin-bottom:4rem; text-align:right;">
                <button type="submit" class="btn-save"><i class="fas fa-save"></i> Update Guide Post</button>
            </div>
        </form>
    </div>
</div>

<script>
    let guideEditor;

    document.addEventListener('DOMContentLoaded', async () => {
        try {
            // Prepare initial data
            let initialData = { blocks: [] };
            const rawContent = @json($guide->content);
            
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

            guideEditor = await editorJSManager.init('editor', {
                placeholder: 'Let\'s write an awesome story!',
                minHeight: 400,
                data: initialData
            });
            console.log('Editor.js initialized with Manager');
        } catch (e) {
            console.error('Editor.js initialization failed:', e);
        }
    });

    // Handle form submission
    document.getElementById('guideForm').onsubmit = async function(e) {
        e.preventDefault();
        try {
            if (guideEditor) {
                const contentData = await editorJSManager.save('editor');
                document.getElementById('contentInput').value = JSON.stringify(contentData);
                this.submit();
            } else {
                this.submit();
            }
        } catch (error) {
            console.error('Saving failed: ', error);
            alert('Something went wrong while saving the editor content.');
        }
    };
</script>

</body>
</html>
