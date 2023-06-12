<?php
use App\Http\Controllers\BlogController;
use App\Models\Blog;
use Illuminate\Support\Facades\Route;

Route::get('/блог', function () {
    return view('pages.blog');
})->name('blog');
// Страницы блога
Route::prefix('/блог')->group(function () {
    $blog = Blog::get();
    foreach ($blog as $page) {
        Route::get("/$page->link", [BlogController::class, 'show'])->name("blog.show.$page->id");
    }
});
