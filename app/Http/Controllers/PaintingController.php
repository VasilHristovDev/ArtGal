<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaintingRequest;
use App\Http\Resources\PaintingCollection;
use App\Http\Resources\PaintingResource;
use App\Models\Image;
use App\Models\Painting;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
