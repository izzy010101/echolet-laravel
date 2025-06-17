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

        $categories = Category::with(['posts' => function ($q) use ($query) {
            if ($query) {
                $q->where('title', 'like', "%$query%")
                    ->orWhere('excerpt', 'like', "%$query%");
            }
        }])->get();

        return Inertia::render('Categories/Index', [
            'auth' => ['user' => Auth::user()],
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
            'auth' => ['user' => Auth::user()],
            'category' => $category,
            'posts' => $category->posts,
            'categories' => Category::all(),
            'footerCategories' => Category::all(),
        ]);
    }
}
