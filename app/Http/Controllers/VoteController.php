<?php

namespace App\Http\Controllers;

use App\Models\Chirp;
use Illuminate\Http\Request;

class VoteController extends Controller
{
    /**
     * Store a new vote or update an existing vote.
     */
    public function store(Request $request, Chirp $chirp): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'type' => 'required|in:upvote,downvote,neutral',
        ]);

        // Remove any existing vote for the current user
        $chirp->votes()->where('user_id', auth()->id())->delete();

        // If the vote is not neutral, add the new vote
        if ($request->type !== 'neutral') {
            $chirp->votes()->create([
                'user_id' => auth()->id(),
                'type' => $request->type,
            ]);
        }
        return response()->json(['totalVotes' => $chirp->total_votes]);
    }


    public function destroy(Chirp $chirp): \Illuminate\Http\JsonResponse
    {
        // Remove the vote
        $chirp->votes()->where('user_id', auth()->id())->delete();
        return response()->json(['totalVotes' => $chirp->total_votes]);
    }
}
