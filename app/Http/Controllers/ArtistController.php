<?php

namespace App\Http\Controllers;

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
        return $artist;
        //return new UserResource($exhibition);

    }

    public function getAllExhibitions()
    {
        $artists = User::where('role_id',2)->get();

        return $artists;
        //return new UserCollection($exhibitions);
    }
}
