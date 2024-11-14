<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Chirps extends Model
{

    protected $fillable = ['message'];

    public function user(): BelongsTo
    {
        return $this->belongsTo('App\Models\User');
    }
}
