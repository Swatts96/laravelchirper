<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relationship: User has many chirps.
     */
    public function chirp(): HasMany
    {
        return $this->hasMany(Chirp::class);
    }

    /**
     * Relationship: User's votes on chirps.
     */
    public function votes(): HasMany
    {
        return $this->hasMany(Vote::class);
    }

    /**
     * Check if the user has upvoted a specific chirp.
     */
    public function hasUpvoted(Chirp $chirp): bool
    {
        return $this->votes()
            ->where('chirp_id', $chirp->id)
            ->where('type', 'upvote')
            ->exists();
    }

    /**
     * Check if the user has downvoted a specific chirp.
     */
    public function hasDownvoted(Chirp $chirp): bool
    {
        return $this->votes()
            ->where('chirp_id', $chirp->id)
            ->where('type', 'downvote')
            ->exists();
    }
}
