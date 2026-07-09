<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Show categories list on dashboard.
     */
    public function index()
    {
        $categories = Category::withCount('aspirations')->get();

        return view('kategori.index', compact('categories'));
    }

    /**
     * Show form to create a new category.
     */
    public function create()
    {
        return view('kategori.create');
    }

    /**
     * Store a newly created category.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:categories,nama_kategori',
            'deskripsi' => 'nullable|string|max:500',
        ]);

        Category::create([
            'nama_kategori' => $validatedData['nama_kategori'],
            'deskripsi' => $validatedData['deskripsi'] ?? null,
        ]);

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    /**
     * Show form to edit an existing category.
     */
    public function edit($id)
    {
        $kategori = Category::findOrFail($id);
        
        return view('kategori.edit', compact('kategori'));
    }

    /**
     * Update the specified category.
     */
    public function update(Request $request, $id)
    {
        $kategori = Category::findOrFail($id);

        $validatedData = $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:categories,nama_kategori,' . $kategori->id,
            'deskripsi' => 'nullable|string|max:500',
        ]);

        $kategori->update([
            'nama_kategori' => $validatedData['nama_kategori'],
            'deskripsi' => $validatedData['deskripsi'] ?? null,
        ]);

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    /**
     * Remove the specified category.
     */
    public function destroy($id)
    {
        $kategori = Category::findOrFail($id);

        // Check if category has any aspirations
        if ($kategori->aspirations()->exists()) {
            return redirect()->route('kategori.index')->with('error', 'Kategori tidak dapat dihapus karena masih memiliki aspirasi.');
        }

        $kategori->delete();

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil dihapus.');
    }
}
