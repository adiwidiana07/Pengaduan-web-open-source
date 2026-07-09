<?php

namespace App\Http\Controllers;

use App\Models\Aspiration;
use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class VoteController extends Controller
{
    public function vote(Request $request, $aspirationId)
    {
        $aspiration = Aspiration::findOrFail($aspirationId);
        
        $request->validate([
            'vote_type' => 'required|in:upvote,downvote',
        ]);

        $voteType = $request->input('vote_type');

        // Check or generate voter token in session
        $voterToken = session()->get('voter_token');
        if (!$voterToken) {
            $voterToken = (string) Str::uuid();
            session()->put('voter_token', $voterToken);
        }

        // Check if user has already voted on this aspiration
        $existingVote = Vote::where('aspiration_id', $aspiration->id)
            ->where('voter_token', $voterToken)
            ->first();

        if ($existingVote) {
            if ($existingVote->vote_type === $voteType) {
                // Cancel vote (toggle off)
                $existingVote->delete();
                $aspiration->decrement($voteType);
                $message = 'Dukungan Anda dibatalkan.';
            } else {
                // Change vote (e.g. from downvote to upvote)
                $oldType = $existingVote->vote_type;
                $existingVote->update(['vote_type' => $voteType]);
                $aspiration->decrement($oldType);
                $aspiration->increment($voteType);
                $message = 'Dukungan Anda berhasil diubah.';
            }
        } else {
            // New vote
            Vote::create([
                'aspiration_id' => $aspiration->id,
                'vote_type' => $voteType,
                'voter_token' => $voterToken,
            ]);
            $aspiration->increment($voteType);
            $message = 'Dukungan Anda berhasil dikirim.';
        }

        return redirect()->back()->with('success', $message);
    }
}
