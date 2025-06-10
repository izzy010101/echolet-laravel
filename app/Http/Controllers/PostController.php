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

        $post = Post::create([
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

    public function update(Request $request, Post $post) {

        $validated = $request->validate([
            'title' => 'required|string|min:3|max:255',
            'body' => 'required|string|min:10',
            'category_id' => 'required|exists:categories,id',
        ]);
        $validated['excerpt'] = Str::limit(strip_tags($validated['body']), 50);
        $post->update($validated);

        return redirect()->back()->with('success', 'Post updated successfully.');
    }

    public function destroy(Post $post)
    {
        // Optional: restrict to the owner
        $post->delete();

        return redirect()->back();
    }

    public function show($id)
    {
        $post = Post::findOrFail($id);

        return Inertia::render('Posts/Show', [
            'post' => $post,
            'auth' => auth()->user(),
        ]);
    }
}
