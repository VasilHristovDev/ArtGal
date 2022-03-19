<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Painting extends Model
{
    use HasFactory, CrudTrait;

    protected $guarded = ['id'];
    protected $fillable = ['name', 'width', 'height', 'material', 'user_id', 'genre_id', 'exhibition_id'];

    public function exhibition()
    {
        return $this->belongsTo(Exhibition::class, 'exhibition_id');
    }

    public function genre()
    {
        return $this->belongsTo(Genre::class, 'genre_id');
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function likes()
    {
        return $this->hasMany(UserPaintingsLikes::class);
    }
}
