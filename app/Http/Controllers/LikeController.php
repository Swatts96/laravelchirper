<?php

namespace App\Http\Controllers;

use App\Models\Chirp;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    // Storing a like
    public function store(Request $request, Chirp $chirp): \Illuminate\Http\RedirectResponse
    {
        // adding the like
        $chirp->likes()->create([
            'user_id' => auth()->id(),
        ]);
        return redirect()->back()->with('success', 'Chirp liked!');
    }

    // Removing a like
    public function destroy(Request $request, Chirp $chirp): \Illuminate\Http\RedirectResponse
    {
        // Find the like and delete it
        $chirp->likes()->where('user_id', auth()->id())->delete();
        return redirect()->back()->with('success', 'Chirp unliked!');
    }
}
