<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;
use App\Models\Blog;
use App\Models\Category;


Route::get('/', function () {
return view('welcome');
});

// Dashboard - محمي بالتحقق من تسجيل الدخول
Route::get('/dashboard', function () {
return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Routes محمية لتسجيل الدخول
Route::middleware(['auth'])->group(function () {

// CRUD أساسي للمدونات  
Route::resource('blogs', BlogController::class);  

// Soft Delete للمدونات  
Route::get('/blogs-trash', [BlogController::class, 'trash'])->name('blogs.trash');  
Route::put('/blogs/{blog}/restore', [BlogController::class, 'restore'])->name('blogs.restore');  
Route::delete('/blogs/{blog}/force-delete', [BlogController::class, 'forceDelete'])->name('blogs.forceDelete');  

// CRUD للفئات  
Route::resource('categories', CategoryController::class);  

// Profile routes من Breeze  
Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');  
Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');  
Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});

// Routes لاختبار العلاقات (اختياري)
Route::get('/test/blogs', function () {
return Blog::with('categories')->get();
});

Route::get('/test/categories', function () {
return Category::with('blogs')->get();
});

// Auth routes من Breeze
require __DIR__.'/auth.php';