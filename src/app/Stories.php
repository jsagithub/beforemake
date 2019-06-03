<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Stories extends Model
{
    public  static function StoriesByUser($id_project){
        $stories = static::where('id_project', $id_project)->orderBy('created_at', 'desc')->get(); 
        $data=[];
        foreach($stories as $storie) {
            $data[] = [
                'id' => $storie->id,
                'id_project' =>$storie->id_project,
                'description' => $storie->description,
                'nlikes' => $storie->nlikes,
                'created_at' => $storie->created_at->format('d/m/Y'),
                'user' => User::findOrFail($storie->id_user)
            ];
           }
        return $data;
    }
}
