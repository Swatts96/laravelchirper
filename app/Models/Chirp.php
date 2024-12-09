<?php

namespace App\Models;

use App\Events\ChirpCreated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Chirp extends Model
{
//test
    use HasFactory;

    protected $fillable = ['message'];

    protected $dispatchesEvents = [
        'created' => ChirpCreated::class,
    ];
    public function user(): BelongsTo
    {
        return $this->belongsTo('App\Models\User');
    }

    public function likes() //TO BE REPLACED BY VOTES BUT ONCE REMOVED CURRENTLY BREAKS APP
    {
        return $this->hasMany(Like::class);
    }

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    public function getTotalVotesAttribute()
    {
        $upvotes = $this->votes()->where('type', 'upvote')->count();
        $downvotes = $this->votes()->where('type', 'downvote')->count();
        return $upvotes - $downvotes;
    }
}
