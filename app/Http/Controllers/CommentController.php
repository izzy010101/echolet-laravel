<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'body' => 'required|string',
            'post_id' => 'required|exists:posts,id',
            'parent_id' => 'nullable|exists:comments,id',
        ]);

        $comment = Comment::create([
            'body' => $validated['body'],
            'user_id' => auth()->id(),
            'post_id' => $validated['post_id'],
            'parent_id' => $validated['parent_id'] ?? null,
        ]);

        return Inertia::location(route('posts.show', $request->post_id));
    }

    public function destroy(Comment $comment)
    {
        if ($comment->user_id !== auth()->id()) {
            abort(403);
        }

        $comment->delete();

        return back()->with('success', 'Comment deleted.');
    }
}
