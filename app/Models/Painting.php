<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Painting extends Model
{
    use HasFactory, CrudTrait;

    public function genre()
    {
        $this->hasOne(Genre::class);
    }
    public function exhibition()
    {
        $this->hasOne(Exhibition::class);
    }
    public function period()
    {
        $this->hasOne(Period::class);
    }
    public function images()
    {
        $this->hasMany(Image::class);
    }
}
