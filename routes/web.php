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
    return view('home', compact('settings'));
});

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
