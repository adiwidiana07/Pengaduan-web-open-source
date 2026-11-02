<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Aspiration;
use Illuminate\Support\Facades\Gate;

class ReportController extends Controller
{
    public function index()
    {
        $threshold = config('pengaduan.report_threshold');

        $aspirations = Aspiration::with('category')
            ->has('reports')
            ->withCount('reports')
            ->orderByDesc('reports_count')
            ->latest()
            ->paginate(15);

        $readyCount = Aspiration::has('reports', '>=', $threshold)->count();

        return view('admin.report.index', compact('aspirations', 'threshold', 'readyCount'));
    }

    public function dismiss(Aspiration $aspiration)
    {
        Gate::authorize('dismissReports', $aspiration);

        $aspiration->reports()->delete();

        return back()->with('success', 'Laporan untuk "'.$aspiration->judul.'" telah ditolak dan dihapus.');
    }
}
