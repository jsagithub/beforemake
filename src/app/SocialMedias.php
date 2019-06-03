<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SocialMedias extends Model
{
    public  static function SocialMediasByProject($id_project){
        $socialmedias = static::where('id_project', $id_project)->orderBy('created_at', 'desc')->get(); 
        $data=[];
        foreach($socialmedias as $socialmedia) {
            $data[] = [
                'id' => $socialmedia->id,
                'id_project' =>$socialmedia->id_project,
                'name' =>$socialmedia->name,
                'icon' => $socialmedia->icon, 
                'url' => $socialmedia->url,                
                'created_at' => $socialmedia->created_at->format('d/m/Y'),
                'user' => User::findOrFail($socialmedia->id_user)
            ];
           }
        return $data;
    }
}
