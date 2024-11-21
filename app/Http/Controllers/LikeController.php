<?php

namespace App\Http\Controllers;

use App\Models\Chirp;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    // Storing a like
    public function liking(Request $request, Chirp $chirp){

    }

    // Removing a like
    public function destroy(Request $request, Chirp $chirp){

    }
}
