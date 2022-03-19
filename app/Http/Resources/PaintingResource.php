<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaintingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $arrWithImages = [];
        foreach ($this->images as $image)
        {
            $arrWithImages = $image;
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'width' => $this->width,
            'height' => $this->height,
            'material' => $this->material,
            'author' => $this->user,
            'genre' => $this->genre,
            'gallery' => $arrWithImages,
            'exhibition' => $this->exhibition
        ];
    }
}
