<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('q');

        // Get all categories with ALL posts (no post filtering)
        $categories = Category::with('posts')->get();

        // Try to match query to a category name (case-insensitive)
        $matchedIndex = null;
        if ($query) {
            $matchedIndex = $categories->search(function ($cat) use ($query) {
                return strtolower($cat->name) === strtolower($query);
            });
        }

        return Inertia::render('Categories/Index', [
            'auth' => ['user' => Auth::user()],
            'categories' => $categories,
            'searchQuery' => $query,
            'matchedIndex' => $matchedIndex,
//            'footerCategories' => Category::all(),
        ]);
    }



    public function show($id)
    {
        $category = Category::with('posts')->findOrFail($id);

        return Inertia::render('Categories/Show', [
            'auth' => ['user' => Auth::user()],
            'category' => $category,
            'posts' => $category->posts,
            'categories' => Category::all(),
            'footerCategories' => Category::all(),
        ]);
    }
}
