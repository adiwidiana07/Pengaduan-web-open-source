<?php

namespace App\Http\Controllers;

use App\Models\Aspiration;
use App\Models\Category;
use App\Support\AnonymousIdentity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AspirationController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::orderBy('nama_kategori')->get();
        $query = Aspiration::with('category')->withCount('comments');

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

        if ($request->input('sort') === 'popular') {
            $query->orderByRaw('(upvote - downvote) DESC')->latest();
        } else {
            $query->latest();
        }

        $aspirations = $query->paginate(10)->withQueryString();

        return view('aspiration.index', compact('aspirations', 'categories'));
    }

    public function create()
    {
        Gate::authorize('create', Aspiration::class);

        $categories = Category::orderBy('nama_kategori')->get();

        return view('aspiration.create', compact('categories'));
    }

    public function store(Request $request)
    {
        Gate::authorize('create', Aspiration::class);

        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string|max:10000',
            'category_id' => 'required|exists:categories,id',
        ]);

        $aspiration = new Aspiration($validated);
        $aspiration->author_hash = AnonymousIdentity::authorHash($request->user());
        $aspiration->save();

        return redirect()->route('aspirasi.show', $aspiration)
            ->with('success', 'Aspirasi berhasil dikirim. Identitas Anda tidak ditampilkan kepada siapa pun, termasuk admin.');
    }

    public function show(Request $request, Aspiration $aspiration)
    {
        $aspiration->load(['category', 'comments' => fn ($q) => $q->latest()]);

        $user = $request->user();

        // Tamu yang menekan Masuk/Daftar dari halaman ini kembali ke aspirasi yang sama.
        if (! $user) {
            redirect()->setIntendedUrl($request->fullUrl());
        }

        return view('aspiration.view', [
            'aspiration' => $aspiration,
            'canManage' => $user?->can('update', $aspiration) ?? false,
            'canReport' => $user?->can('report', $aspiration) ?? false,
            'hasReported' => $user && ! $user->isAdmin() && ! $aspiration->isAuthoredBy($user)
                && $aspiration->reports()->where('reporter_hash', AnonymousIdentity::reporterHash($user))->exists(),
            'reportReasons' => config('pengaduan.report_reasons'),
        ]);
    }

    public function edit(Aspiration $aspiration)
    {
        Gate::authorize('update', $aspiration);

        $categories = Category::orderBy('nama_kategori')->get();

        return view('aspiration.edit', compact('aspiration', 'categories'));
    }

    public function update(Request $request, Aspiration $aspiration)
    {
        Gate::authorize('update', $aspiration);

        $aspiration->update($request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string|max:10000',
            'category_id' => 'required|exists:categories,id',
        ]));

        return redirect()->route('aspirasi.show', $aspiration)->with('success', 'Aspirasi berhasil diperbarui.');
    }

    public function destroy(Aspiration $aspiration)
    {
        Gate::authorize('delete', $aspiration);

        $aspiration->delete();

        return redirect()->route('my.aspirations')->with('success', 'Aspirasi berhasil dihapus.');
    }
}
