<?php

namespace App\Http\Controllers;
use App\Models\Post;
use Inertia\Inertia;

class PageController extends Controller
{

    public function contact()
    {
        return Inertia::render('Contact');
    }

}
