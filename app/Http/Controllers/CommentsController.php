<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Movie;
use App\Models\Reply;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentsController extends Controller
{
    public function add_comment(Request $request, $id)
    {

        $data = Movie::where('id', $id)->first();

        if (Auth::guard('customer')->id()) {

            $comment = new Comment();
            $comment->movie_id = $data->id;
            $comment->user_id = Auth::guard('customer')->user()->id;
            $comment->comment = $request->comment;
            $comment->created_at = Carbon::now('Asia/Ho_Chi_Minh');
            $comment->updated_at = Carbon::now('Asia/Ho_Chi_Minh');
            //dd($comment);
            $comment->save();
            return redirect()->back();
        } else {
            return redirect('/auth/login');
        }
    }
    public function add_reply(Request $request, $id)
    {
        $test = $request->commentId;
        $data = Movie::where('id', $id)->first();

        if (Auth::guard('customer')->id()) {

            $reply = new Comment();

            $reply->movie_id = $data->id;
            $reply->user_id = Auth::guard('customer')->user()->id;
            $reply->parent_id = $request->commentId;
            $reply->comment = $request->reply;
            $reply->created_at = Carbon::now('Asia/Ho_Chi_Minh');
            $reply->updated_at = Carbon::now('Asia/Ho_Chi_Minh');
            $reply->save();

            return redirect()->back();
        } else {
            return redirect('/auth/login');
        }
    }
    public function edit(Request $request){
        $comment=Comment::where('id',$request->comment_id)->first();
        $comment->comment=$request->comment;
        $comment->save();
    }
    public function destroy(Request $request){
        $comment=Comment::where('id',$request->comment_id)->first();
        $comment->status=0;
        $comment->save();
        //$comment->delete();
    }
}
