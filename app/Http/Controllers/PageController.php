<?php

namespace App\Http\Controllers;
use App\Models\Category;

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
    public function about()
    {
        return Inertia::render('About');
    }

    public function contact()
    {
        return Inertia::render('Contact');
    }
}
