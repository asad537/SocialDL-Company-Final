<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\AdminController;

// ── Admin Routes ──────────────────────────────────────────────────────────────
Route::get('/admin/login', [AdminController::class, 'login'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'doLogin'])->name('admin.login.post');
Route::get('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');
Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin.dashboard');
Route::get('/admin/homepage', [AdminController::class, 'homepageEdit'])->name('admin.homepage');
Route::post('/admin/homepage', [AdminController::class, 'homepageSave'])->name('admin.homepage.save');

// FAQ Admin Routes
Route::get('/admin/faqs', [AdminController::class, 'faqIndex'])->name('admin.faqs');
Route::post('/admin/faqs', [AdminController::class, 'faqStore'])->name('admin.faqs.store');
Route::delete('/admin/faqs/{id}', [AdminController::class, 'faqDelete'])->name('admin.faqs.delete');

// FAQ Page (Dedicated)
Route::get('/admin/faq-page', [AdminController::class, 'faqPageSettings'])->name('admin.faq_page');
Route::post('/admin/faq-page', [AdminController::class, 'faqPageStore'])->name('admin.faq_page.store');
Route::post('/admin/faq-page/seo', [AdminController::class, 'faqPageSeoSave'])->name('admin.faq_page.seo.save');
Route::delete('/admin/faq-page/{id}', [AdminController::class, 'faqPageDelete'])->name('admin.faq_page.delete');

// Blog Admin Routes
use App\Http\Controllers\BlogController;
Route::get('/admin/blogs', [BlogController::class, 'index'])->name('admin.blogs.index');
Route::get('/admin/blogs/create', [BlogController::class, 'create'])->name('admin.blogs.create');
Route::post('/admin/blogs', [BlogController::class, 'store'])->name('admin.blogs.store');
Route::get('/admin/blogs/{id}/edit', [BlogController::class, 'edit'])->name('admin.blogs.edit');
Route::post('/admin/blogs/{id}', [BlogController::class, 'update'])->name('admin.blogs.update');
Route::delete('/admin/blogs/{id}', [BlogController::class, 'destroy'])->name('admin.blogs.delete');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');
Route::get('/blogs', [BlogController::class, 'publicIndex'])->name('blogs.index');

// Guide Admin Routes
use App\Http\Controllers\GuideController;
Route::get('/admin/guides', [GuideController::class, 'index'])->name('admin.guides.index');
Route::get('/admin/guides/create', [GuideController::class, 'create'])->name('admin.guides.create');
Route::post('/admin/guides', [GuideController::class, 'store'])->name('admin.guides.store');
Route::get('/admin/guides/{id}/edit', [GuideController::class, 'edit'])->name('admin.guides.edit');
Route::post('/admin/guides/{id}', [GuideController::class, 'update'])->name('admin.guides.update');
Route::delete('/admin/guides/{id}', [GuideController::class, 'destroy'])->name('admin.guides.delete');
Route::get('/guide/{slug}', [GuideController::class, 'publicShow'])->name('guide.show');

// Platform Admin Routes
use App\Http\Controllers\PlatformController;
Route::get('/admin/platforms', [PlatformController::class, 'index'])->name('admin.platforms.index');
Route::get('/admin/platforms/create', [PlatformController::class, 'create'])->name('admin.platforms.create');
Route::post('/admin/platforms', [PlatformController::class, 'store'])->name('admin.platforms.store');
Route::get('/admin/platforms/{id}/edit', [PlatformController::class, 'edit'])->name('admin.platforms.edit');
Route::post('/admin/platforms/{id}', [PlatformController::class, 'update'])->name('admin.platforms.update');
Route::delete('/admin/platforms/{id}', [PlatformController::class, 'destroy'])->name('admin.platforms.delete');
Route::post('/admin/platforms/{id}/faqs', [PlatformController::class, 'faqStore'])->name('admin.platforms.faqs.store');
Route::delete('/admin/platforms/faqs/{faq_id}', [PlatformController::class, 'faqDelete'])->name('admin.platforms.faqs.delete');

Route::get('/faqs', [App\Http\Controllers\AdminController::class, 'publicFaqs'])->name('public.faqs');
Route::post('/admin/cms/upload-editor-image', [AdminController::class, 'uploadEditorImage'])->name('admin.cms.upload-editor-image');


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Load Strategy:
|   /extract        → Cached per URL (30 min). Rate-limited: 10 req/min/IP.
|   /direct-download → Zero server load (302 redirect to CDN).
|   /proxy-download  → Fallback only. Rate-limited: 20 req/min/IP.
|   /merge-download  → FFmpeg (1080p+). Rate-limited: 5 req/min/IP.
|   /thumbnail-proxy → Browser-cached 1 hour. Rate-limited: 60 req/min/IP.
|
*/

Route::get('/', function () {
    $settings = DB::table('homepage_settings')->first();
    $faqs = DB::table('faqs')->where('page', 'home')->where('is_active', true)->orderBy('sort_order')->get();
    $blogs = \App\Models\Blog::where('status', 1)->latest()->limit(4)->get();
    return view('home', compact('settings', 'faqs', 'blogs'));
})->name('home');

Route::get('/download', function () {
    return view('download');
})->name('download');

// ── Extract: most expensive (Python subprocess) ──────────────────────────
// Rate limit: 10 requests per minute per IP
Route::post('/extract', [VideoController::class, 'extract'])
    ->middleware('throttle:10,1');

// ── Direct download: zero server load (CDN redirect) ────────────────────
// No rate limit needed — server only sends a 302 response
Route::get('/direct-download', [VideoController::class, 'directDownload']);

// ── Proxy download: fallback streaming ──────────────────────────────────
Route::get('/proxy-download', [VideoController::class, 'proxyDownload'])
    ->middleware('throttle:20,1');

// ── Merge download: FFmpeg (heavy, 1080p+ only) ──────────────────────────
Route::get('/merge-download', [VideoController::class, 'mergeDownload'])
    ->middleware('throttle:5,1');

// ── Thumbnail proxy: browser-cached, lightweight ─────────────────────────
Route::get('/thumbnail-proxy', [VideoController::class, 'proxyThumbnail'])
    ->middleware('throttle:60,1');

// Catch-all Public Platform Route (Must be last)
Route::get('/{slug}', [PlatformController::class, 'show'])->name('platforms.show');
