<?php

namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\Post;
use Inertia\Inertia;

class PageController extends Controller
{

    public function home()
    {
        $categories = Category::select('id', 'name')->get();

        return Inertia::render('Home', [
            'categories' => $categories,
        ]);
    }
    public function blog()
    {
        return Inertia::render('Blog');
    }

    public function contact()
    {
        return Inertia::render('Contact');
    }

}
