<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Rankings;
use App\Http\Resources\Rankings as RankingsResource;
use Illuminate\Support\Facades\Auth;

class RankingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rankings = Rankings::paginate(15);

        return RankingsResource::collection($rankings);
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
        $ranking = $request->isMethod('put') ? Rankings::findOrFail($request->ranking_id) : new Rankings;
        
        $ranking->id = $request->input('ranking_id');
        $ranking->id_project = $request->input('id_project');        
        $ranking->position = $request->input('position');
        $ranking->id_project_status = $request->input('id_project_status');
        $ranking->id_user = $user->id;
        if ($ranking->save()) {
           return new RankingsResource($ranking);
        }
    }

    public function rankings_by_project($id_project){
        $rankings = Rankings::RankingsByProject($id_project);
        return $rankings;
    }

    public function rankings_by_status($id_status){
        $rankings = Rankings::RankingsByStatus($id_status);
        return $rankings;
    }    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ranking = Rankings::findOrFail($id);
        if ($ranking->delete()) {
            return new RankingsResource($ranking);
        }  
    }
}
