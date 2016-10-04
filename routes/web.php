<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

use App\Models\Video;

Route::group(['middleware' => ['web']], function () {
    Route::get('/', function() {
        $videos = Video::select('id', 'user_id', 'name', 'views')
                                 -> orderBy('views', 'desc')
                                 -> take(10)
                                 -> get();
        //dd($videos);
        return view('index')->with('videos', $videos);
    });

    /* VideoController */
    Route::get('video/{movie_id}', 'VideoController@getPlayPage');
    Route::get('video/stream/{movie_id}', 'VideoController@stream');

    /* Auth\LoginController */
    Route::get('auth/login', 'Auth\LoginController@showLoginForm');
    Route::post('auth/login', 'Auth\LoginController@login');
    Route::get('auth/logout', 'Auth\LoginController@logout');
    Route::get('auth/register', 'Auth\RegisterController@showRegistrationForm');
    Route::post('auth/register', 'Auth\RegisterController@register');

    /* MyplaceController */
    Route::get('myplace', 'MyplaceController@index');
    Route::get('myplace/uploaded/{page_num}', 'MyplaceController@getUploaderVideosJsonForTable');
    Route::delete('myplace/uploaded/{video_id}', 'MyplaceController@deleteVideo');
    Route::post('myplace/upload', 'MyplaceController@upload');
});

