<?php

namespace App\Http\Controllers;

use App\Models\Chirp;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    // Storing a like
    public function store(Request $request, Chirp $chirp): \Illuminate\Http\JsonResponse
    {
        // Add the like
        $chirp->likes()->create([
            'user_id' => auth()->id(),
        ]);

        // Return the updated like count
        return response()->json(['likesCount' => $chirp->likes()->count()]);
    }


    // Removing a like
    public function destroy(Request $request, Chirp $chirp): \Illuminate\Http\JsonResponse
    {
        // Remove the like
        $chirp->likes()->where('user_id', auth()->id())->delete();

        // Return the updated like count
        return response()->json(['likesCount' => $chirp->likes()->count()]);
    }

}
