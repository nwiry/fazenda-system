<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FarmPages extends Controller
{
    public static function dashboard()
    {
        return view('dashboard');
    }
}
