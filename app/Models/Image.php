<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic;

class Image extends Model
{

    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;

    const ORIGINAL_PATH = "/painting-images/original/";
    const LARGE_PATH = "/painting-images/large/";
    const MEDIUM_PATH = "/painting-images/medium/";

    public function painting()
    {
        return $this->belongsTo(Painting::class);
    }
    public function storeMedia($value)
    {
        $image = ImageManagerStatic::make($value);

        $filename = md5($value.time()).'.jpg';
        Storage::disk('public')->put(self::ORIGINAL_PATH.$filename, $image);

        $imageMedium = ImageManagerStatic::make($image)->orientate();
        $imageMedium->resize(1080, 720, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });
        $imageMedium->interlace();
        $imageMedium->encode('jpg',80);
        Storage::disk('public')->put(self::MEDIUM_PATH.$filename,$imageMedium);

        $imageLarge = ImageManagerStatic::make($value)->orientate();
        $imageLarge->resize(1920, 1080, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });
        $imageLarge->interlace();
        $imageLarge->encode('jpg', 90);
        Storage::disk('public')->put(self::LARGE_PATH.$filename, $imageLarge);

        $this->url = $filename;
    }

    public function getUrlAttribute($value)
    {
        return Storage::disk('public')->url(self::LARGE_PATH . $value);
    }
}
