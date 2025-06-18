<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('q');
        $category = $request->input('category');

        $postsQuery = Post::with(['category', 'user'])->latest();

        if ($query) {
            $postsQuery->where(function ($q2) use ($query) {
                $q2->where('title', 'like', "%{$query}%")
                    ->orWhere('excerpt', 'like', "%{$query}%")
                    ->orWhereHas('category', fn($cat) => $cat->where('name', 'like', "%{$query}%"));
            });
        }

        if ($category) {
            $postsQuery->whereHas('category', fn($q2) => $q2->where('name', $category));
        }

        // Highlight category if search query matches it
        $matchedCategory = null;
        if (!empty($query)) {
            $matchedCategory = Category::where('name', 'like', "%{$query}%")->first();
        }
        $selectedCategory = $category ?? ($matchedCategory ? $matchedCategory->name : null);

        return Inertia::render('Blog/Index', [
            'posts' => $postsQuery->get(),
            'categories' => Category::all(),
            'searchQuery' => $query,
            'selectedCategory' => $selectedCategory,
            'auth' => ['user' => Auth::user()],
            'footerCategories' => Category::all(),
        ]);
    }

}
