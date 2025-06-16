<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Models\Post;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('q');

        $posts = \App\Models\Post::where('user_id', auth()->id())
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
            'categories' => \App\Models\Category::select('id', 'name')->get(),
            'query' => $query,
            'auth' => ['user' => auth()->user()],
            'footerCategories' => CategoryController::all(),
        ]);
    }

}
