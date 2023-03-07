<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Sanctum\HasApiTokens;

class User extends Model
{
    use HasApiTokens, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'avatar',
        'token',
    ];

    public $timestamps = false;

    public function blockedUsers() : BelongsToMany
    {
        return $this->belongsToMany(User::class, 'blocks', 'user_id', 'blocked_user_id');
    }

    public function tracks() : HasMany
    {
        return $this->hasMany(Track::class);
    }

    public function likedTracks() : BelongsToMany
    {
        return $this->belongsToMany(Tracks::class, 'likes');
    }
}
