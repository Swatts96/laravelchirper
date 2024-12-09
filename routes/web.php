<?php

use App\Http\Controllers\ProfileController;
use App\http\Controllers\ChirpController;
use App\Http\Controllers\VoteController;
use Illuminate\Support\Facades\Route;
//use App\Http\Controllers\LikeController;



Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

    Route::resource('chirps', ChirpController::class)
        ->only(['index', 'store'])
        ->only(['index', 'store', 'edit', 'show', 'update', 'destroy'])
        ->middleware(['auth', 'verified']);


//Route::post('/chirps/{chirp}/like', [LikeController::class, 'store'])->name('chirps.like');
//Route::delete('/chirps/{chirp}/like', [LikeController::class, 'destroy'])->name('chirps.unlike');

Route::post('/chirps/{chirp}/upvote', [VoteController::class, 'upvote'])->name('chirps.upvote');
Route::post('/chirps/{chirp}/downvote', [VoteController::class, 'downvote'])->name('chirps.downvote');

require __DIR__.'/auth.php';
