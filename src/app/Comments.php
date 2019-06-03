<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Comments extends Model
{
    public  static function CommentsByStorie($id_storie){
        $comments = static::where('id_stories', $id_storie)->orderBy('created_at', 'desc')->get(); 
        $data=[];
        foreach($comments as $comment) {
            $data[] = [
                'id' => $comment->id,
                'id_storie' =>$comment->id_stories,
                'comment' => $comment->comment,                
                'created_at' => $comment->created_at->format('d/m/Y'),
                'user' => User::findOrFail($comment->id_user)
            ];
           }
        return $data;
    }
}
