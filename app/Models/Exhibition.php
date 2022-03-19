<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exhibition extends Model
{
    use CrudTrait;
    use HasFactory;
    protected  $guarded=['id'];
    protected  $fillable=['theme','user_id'];

    public function paintings()
    {
        return $this->hasMany(Painting::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
