<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('q');
        $category = $request->input('category');

        $postsQuery = Post::with(['category', 'user'])->latest();

        if ($query) {
            $postsQuery->where(function ($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                    ->orWhere('excerpt', 'like', "%{$query}%")
                    ->orWhereHas('category', fn($cat) => $cat->where('name', 'like', "%{$query}%"));
            });
        }

        if ($category) {
            $postsQuery->whereHas('category', fn($q) => $q->where('name', $category));
        }

        return Inertia::render('Blog/Index', [
            'posts' => $postsQuery->get(),
            'categories' => Category::all(),
            'searchQuery' => $query,
            'selectedCategory' => $category,
        ]);
    }
}
