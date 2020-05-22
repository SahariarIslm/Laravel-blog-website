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
});

//for favorite Post
Route::group(['middleware'=>['auth']],function(){
	Route::post('favorite/{post}/add','FavoriteController@add')->name('post.favorite');
});
