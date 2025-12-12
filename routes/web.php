<?php  
  
use App\Http\Controllers\ProfileController;  
use App\Http\Controllers\BlogController;  
use App\Http\Controllers\CategoryController;  
use Illuminate\Support\Facades\Route;  
use App\Models\Blog;  
use App\Models\Category;  
use App\Http\Middleware\AdminMiddleware;  
  
  
Route::get('/', function () {  
return view('welcome');  
});  
  
// Dashboard - محمي بالتحقق من تسجيل الدخول  
Route::get('/dashboard', function () {  
return view('dashboard');  
})->middleware(['auth', 'verified'])->name('dashboard');  
  
  
// Routes لاختبار العلاقات (اختياري)  
Route::get('/test/blogs', function () {  
return Blog::with('categories')->get();  
});  
  
Route::get('/test/categories', function () {  
return Category::with('blogs')->get();  
});  
Route::middleware(['auth', AdminMiddleware::class])->group(function () {  
    Route::resource('blogs', BlogController::class);  
    Route::resource('categories', CategoryController::class);  
  
    Route::get('/blogs-trash', [BlogController::class, 'trash'])->name('blogs.trash');  
    Route::put('/blogs/{blog}/restore', [BlogController::class, 'restore'])->name('blogs.restore');  
    Route::delete('/blogs/{blog}/force-delete', [BlogController::class, 'forceDelete'])->name('blogs.forceDelete');  
});  
  
// Auth routes من Breeze  
require __DIR__.'/auth.php';   