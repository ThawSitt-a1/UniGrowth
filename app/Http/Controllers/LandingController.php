<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LandingController
{
    /**
     * Serve the landing page for guests, or redirect authenticated
     * users straight to their dashboard.
     */
    public function __invoke(Request $request)
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('landing');
    }
}

