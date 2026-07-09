<?php

namespace App\Http\Controllers;

use App\Models\Aspiration;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AspirationController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::orderBy('nama_kategori')->get();
        $query = Aspiration::with(['category', 'comments']);

        // Search filter
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('isi', 'like', "%{$search}%");
            });
        }

        // Category filter
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->input('category_id'));
        }

        // Sorting
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
        $categories = Category::orderBy('nama_kategori')->get();

        return view('aspiration.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string|max:10000',
            'category_id' => 'required|exists:categories,id',
        ]);

        $ownerToken = (string) Str::uuid();

        $aspiration = Aspiration::create([
            'judul' => $validatedData['judul'],
            'isi' => $validatedData['isi'],
            'category_id' => $validatedData['category_id'],
            'owner_token' => $ownerToken,
        ]);

        // Save token to session list so they can edit it easily
        session()->push('my_aspiration_tokens', $ownerToken);

        return redirect()->route('aspirasi.success', $aspiration->id)->with('owner_token', $ownerToken);
    }

    public function success($id)
    {
        $aspiration = Aspiration::findOrFail($id);
        $token = session('owner_token') ?? request('token');

        if (!$token) {
            return redirect()->route('aspirasi.show', $aspiration->id);
        }

        return view('aspiration.success', compact('aspiration', 'token'));
    }

    public function show($id)
    {
        $aspiration = Aspiration::with(['category', 'comments' => function ($q) {
            $q->latest();
        }])->findOrFail($id);

        // Check if the user owns this aspiration (has token in session)
        $myTokens = session()->get('my_aspiration_tokens', []);
        $isOwner = in_array($aspiration->owner_token, $myTokens);

        return view('aspiration.view', compact('aspiration', 'isOwner'));
    }

    public function edit(Request $request, $id)
    {
        $aspiration = Aspiration::findOrFail($id);
        $categories = Category::orderBy('nama_kategori')->get();

        $token     = $request->input('token');
        $myTokens  = session()->get('my_aspiration_tokens', []);
        $hasAccess = in_array($aspiration->owner_token, $myTokens);

        // Token submitted but wrong — redirect back with error so the modal auto-opens
        if ($token && $token !== $aspiration->owner_token && !$hasAccess) {
            return redirect()
                ->route('aspirasi.show', $aspiration->id)
                ->with('token_error', 'Token yang Anda masukkan salah. Silakan periksa kembali.');
        }

        // No token and not in session — show verify page
        if (!$token && !$hasAccess) {
            return view('aspiration.verify_token', compact('aspiration'));
        }

        // Valid token — save to session for convenience
        if ($token === $aspiration->owner_token && !$hasAccess) {
            session()->push('my_aspiration_tokens', $token);
        }

        return view('aspiration.edit', compact('aspiration', 'categories', 'token'));
    }

    public function update(Request $request, $id)
    {
        $aspiration = Aspiration::findOrFail($id);

        $validatedData = $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string|max:10000',
            'category_id' => 'required|exists:categories,id',
            'token' => 'nullable|string',
        ]);

        $token = $request->input('token');
        $myTokens = session()->get('my_aspiration_tokens', []);

        if ($token !== $aspiration->owner_token && !in_array($aspiration->owner_token, $myTokens)) {
            return redirect()->route('aspirasi.show', $aspiration->id)
                ->with('error', 'Token pemilik tidak valid atau Anda tidak memiliki akses.');
        }

        $aspiration->update([
            'judul' => $validatedData['judul'],
            'isi' => $validatedData['isi'],
            'category_id' => $validatedData['category_id'],
        ]);

        return redirect()->route('aspirasi.show', $aspiration->id)->with('success', 'Aspirasi berhasil diperbarui.');
    }

    public function destroy(Request $request, $id)
    {
        $aspiration = Aspiration::findOrFail($id);
        $token = $request->input('token');
        $myTokens = session()->get('my_aspiration_tokens', []);

        if ($token !== $aspiration->owner_token && !in_array($aspiration->owner_token, $myTokens)) {
            return redirect()->route('aspirasi.show', $aspiration->id)
                ->with('error', 'Token pemilik tidak valid atau Anda tidak memiliki akses.');
        }

        $aspiration->delete();

        return redirect()->route('aspirasi.index')->with('success', 'Aspirasi berhasil dihapus.');
    }
}
