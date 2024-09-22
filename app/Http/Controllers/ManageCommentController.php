<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;

class ManageCommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('permission:view comment',['only'=>'index']);
        $this->middleware('permission:update comment',['only'=>'comment_status']);
        $this->middleware('permission:view reply',['only'=>'reply']);
        $this->middleware('permission:update comment',['only'=>'reply_status']);
    }
    public function index()
    {
        $list_comment = Comment::with('replies','movie:id,title','user:id,name')->whereNull('parent_id')->get();
        //dd($list_comment->toArray());
        return view('admincp.managecomment.index',compact('list_comment'));
    }
    public function reply()
    {
        $list_reply = Comment::with('replies','movie:id,title','user:id,name','replies.movie:id,title','replies.user:id,name')->whereNull('parent_id')->get();     
        //dd($list_reply->toArray());
        return view('admincp.managecomment.reply',compact('list_reply'));
          
    }
    public function comment_status(Request $request)
    {
        $data = $request->all();
        $movie = Comment::find($data['comment_id']);
        $movie->status = $data['commentstatus_val'];
        $movie->save();
    }
    public function reply_status(Request $request)
    {
        $data = $request->all();
        $movie = Comment::find($data['reply_id']);
        $movie->status = $data['replystatus_val'];
        $movie->save();
    }
}
