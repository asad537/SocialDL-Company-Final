<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Http\Controllers\VideoController;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/extract', [VideoController::class, 'extract']);
Route::get('/proxy-download', [VideoController::class, 'proxyDownload']);
Route::get('/merge-download', [VideoController::class, 'mergeDownload']);
Route::get('/thumbnail-proxy', [VideoController::class, 'proxyThumbnail']);
