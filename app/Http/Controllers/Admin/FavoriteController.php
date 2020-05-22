<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Auth;
use App\Http\Controllers\Controller;

class FavoriteController extends Controller
{
    public function index(){
    	$posts = Auth::user()->favorite_posts;
    	return view('admin.favorite',compact('posts'));
    }
}
