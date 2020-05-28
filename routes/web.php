<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/','HomeController@index')->name('home');


//for subscriber
Route::post('subscriber','SubscriberController@store')->name('subscriber.store');

Auth::routes();

//Route for admin middleware
Route::group(['as'=>'admin/','prefix'=>'admin','namespace'=>'Admin','middleware'=>['auth','admin']],function(){
	Route::get('/dashboard','DashboardController@index')->name('dashboard');
	Route::resource('tag','TagController');
	Route::resource('category','CategoryController');
	Route::resource('post','PostController');
	//for pending post
	Route::get('pending/post','PostController@pending')->name('post.pending');
	Route::put('/post/{id}/approve','PostController@approval')->name('post.approve');
	//for subscriber
	Route::get('/subscriber','SubscriberController@index')->name('subscriber.index');
	Route::delete('/subscriber/{subscriber}','SubscriberController@destroy')->name('subscriber.destroy');
	//for profile settings
	Route::get('settings','SettingsController@index')->name('settings');
	Route::put('profile-update','SettingsController@updateProfile')->name('profile.update');
	Route::put('password-update','SettingsController@updatePassword')->name('password.update');
	//for favorite Post
	Route::get('/favorite','FavoriteController@index')->name('favorite.index');
	//for comments
	Route::get('Comments/','CommentController@index')->name('comment.index');
	Route::delete('Comments/{id}','CommentController@destroy')->name('comment.destroy');
	//for Author List
	Route::get('authors','AuthorController@index')->name('author.index');
	Route::delete('authors/{id}','AuthorController@destroy')->name('author.destroy');
});
//Route for author middleware
Route::group(['as'=>'author/','prefix'=>'author','namespace'=>'Author','middleware'=>['auth','author']],function(){
	Route::get('/dashboard','DashboardController@index')->name('dashboard');
	Route::resource('post','PostController');
	//for profile settings
	Route::get('settings','SettingsController@index')->name('settings');
	Route::put('profile-update','SettingsController@updateProfile')->name('profile.update');
	Route::put('password-update','SettingsController@updatePassword')->name('password.update');
	//for favorite Post
	Route::get('/favorite','FavoriteController@index')->name('favorite.index');
	//for comments
	Route::get('Comments/','CommentController@index')->name('comment.index');
	Route::delete('Comments/{id}','CommentController@destroy')->name('comment.destroy');
});

//for favorite Post
Route::group(['middleware'=>['auth']],function(){
	Route::post('favorite/{post}/add','FavoriteController@add')->name('post.favorite');
	Route::post('comment/{post}','CommentController@store')->name('comment.store');
});
//for frontend single-post
Route::get('post/{slug}','PostController@details')->name('post.details');
//for all posts
Route::get('posts','PostController@index')->name('post.index');
// Post by Category
Route::get('category/{slug}','PostController@postByCategory')->name('category.posts');
// Post by Tag
Route::get('tag/{slug}','PostController@postByTag')->name('tag.posts');
//for footer categories
View::composer('layouts.frontend.partial.footer',function($view){
	$categories = App\Category::all();
	$view->with('categories',$categories);
});
//for search
Route::get('/search','SearchController@search')->name('search');
// Post by Author
Route::get('profile/{username}','AuthorController@profile')->name('author.profile');