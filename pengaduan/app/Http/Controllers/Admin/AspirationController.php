<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Aspiration;
use App\Models\Category;
use Illuminate\Http\Request;

class AspirationController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::orderBy('nama_kategori')->get();
        $query = Aspiration::with(['category', 'comments']);

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

        $query->latest();
        $aspirations = $query->paginate(15)->withQueryString();

        return view('admin.aspiration.index', compact('aspirations', 'categories'));
    }

    public function show($id)
    {
        $aspiration = Aspiration::with(['category', 'comments' => function ($q) {
            $q->latest();
        }])->findOrFail($id);

        return view('admin.aspiration.show', compact('aspiration'));
    }

}
