<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'post_id' => 'required|exists:posts,id',
            'parent_id' => 'nullable|exists:comments,id',
            'content' => 'required|string',
        ]);

        Comment::create([
            'user_id' => auth()->id(),
            'post_id' => $validated['post_id'],
            'parent_id' => $validated['parent_id'] ?? null,
            'content' => $validated['content'],
        ]);

        return back()->with('success', 'Comment posted.');
    }

    public function update(Request $request, Comment $comment)
    {
        $validated = $request->validate([
            'content' => 'required|string',
        ]);

        if ($comment->user_id !== auth()->id()) {
            abort(403);
        }

        $comment->update(['content' => $validated['content']]);

        return back()->with('success', 'Comment updated.');
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
