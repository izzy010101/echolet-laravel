<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\SendNewsletterWelcome;

class NewsletterController extends Controller
{
    public function subscribe(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        SendNewsletterWelcome::dispatch($request->email);

        return back()->with('success', 'Thanks for subscribing!');
    }
}
