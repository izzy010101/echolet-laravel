<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Str;



class PostController extends Controller
{
    public function index()
    {
        $posts = Post::latest('published_at')->take(10)->get();

        return Inertia::render('Home', $this->sharedProps([
            'featured' => $posts->first(),
            'posts' => $posts->skip(1)->values(),
            'auth' => auth()->user(),
        ]));
    }

    private function sharedProps(array $props): array
    {
        return array_merge($props, [
            'auth' => ['user' => auth()->user()],
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
        ]);

        $post = \App\Models\Post::create([
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']),
            'excerpt' => Str::limit(strip_tags($validated['content']), 100),
            'body' => $validated['content'],
            'category_id' => $validated['category_id'],
            'user_id' => auth()->id(),
            'published_at' => now(),
        ]);

        return redirect()->route('dashboard')->with('success', 'Post created!');
    }
}
