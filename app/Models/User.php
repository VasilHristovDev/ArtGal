<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'age'

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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function paintings()
    {
       return $this->hasMany(Painting::class);
    }
    public function avatar()
    {
        return $this->hasOne(Avatar::class);
    }
    public function exhibitions()
    {
        return $this->hasMany(Exhibition::class);
    }
    public function likes()
    {
        return $this->hasMany(UserPaintingsLikes::class);
    }

    public function getAvatarImageAttribute()
    {
        if(!$this->avatar)
            return null;
        return $this->avatar->url;
    }
}
