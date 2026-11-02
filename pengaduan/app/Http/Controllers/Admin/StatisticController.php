<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Aspiration;
use App\Models\Category;
use Illuminate\Http\Request;

class StatisticController extends Controller
{
    /**
     * Show statistics dashboard.
     */
    public function index()
    {
        $totalAspirations = Aspiration::count();
        $categories = Category::withCount('aspirations')->get();

        $totalUpvotes = Aspiration::sum('upvote');
        $totalDownvotes = Aspiration::sum('downvote');
        $totalVotes = $totalUpvotes + $totalDownvotes;
        $upvotePercent = $totalVotes > 0 ? round(($totalUpvotes / $totalVotes) * 100) : 0;
        $downvotePercent = $totalVotes > 0 ? round(($totalDownvotes / $totalVotes) * 100) : 0;

        // Calculate monthly stats for the current year (1-12)
        $monthlyCounts = array_fill(1, 12, 0);
        Aspiration::whereYear('created_at', date('Y'))->get()->each(function ($item) use (&$monthlyCounts) {
            $month = (int) $item->created_at->format('n');
            $monthlyCounts[$month]++;
        });

        // Find max monthly count to scale the charts dynamically
        $maxMonthlyCount = max($monthlyCounts) ?: 1;

        $monthNames = [
            1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'Mei', 6 => 'Jun',
            7 => 'Jul', 8 => 'Agu', 9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Des'
        ];

        return view('dashboard_statistik', compact(
            'totalAspirations',
            'categories',
            'totalUpvotes',
            'totalDownvotes',
            'totalVotes',
            'upvotePercent',
            'downvotePercent',
            'monthlyCounts',
            'maxMonthlyCount',
            'monthNames'
        ));
    }
}
