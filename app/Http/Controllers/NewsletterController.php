<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NewsletterController extends Controller
{
    public function index()
    {
        $subscribers = DB::table('newsletter_subscribers')->orderByDesc('id')->paginate(25);

        return view('centre.newsletter', compact('subscribers'));
    }

    public function store(Request $request)
    {
        $data = $request->validateWithBag('newsletter', [
            'newsletter_email' => ['required', 'email', 'max:254'],
            'newsletter_consent' => ['required', 'accepted'],
        ]);

        DB::table('newsletter_subscribers')->insertOrIgnore([
            'email' => mb_strtolower($data['newsletter_email']),
            'consented_at' => now(),
        ]);

        return back()->with('newsletter_success', 'Thank you for subscribing.');
    }
}
