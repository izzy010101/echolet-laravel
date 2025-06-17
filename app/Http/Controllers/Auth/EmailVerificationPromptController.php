<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Category;
use App\Models\Post;

class EmailVerificationPromptController extends Controller
{
    /**
     * Display the email verification prompt.
     */
    public function __invoke(Request $request): RedirectResponse|Response
    {
        if ($request->user()->hasVerifiedEmail()) {
            $posts = Post::where('user_id', $request->user()->id)
                ->with('category')
                ->latest()
                ->get();

            return Inertia::render('Dashboard', [
                'posts' => $posts,
                'categories' => Category::select('id', 'name')->get(),
                'query' => null,
                'auth' => ['user' => $request->user()],
                'footerCategories' => Category::all(),
            ]);
        }

        return Inertia::render('Auth/VerifyEmail', [
            'status' => session('status'),
            'auth' => ['user' => $request->user()],
            'footerCategories' => Category::all(),
        ]);
    }

}
