<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('q');

        $categories = Category::with('posts')->get(); // or filtered logic

        return Inertia::render('Categories/Index', [
            'auth' => auth()->user(),
            'categories' => $categories,
            'searchQuery' => $query,
            'allCategories' => Category::all(), // for left-side nav
            'footerCategories' => Category::all(),
        ]);
    }

    public function show($id)
    {
        $category = Category::with('posts')->findOrFail($id);

        return Inertia::render('Categories/Show', [
            'auth' => auth()->user(),
            'category' => $category,
            'posts' => $category->posts,
            'categories' => Category::all(),
            'footerCategories' => Category::all(),
        ]);
    }
}
