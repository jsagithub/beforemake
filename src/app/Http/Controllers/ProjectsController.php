<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Projects;
use App\Http\Resources\Projects as ProjectsResource;
use Illuminate\Support\Facades\Auth;

class ProjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $project = Projects::paginate(15);

        return ProjectsResource::collection($project);
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
        $project = $request->isMethod('put') ? Projects::findOrFail($request->project_id) : new Projects;
        
        $project->id = $request->input('project_id');        
        $project->id_user = $user->id;        
        $project->title = $request->input('title');
        $project->description = $request->input('description');
        $project->id_project_status = $request->input('id_project_status');
        if ($project->save()) {
           return new ProjectsResource($project);
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
        $project = Projects::findOrFail($id);
        return new ProjectsResource($project);
    }

    public function show_by_user($id_user){
        $projects = Projects::ProjectsByUser($id_user);
        return $projects;
    }

    public function show_by_status($id_status){
        $projects = Projects::ProjectsByStatus($id_status);
        return $projects;
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $project = Projects::findOrFail($id);
        if($project->id_user !==Auth::user()->id){
            abort(403);
        }
        if ($project->delete()) {
            return new ProjectsResource($project);
        } 
    }
}
