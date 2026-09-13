<?php

use App\Http\Controllers\ArtikelController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Dashboard\DivisiDashboardController;
use App\Http\Controllers\Dashboard\PkDashboardController;
use App\Http\Controllers\Dashboard\WmDashboardController;
use App\Http\Controllers\DashboardRedirectController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PublicNewsController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserManagementController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PublicNewsController::class, 'index'])->name('public.index');
Route::get('/berita/{slug}', [PublicNewsController::class, 'showBerita'])->name('public.berita.show');
Route::get('/artikel/{slug}', [PublicNewsController::class, 'showArtikel'])->name('public.artikel.show');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardRedirectController::class, 'redirect'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware('role:webmaster')->prefix('dashboard/wm')->name('wm.')->group(function () {
        Route::get('/', [WmDashboardController::class, 'index'])->name('dashboard');
        Route::resource('users', UserManagementController::class)->except('show');
    });

    Route::middleware('role:webmaster|perencanaan_konten')->prefix('dashboard/pk')->name('pk.')->group(function () {
        Route::get('/', [PkDashboardController::class, 'index'])->name('dashboard');

        Route::resource('categories', CategoryController::class)->except('show');

        Route::resource('berita', BeritaController::class)
            ->parameters(['berita' => 'berita']);
        Route::delete('berita/{berita}/images/{media}', [BeritaController::class, 'destroyImage'])
            ->name('berita.images.destroy');

        Route::resource('artikel', ArtikelController::class);
        Route::delete('artikel/{artikel}/images/{media}', [ArtikelController::class, 'destroyImage'])
            ->name('artikel.images.destroy');

        Route::resource('products', ProductController::class)->except('show');

        Route::resource('tasks', TaskController::class)->only(['index', 'create', 'store', 'show']);
    });

    Route::middleware('role:fotographer|videographer|copywriting|illustrator|reporter|desain_grafis')
        ->prefix('dashboard/divisi')->name('divisi.')->group(function () {
            Route::get('/', [DivisiDashboardController::class, 'index'])->name('dashboard');
            Route::get('/tasks', [TaskController::class, 'myTasks'])->name('tasks.index');
            Route::patch('/tasks/{task}/status', [TaskController::class, 'updateStatus'])->name('tasks.update-status');
        });
});

require __DIR__.'/auth.php';
