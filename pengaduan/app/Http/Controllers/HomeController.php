<?php

namespace App\Http\Controllers;

use App\Models\Aspiration;

class HomeController extends Controller
{
    public function index()
    {
        $latest = Aspiration::with('category')->withCount('comments')->latest()->take(5)->get();

        return view('index', compact('latest'));
    }
}
