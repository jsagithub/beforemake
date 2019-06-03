<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Images extends Model
{
    public  static function ImagesByStorie($id_storie){
        $images = static::where('id_stories', $id_storie)->orderBy('created_at', 'desc')->get(); 
        $data=[];
        foreach($images as $image) {
            $data[] = [
                'id' => $image->id,
                'id_storie' =>$image->id_stories,
                'url' => $image->url,                
                'created_at' => $image->created_at->format('d/m/Y'),
                'user' => User::findOrFail($image->id_user)
            ];
           }
        return $data;
    }
}
