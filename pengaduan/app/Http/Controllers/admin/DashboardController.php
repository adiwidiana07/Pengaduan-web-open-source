<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Aspiration;
use App\Models\Category;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Show the admin dashboard.
     */
    public function index()
    {
        $totalAspirations = Aspiration::count();
        $totalUpvotes = Aspiration::sum('upvote');
        $totalDownvotes = Aspiration::sum('downvote');
        $totalCategories = Category::count();
        
        $latestAspirations = Aspiration::with('category')->latest()->take(5)->get();

        return view('dashboard', compact(
            'totalAspirations', 
            'totalUpvotes', 
            'totalDownvotes', 
            'totalCategories', 
            'latestAspirations'
        ));
    }
}
