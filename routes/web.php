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
        return view('index')->with('videos', $videos);
    });

    /* VideoController */
    Route::get('video/{movie_id}', 'VideoController@getPlayPage');
    Route::get('video/stream/{movie_id}', 'VideoController@stream');
	Route::get('video/thumbnail/{movie_id}', 'VideoController@thumbnail');

    /* Auth */
    Route::get('login', 'Auth\LoginController@showLoginForm');
    Route::post('login', 'Auth\LoginController@login');
    Route::get('logout', 'Auth\LoginController@logout');
    Route::get('register', 'Auth\RegisterController@showRegistrationForm');
    Route::post('register', 'Auth\RegisterController@register');
    Route::get('user/activation/{token}', 'Auth\RegisterController@activateUser')->name('user.activate');
    Route::get('password/forgot', 'Auth\ForgotPasswordController@showLinkRequestForm');
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
    Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset');

    /* MyplaceController */
    Route::get('myplace', 'MyplaceController@index');
    Route::get('myplace/uploaded/{page_num}', 'MyplaceController@getUploaderVideosJsonForTable');
    Route::delete('myplace/uploaded/{video_id}', 'MyplaceController@deleteVideo');
    Route::post('myplace/upload', 'MyplaceController@upload');

    /* Profile */
    Route::get('user/{user_id}', 'ProfileController@getProfile');

    /* Search */
    Route::get('search', 'SearchController@getResult');
});

