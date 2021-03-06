<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Videos;
use App\Http\Resources\Videos as VideosResource;
use Illuminate\Support\Facades\Auth;

class VideosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $videos = Videos::paginate(15);

        return VideosResource::collection($videos);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!Auth::user()->id){
            abort(403);
        }
        $user = Auth::user();
        $video = $request->isMethod('put') ? Videos::findOrFail($request->video_id) : new Videos;
        
        $video->id = $request->input('video_id');
        $video->id_stories = $request->input('id_stories');        
        $video->url = $request->input('url');
        $video->id_user = $user->id;
        if ($video->save()) {
           return new VideosResource($video);
        }
    }

    public function show_by_storie($id_storie){
        $videos = Videos::VideosByStorie($id_storie);
        return $videos;
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $video = Videos::findOrFail($id);
        if($video->id_user !==Auth::user()->id){
            abort(403);
        }
        if ($video->delete()) {
            return new VideosResource($video);
        }  
    }
}
