<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\SocialMedias;
use App\Http\Resources\SocialMedias as SocialMediasResource;

class SocialMediasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $social = SocialMedias::paginate(15);

        return SocialMediasResource::collection($social);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $social = $request->isMethod('put') ? SocialMedias::findOrFail($request->social_id) : new SocialMedias;
        
        $social->id = $request->input('social_id');
        $social->id_project = $request->input('id_project');
        $social->name = $request->input('name');
        $social->icon = $request->input('icon');
        $social->url = $request->input('url');
       
        if ($social->save()) {
           return new SocialMediasResource($social);
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
        $social = SocialMedias::findOrFail($id);
        return new SocialMediasResource($social);
    }

    public function show_by_project($id_project){
        $socialmedias = SocialMedias::SocialMediasByProject($id_project);
        return $socialmedias;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $social = SocialMedias::findOrFail($id);
        if ($social->delete()) {
            return new SocialMediasResource($social);
        }  
    }
}
