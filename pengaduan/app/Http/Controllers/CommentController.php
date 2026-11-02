<?php

namespace App\Http\Controllers;

use App\Models\Aspiration;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CommentController extends Controller
{
    public function store(Request $request, $aspirationId)
    {
        $aspiration = Aspiration::findOrFail($aspirationId);

        $validatedData = $request->validate([
            'isi' => 'required|string|max:1000',
        ]);

        // Kode acak baru per komentar: tidak terhubung ke akun, sesi, atau komentar lain dari orang yang sama.
        Comment::create([
            'aspiration_id' => $aspiration->id,
            'isi' => $validatedData['isi'],
            'owner_token' => (string) Str::uuid(),
        ]);

        return redirect()->back()->with('success', 'Komentar Anda berhasil ditambahkan.');
    }
}
