<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Painting extends Model
{
    use HasFactory, CrudTrait;

    public function exhibition()
    {
        $this->belongsToMany(Exhibition::class);
    }
    public function genre()
    {
        $this->belongsTo(Genre::class);
    }
    public function images()
    {
        $this->hasMany(Image::class);
    }
    public  function user()
    {
        $this->belongsTo(User::class);
    }
}
