<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Inertia\Inertia;


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
}