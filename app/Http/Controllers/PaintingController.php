<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaintingRequest;
use App\Http\Resources\PaintingCollection;
use App\Http\Resources\PaintingResource;
use App\Models\Image;
use App\Models\Painting;
use App\Models\UserPaintingsLikes;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class PaintingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }
    public function getPaintingById($id)
    {
        $painting = Painting::find($id);
        if(!$painting)
        {
            return response(['No painting found'], 404);
        }

        return new PaintingResource($painting);

    }
    public function getAllPaintings()
    {
        $paintings = Painting::all();

        return new PaintingCollection($paintings);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(PaintingRequest $request)
    {
        $painting = new Painting();
        $painting->name = $request["name"];
        $painting->width = $request["width"];
        $painting->height = $request["height"];
        $painting->material = $request["material"];
        $painting->user_id = $request["user"];
        $painting->genre_id = $request["genre"];

        foreach ($request->gallery as $item) {
            $image = new Image();
            $image->painting_id = $painting->id;
            $image->storeMedia($item);
            $image->save();
        }

        $painting->save();

    }

    public function likeLocation($id)
    {
        $user = Auth::user();
        $painting = Painting::where('id', $id)->first();
        $like = $painting->likes->where('user_id',$user->id)->first();

        if($like)
        {
            $like->delete();
            return response([
                'message' => $painting->name . ' is no longer in your likes',
            ], 200);
        }

        $like = new UserPaintingsLikes();
        $like->user_id = $user->id;
        $like->painting_id = $painting->id;
        return response([
            'message' => $painting->name. ' is now in your likes list',
        ], 200);
    }
}
