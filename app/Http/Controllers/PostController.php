<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('q');

        $postsQuery = Post::with('category')->latest('published_at');

        if ($query) {
            $postsQuery->where(function ($q2) use ($query) {
                $q2->where('title', 'like', "%{$query}%")
                    ->orWhere('excerpt', 'like', "%{$query}%")
                    ->orWhereHas('category', fn($cat) => $cat->where('name', 'like', "%{$query}%"));
            });
        }

        $posts = $postsQuery->take(10)->get();
        $categories = Category::select('id', 'name')->get();

        return Inertia::render('Home', [
            'featured' => $posts->first(),
            'posts' => $posts->skip(1)->values(),
            'categories' => $categories,
            'searchQuery' => $query,
            'auth' => ['user' => Auth::user()],
            'footerCategories' => Category::all(),
        ]);
    }


    private function sharedProps(array $props): array
    {
        return array_merge($props, [
            'auth' => ['user' => Auth::user()],
            'footerCategories' => Category::all(),
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

    public function update(Request $request, Post $post)
    {

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
        $post = Post::with('user', 'category')->findOrFail($id);

        $comments = \App\Models\Comment::with([
            'user',
            'likes',
            'replies.user',
            'replies.likes',
        ])
            ->where('post_id', $post->id)
            ->whereNull('parent_id')
            ->latest()
            ->get();

        return Inertia::render('Posts/Show', $this->sharedProps([
            'post' => $post,
            'comments' => $comments->map(function ($comment) {
                return [
                    'id' => $comment->id,
                    'content' => $comment->content,
                    'user' => $comment->user->only(['id', 'name']),
                    'likes_count' => $comment->likes->count(),
                    'is_liked' => auth()->check() ? $comment->likes->contains('user_id', auth()->id()) : false,
                    'replies' => $comment->replies->map(function ($reply) {
                        return [
                            'id' => $reply->id,
                            'content' => $reply->content,
                            'user' => $reply->user->only(['id', 'name']),
                            'likes_count' => $reply->likes->count(),
                            'is_liked' => auth()->check() ? $reply->likes->contains('user_id', auth()->id()) : false,
                        ];
                    }),
                ];
            }),
        ]));


    }
}
