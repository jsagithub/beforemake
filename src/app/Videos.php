<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Videos extends Model
{
    public  static function VideosByStorie($id_storie){
        $videos = static::where('id_stories', $id_storie)->orderBy('created_at', 'desc')->get(); 
        $data=[];
        foreach($videos as $video) {
            $data[] = [
                'id' => $video->id,
                'id_storie' =>$video->id_stories,                
                'url' => $video->url,                
                'created_at' => $video->created_at->format('d/m/Y'),
                'user' => User::findOrFail($video->id_user)
            ];
           }
        return $data;
    }
}
