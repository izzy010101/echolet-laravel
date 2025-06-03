<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\SendNewsletterWelcome;
use Inertia\Inertia;

class NewsletterController extends Controller
{

    public function subscribe(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        if (session()->get('subscribed_email') === $request->email) {
            return redirect()->back()->with('success', 'You have already subscribed.');
        }

        session()->put('subscribed_email', $request->email);

        SendNewsletterWelcome::dispatch($request->email);

        return redirect()->back()->with('success', 'Thanks for subscribing!');
    }


}
