<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArtistResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        $arrWithPaintings = [];
        $arrWithExhibitions = [];

        foreach ($this->paintings as $painting) {
            $arrWithPaintings[] = $painting;
        }
        foreach ($this->exhibitions as $exhibition) {
            $arrWithExhibitions[] = $exhibition;
        }

        return [
            'name' => $this->name,
            'age' => $this->age,
            'paintings' => $arrWithPaintings,
            'exhibitions' => $arrWithExhibitions,
            'country' => $this->country,
            'avatar_image' => $this->getAvatarImageAttribute()
        ];
    }
}
