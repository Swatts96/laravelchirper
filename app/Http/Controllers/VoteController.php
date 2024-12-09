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
        $request->validate(['type' => 'required|in:upvote,downvote']);

        // Remove the opposite vote
        $chirp->votes()
            ->where('user_id', auth()->id())
            ->where('type', $request->type === 'upvote' ? 'downvote' : 'upvote')
            ->delete();

        // Add or update the current vote
        $chirp->votes()->updateOrCreate(
            ['user_id' => auth()->id()],
            ['type' => $request->type]
        );

        return response()->json(['totalVotes' => $chirp->total_votes]);
    }

    public function destroy(Chirp $chirp): \Illuminate\Http\JsonResponse
    {
        // Remove the vote
        $chirp->votes()->where('user_id', auth()->id())->delete();

        return response()->json(['totalVotes' => $chirp->total_votes]);
    }
}
