<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Models\Post;

class DashboardController extends Controller
{
    public function index()
    {
        $posts = Post::where('user_id', Auth::id())
            ->with('category')
            ->latest()
            ->get();

        return Inertia::render('Dashboard', [
            'posts' => $posts,
        ]);
    }
}
