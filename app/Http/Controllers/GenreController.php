<?php

namespace App\Http\Controllers;

use App\Http\Resources\GenreCollection;
use App\Http\Resources\PaintingCollection;
use App\Models\Genre;
use App\Models\Painting;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class GenreController extends Controller
{

    public function getAllPaintingsByGenre($id)
    {
        $paintings = Painting::where('genre_id',$id)->get();

        if(!$paintings)
        {
            return response([
                'No paintings were found for this genre',
                404
            ]);
        }

        return new PaintingCollection($paintings);
    }

    public function getAllGenres()
    {
        $genres = Genre::all();

        return new GenreCollection($genres);
    }

}
