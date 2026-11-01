<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class HomeController extends Controller
{
    public function dashboard(): View
    {
        return view('dashboard');
    }

    public function about(): View
    {
        return view('about');
    }
}
