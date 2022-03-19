<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ArtistController extends Controller
{
    public function getExhibitionById($id)
    {
        $exhibition = Exhibition::find($id);
        if(!$exhibition)
        {
            return response(['No exhibition found'], 404);
        }

        return new ExhibitionResource($exhibition);

    }

    public function getAllExhibitions()
    {
        $exhibitions = Exhibition::all();

        return new ExhibitionCollection($exhibitions);
    }
}
