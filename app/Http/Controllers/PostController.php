<?php

namespace App\Http\Controllers;

use App\Post;
use App\Tag;
use App\Category;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PostController extends Controller
{
	public function index(){
		$posts = Post::latest()->approved()->published()->paginate(6);
		return view('posts',compact('posts'));
	}
    public function details($slug){
    	$post = Post::where('slug',$slug)->approved()->published()->first();
    	$blogKey='blog_'.$post->id;
    	if (!Session::has($blogKey)) {
    		$post->increment('view_count');
    		Session::put($blogKey,1);
    	}
    	$randomposts = Post::approved()->published()->take(3)->inRandomOrder();
    	return view('post',compact('post','randomposts'));
    }
    public function postByCategory($slug){
        $category = Category::where('slug',$slug)->first();
        $posts = $category->posts()->approved()->published()->get();
        return view('postsByCat',compact('posts','category'));
    }
    public function postByTag($slug){
        $tag = Tag::where('slug',$slug)->first();
        $posts = $tag->posts()->approved()->published()->get();
        return view('postsByTag',compact('posts','tag'));
    }

}
