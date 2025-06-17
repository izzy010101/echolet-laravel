<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Models\Post;
use App\Models\Category;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('q');

        $posts = Post::where('user_id', auth()->id())
            ->with('category')
            ->when($query, function ($q) use ($query) {
                $q->where(function ($subquery) use ($query) {
                    $subquery
                        ->where('title', 'like', '%' . $query . '%')
                        ->orWhere('excerpt', 'like', '%' . $query . '%'); // Remove ->orWhere('content')
                });
            })
            ->latest()
            ->get();

        return Inertia::render('Dashboard', [
            'posts' => $posts,
            'categories' => Category::select('id', 'name')->get(),
            'query' => $query,
            'auth' => auth()->user(),
            'footerCategories' => Category::all(),
        ]);
    }

}
