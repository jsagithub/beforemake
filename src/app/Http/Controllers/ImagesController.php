<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Images;
use App\Http\Resources\Images as ImagesResource;

class ImagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $images = Images::paginate(15);

        return ImagesResource::collection($images);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $image = $request->isMethod('put') ? Images::findOrFail($request->image_id) : new Images;
        
        $image->id = $request->input('image_id');
        $image->id_stories = $request->input('id_stories');
        $image->url = $request->input('url');
        //Need to be changed to Auth
        $image->id_user = 1;
        if ($image->save()) {
           return new ImagesResource($image);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $image = Images::findOrFail($id);
        return new ImagesResource($image);
    }

    public function show_by_storie($id_storie){
        $images = Images::ImagesByStorie($id_storie);
        return $images;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $image = Images::findOrFail($id);
        if ($image->delete()) {
            return new ImagesResource($image);
        }  
    }
}
