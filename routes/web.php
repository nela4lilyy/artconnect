<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\GalleryImageController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Public\GalleryController as PublicGalleryController;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\NewsController as PublicNewsController;
use App\Http\Controllers\Public\SearchController;
use Illuminate\Support\Facades\Route;

// ── Public ──────────────────────────────────────────────────────────────
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/search', [SearchController::class, 'index'])->name('search');

Route::prefix('news')->name('news.')->group(function () {
    Route::get('/', [PublicNewsController::class, 'index'])->name('index');
    Route::get('/{slug}', [PublicNewsController::class, 'show'])->name('show');
});

Route::prefix('galleries')->name('galleries.')->group(function () {
    Route::get('/', [PublicGalleryController::class, 'index'])->name('index');
    Route::get('/{gallery}', [PublicGalleryController::class, 'show'])->name('show');
});

// ── Admin Auth ───────────────────────────────────────────────────────────
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login',  [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::post('/logout',[AuthController::class, 'logout'])->name('logout');

    // ── Admin Protected ──────────────────────────────────────────────────
    Route::middleware('auth')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::resource('categories', CategoryController::class)->except(['show']);
        Route::resource('news', NewsController::class);
        Route::resource('galleries', GalleryController::class);

        // Gallery Images (nested)
        Route::prefix('galleries/{gallery}/images')->name('gallery-images.')->group(function () {
            Route::get('/',                   [GalleryImageController::class, 'index'])->name('index');
            Route::get('/create',             [GalleryImageController::class, 'create'])->name('create');
            Route::post('/',                  [GalleryImageController::class, 'store'])->name('store');
            Route::get('/{galleryImage}/edit',[GalleryImageController::class, 'edit'])->name('edit');
            Route::put('/{galleryImage}',     [GalleryImageController::class, 'update'])->name('update');
            Route::delete('/{galleryImage}',  [GalleryImageController::class, 'destroy'])->name('destroy');
        });
    });
});
