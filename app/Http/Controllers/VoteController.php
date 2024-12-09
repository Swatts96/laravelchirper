<?php

namespace App\Http\Controllers;

use App\Models\Chirp;
use App\Models\Vote;
use Illuminate\Http\Request;

class VoteController extends Controller
{
    public function upvote(Request $request, Chirp $chirp)
    {
        // Remove downvote if exists
        $chirp->votes()->where('user_id', auth()->id())->where('type', 'downvote')->delete();

        // Add upvote
        $chirp->votes()->updateOrCreate(
            ['user_id' => auth()->id()],
            ['type' => 'upvote']
        );

        return response()->json(['totalVotes' => $chirp->total_votes]);
    }

    public function downvote(Request $request, Chirp $chirp)
    {
        // Remove upvote if exists
        $chirp->votes()->where('user_id', auth()->id())->where('type', 'upvote')->delete();

        // Add downvote
        $chirp->votes()->updateOrCreate(
            ['user_id' => auth()->id()],
            ['type' => 'downvote']
        );

        return response()->json(['totalVotes' => $chirp->total_votes]);
    }
}
