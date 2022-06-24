<?php

namespace Inform\Http\Controllers;

class AboutController extends Controller
{
    public function __construct()
    {
        view()->share('demomode', true);
    }

    public function index()
    {
        return view('about');
    }
}
