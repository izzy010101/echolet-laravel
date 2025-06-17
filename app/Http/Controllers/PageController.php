<?php

namespace App\Http\Controllers;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;

class PageController extends Controller
{

    public function contact()
    {
        return Inertia::render('Contact', [
            'auth' => ['user' => Auth::user()],
            'footerCategories' => Category::all(), //cats work now
        ]);
    }

}
