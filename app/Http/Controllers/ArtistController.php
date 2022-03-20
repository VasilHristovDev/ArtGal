<?php

namespace App\Http\Controllers;

use App\Http\Resources\ArtistCollection;
use App\Http\Resources\ArtistResource;
use App\Http\Resources\ExhibitionCollection;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources;

class ArtistController extends Controller
{
    public function getArtistById($id)
    {
        $artist = User::where('role_id',2)->where('id',$id)->first();
        if(!$artist)
        {
            return response(['No artist found'], 404);
        }
        return new ArtistResource($artist);

    }

    public function getAllArtists()
    {
        $artists = User::where('role_id',2)->get();

        return new ArtistCollection($artists);
    }

    public function getAllExhibitions($id)
    {
        $artist = User::where('role_id',2)->where('id',$id)->get();
        if(!$artist)
        {
            return response([
                'No artist was found!',
                404
            ]);
        }
        return new ExhibitionCollection($artist->exhibitions);
    }
}
