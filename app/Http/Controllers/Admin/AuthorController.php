<?php

namespace App\Http\Controllers\Admin;

use Brian2694\Toastr\Facades\Toastr;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AuthorController extends Controller
{
    public function index(){
    	$authors = User::authors()
    		->withCount('posts')
    		->withCount('comments')
    		->withCount('favorite_posts')
    		->get();
    	return view('admin.authors',compact('authors'));
    }
    public function destroy($id){
    	$author = User::find($id)->delete();
    	Toastr::success('Author Successfully Deleted','Success');
    	return redirect()->back();
    }
}
