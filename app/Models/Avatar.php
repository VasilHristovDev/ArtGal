<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic;

class Avatar extends Model
{
    use HasFactory, CrudTrait;

    const AVATAR_PATH = "/avatars/";

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function storeMedia($value)
    {
        $image = ImageManagerStatic::make($value);

        $filename = md5($value.time()).'.jpg';
        Storage::disk('public')->put(self::AVATAR_PATH.$filename, $image);

        $this->url = $filename;
    }

    public function getUrlAttribute($value)
    {
        return Storage::disk('public')->url(self::AVATAR_PATH . $value);
    }
}
