<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;

class BlogController extends Controller
{
    public function index()
    {
        return inertia('Blog/Index', [
            'posts' => Post::with('category', 'user')->latest()->get(),
            'categories' => Category::all(),
        ]);
    }
}
