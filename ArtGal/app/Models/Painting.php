<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Painting extends Model
{
    use HasFactory;

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
}
