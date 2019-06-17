<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ProjectStatus;

class Rankings extends Model
{
    public  static function RankingsByProject($id_project){
        $rankings = static::where('id_project', $id_project)->orderBy('created_at', 'desc')->get(); 
        $data=[];
        foreach($rankings as $ranking) {
            $data[] = [
                'id' => $ranking->id,
                'id_project' =>$ranking->id_project,                
                'position' => $ranking->position,                
                'created_at' => $ranking->created_at->format('d/m/Y'),
                'status' => ProjectStatus::findOrFail($ranking->id_project_status)
            ];
           }
        return $data;
    }

    public  static function RankingsByStatus($id_status){
        $rankings = static::where('id_project_status', $id_status)->orderBy('created_at', 'desc')->get(); 
        $data=[];
        foreach($rankings as $ranking) {
            $data[] = [
                'id' => $ranking->id,
                'project' =>$ranking->id_project,                
                'position' => $ranking->position,                
                'created_at' => $ranking->created_at->format('d/m/Y'),
                'status' => ProjectStatus::findOrFail($ranking->id_project_status)
            ];
           }
        return $data;
    }    
}
