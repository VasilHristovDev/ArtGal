<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exhibition extends Model
{
    use HasFactory;
    public  function painting()
    {
        $this->hasMany(Painting::class);
    }
    public function  user()
    {
        $this->belongsTo(User::class);
    }

}
