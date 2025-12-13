<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\AdminMiddleware;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/test/blogs', function () {
    return \App\Models\Blog::with('categories')->get();
});

Route::get('/test/categories', function () {
    return \App\Models\Category::with('blogs')->get();
});

// Frontend Routes - للمستخدمين العاديين
Route::get('/blogs/category/{category}', [BlogController::class, 'filterByCategory'])->name('blogs.frontend.filter');
Route::get('/blogs', [BlogController::class, 'frontendIndex'])->name('blogs.frontend.index');
Route::get('/blogs/{blog}', [BlogController::class, 'frontendShow'])->name('blogs.frontend.show');

Route::middleware('auth')->group(function () {
    Route::get('/favorites', [BlogController::class, 'favorites'])->name('blogs.frontend.favorites');
    Route::post('/blogs/{blog}/favorite', [BlogController::class, 'toggleFavorite'])->name('blogs.frontend.toggleFavorite');
});

// Admin Routes - للإدارة فقط
Route::middleware(['auth', AdminMiddleware::class])->group(function () {
    // CRUD كامل للمدونات والفئات
    Route::resource('blogs', BlogController::class)->except(['index', 'show']);
    
    Route::resource('categories', CategoryController::class);

    // Trash / Restore / Force Delete
    Route::get('/blogs-trash', [BlogController::class, 'trash'])->name('blogs.trash');
    Route::put('/blogs/{blog}/restore', [BlogController::class, 'restore'])->name('blogs.restore');
    Route::delete('/blogs/{blog}/force-delete', [BlogController::class, 'forceDelete'])->name('blogs.forceDelete');
});

require __DIR__.'/auth.php';