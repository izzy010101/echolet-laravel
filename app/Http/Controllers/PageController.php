<?php

namespace App\Http\Controllers;
use App\Models\Post;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;

class PageController extends Controller
{

    public function contact()
    {
        return Inertia::render('Contact', [
            'auth' => Auth::user(),
            'footerCategories' => Category::all(), //cats work now
        ]);
    }

}
