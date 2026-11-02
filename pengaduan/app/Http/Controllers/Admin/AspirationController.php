<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Aspiration;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AspirationController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::orderBy('nama_kategori')->get();
        $query = Aspiration::with('category')->withCount(['comments', 'reports']);

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                    ->orWhere('isi', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->input('category_id'));
        }

        if ($request->input('sort') === 'reports') {
            $query->orderByDesc('reports_count');
        }

        $aspirations = $query->latest()->paginate(15)->withQueryString();
        $threshold = config('pengaduan.report_threshold');

        return view('admin.aspiration.index', compact('aspirations', 'categories', 'threshold'));
    }

    public function show(Aspiration $aspiration)
    {
        $aspiration->load(['category', 'comments' => fn ($q) => $q->latest()])->loadCount('reports');

        $reasonCounts = $aspiration->reports()
            ->selectRaw('alasan, COUNT(*) as total')
            ->groupBy('alasan')
            ->orderByDesc('total')
            ->pluck('total', 'alasan');

        $notes = $aspiration->reports()->whereNotNull('catatan')->latest()->limit(20)->get();

        return view('admin.aspiration.show', [
            'aspiration' => $aspiration,
            'reasonCounts' => $reasonCounts,
            'notes' => $notes,
            'reasons' => config('pengaduan.report_reasons'),
            'threshold' => config('pengaduan.report_threshold'),
        ]);
    }

    public function destroy(Aspiration $aspiration)
    {
        $aspiration->loadCount('reports');

        if (Gate::denies('moderate', $aspiration)) {
            return back()->with('error', 'Aspirasi baru bisa dihapus setelah menerima minimal '.config('pengaduan.report_threshold').' laporan.');
        }

        $aspiration->delete();

        return redirect()->route('admin.laporan.index')->with('success', 'Aspirasi "'.$aspiration->judul.'" telah dihapus.');
    }
}
