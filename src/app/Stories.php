<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Stories extends Model
{
    public  static function StoriesByProject($id_project){
        $stories = static::where('id_project', $id_project)->orderBy('created_at', 'desc')->get(); 
        $data = [];
        $comment_data = [];
        //Add comments to array stories
        foreach($stories as $storie) { 
            $comment_data = [];
            $comments=Comments::where('id_stories', $storie->id)->get();
            foreach($comments as $comment) {
                $comment_data[]= [
                    'comment' => $comment->comment,
                    'user' => User::findOrFail($comment->id_user)
                ];
            }  
            $data[] = [
                'id' => $storie->id,
                'id_project' =>$storie->id_project,
                'description' => $storie->description,
                'created_at' => $storie->created_at->format('d/m/Y'),
                'images' => Images::where('id_stories', $storie->id)->get(),
                'videos' => Videos::where('id_stories', $storie->id)->get(),
                'comments' => $comment_data,
                'user' => User::findOrFail($storie->id_user)
            ];
           }
        return $data;
    }
}
