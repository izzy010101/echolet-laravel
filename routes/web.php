<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use Inertia\Inertia;



Route::get('/', [PostController::class, 'index'])->name('home');





require __DIR__.'/auth.php';