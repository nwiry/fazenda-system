<?php

namespace App\Http\Controllers;

use App\Models\Cattle;
use Illuminate\Http\Request;

class FarmPages extends Controller
{
    public static function dashboard()
    {
        return view('dashboard', ['nums_cattle' => Cattle::sum_cattles()]);
    }
}
