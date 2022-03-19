<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use JsonSerializable;

class ArtistCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  Request  $request
     * @return array
     */

    public function toArray($request)
    {
       $arr = [];
        foreach ($this as $artist) {
            $tempObj = new \stdClass();
            $tempObj->name = $artist->name;
            $tempObj->country = $artist->country;
            $tempObj->paintings_count = $artist->paintings->count();
            $tempObj->exhibitions_count = $artist->exhibitions->count();
            $arr[] = $tempObj;
       }
        return $arr;
    }
}
