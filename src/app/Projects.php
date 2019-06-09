<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\ProjectStatus;

class Projects extends Model
{
    public  static function ProjectsByUser($id_user){
        $projects = static::where('id_user', $id_user)->orderBy('created_at', 'desc')->get(); 
        $data=[];
        foreach($projects as $project) {
            $data[] = [
                'id' => $project->id,
                'title' =>$project->title,
                'description' => $project->description,
                'nlikes' => $project->nlikes,
                'created_at' => $project->created_at->format('d/m/Y'),
                'user' => User::findOrFail($project->id_user),
                'status' => ProjectStatus::findOrFail($project->id_project_status)
            ];
           }
        return $data;
    }
    public  static function ProjectsByStatus($id_status){
        $projects = static::where('id_project_status', $id_status)->orderBy('created_at', 'desc')->get(); 
        $data=[];
        foreach($projects as $project) {
            $data[] = [
                'id' => $project->id,
                'tile' =>$project->title,
                'description' => $project->description,
                'nlikes' => $project->nlikes,
                'created_at' => $project->created_at->format('d/m/Y'),
                'user' => User::findOrFail($project->id_user),
                'status' => ProjectStatus::findOrFail($project->id_project_status)
            ];
           }
        return $data;
    }
}
