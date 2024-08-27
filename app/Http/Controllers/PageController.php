<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function index(Request $request)
    {
        return view('index');
    }

    /**
     * Handle the incoming request.
     */
    public function privacyPolicy(Request $request)
    {
        return view('privacy_policy');
    }

    /**
     * Handle the incoming request.
     */
    public function termsAndConditions(Request $request)
    {
        return view('terms_and_conditions');
    }
}
