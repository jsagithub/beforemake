<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Comments;
use App\Http\Resources\Comments as CommentsResource;
use App\User; 
use Illuminate\Support\Facades\Auth; 

class CommentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comments = Comments::paginate(15);

        return CommentsResource::collection($comments);
    }

    
    public function store(Request $request)
    {
        if(!Auth::user()->id){
            abort(403);
        }
        $user = Auth::user(); 
        $comment = $request->isMethod('put') ? Comments::findOrFail($request->comment_id) : new Comments;
        
        $comment->id = $request->input('comment_id');
        $comment->id_stories = $request->input('id_stories');
        $comment->id_user = $user->id;
        $comment->comment = $request->input('comment');
       
        if ($comment->save()) {
           return new CommentsResource($comment);
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
        $comment = Comments::findOrFail($id);
        return new CommentsResource($comment);
    }

    public function show_by_storie($id_storie){
        $comments = Comments::CommentsByStorie($id_storie);
        return $comments;
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $comment = Comments::findOrFail($id);
        if($comment->id_user !==Auth::user()->id){
            abort(403);
        }
        if ($comment->delete()) {
            return new CommentsResource($comment);
        }  
    }
}
