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

        // Generate or get voter token to serve as owner token for comment (so they can identify themselves or delete in future)
        $ownerToken = session()->get('voter_token');
        if (!$ownerToken) {
            $ownerToken = (string) Str::uuid();
            session()->put('voter_token', $ownerToken);
        }

        Comment::create([
            'aspiration_id' => $aspiration->id,
            'isi' => $validatedData['isi'],
            'owner_token' => $ownerToken,
        ]);

        return redirect()->back()->with('success', 'Komentar Anda berhasil ditambahkan.');
    }
}
