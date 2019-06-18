<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Stories;
use App\Http\Resources\Stories as StoriesResource;
use Illuminate\Support\Facades\Auth;

class StoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $storie = Stories::paginate(15);

        return StoriesResource::collection($storie);
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
        $storie = $request->isMethod('put') ? Stories::findOrFail($request->storie_id) : new Stories;
        
        $storie->id = $request->input('storie_id');
        $storie->id_project = $request->input('id_project');       
        $storie->description = $request->input('description');
        $storie->id_user = $user->id;
        
        if ($storie->save()) {
           return new StoriesResource($storie);
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
        $storie = Stories::findOrFail($id);
        return new StoriesResource($storie);
    }

    public function show_by_project($id_project){
        $stories = Stories::StoriesByProject($id_project);
        return $stories;
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $storie = Stories::findOrFail($id);
        if($storie->id_user !==Auth::user()->id){
            abort(403);
        }
        if ($storie->delete()) {
            return new StoriesResource($storie);
        } 
    }
}
