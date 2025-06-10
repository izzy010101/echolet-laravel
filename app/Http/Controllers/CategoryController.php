<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CategoryController extends Controller
{
    public function index()
    {
        return Inertia::render('Categories/Index', [
            'categories' => Category::with('posts')->select('id', 'name', 'image', 'icon')->get(),
            'auth' => auth()->user(),
        ]);
    }


    public function show($id)
    {
        $category = Category::with('posts')->findOrFail($id);

        return Inertia::render('Categories/Show', [
            'category' => $category,
            'posts' => $category->posts,
            'auth' => auth()->user(),
            'categories' => Category::all(),
        ]);
    }
}
