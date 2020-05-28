<?php

namespace App\Http\Controllers;
use App\Comment;
use Illuminate\Support\Facades\Auth;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request,$post){
    	$this->validate($request,[
    		'comment'=> 'required'
    	]);
    	$comment = new Comment();
    	$comment->user_id = Auth::id();
    	$comment->post_id = $post;
    	$comment->comment = $request->comment;
    	$comment->save();
    	Toastr::success('Comment Successfully Published :)','Success');
    	return redirect()->back();
    }
}
