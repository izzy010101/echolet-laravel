<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CommentLikeController;



Route::get('/', [PostController::class, 'index'])->name('home');

//categories
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{id}', [CategoryController::class, 'show'])->name('categories.show');

Route::get('/posts/{id}', [PostController::class, 'show'])->name('posts.show');

//blog
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');



Route::controller(PageController::class)->group(function () {
    Route::get('/contact', 'contact')->name('contact');

});

Route::post('/subscribe', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');


Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});


Route::middleware('auth')->group(function () {
    //prifile edit
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //posts
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');

    //comments likes
    // routes/web.php
    Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
    Route::post('/comments/{comment}/like', [CommentLikeController::class, 'toggle'])->name('comments.like');
    Route::put('/comments/{comment}', [CommentController::class, 'update'])->name('comments.update');


});


require __DIR__.'/auth.php';
