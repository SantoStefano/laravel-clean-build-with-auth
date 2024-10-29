<?php

namespace App\Http\Controllers;

use App\Models\Platform;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $platforms = Platform::with('competency')->get();
        return view('home', [
            'platforms' => $platforms
        ]);
    }
}