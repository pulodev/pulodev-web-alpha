<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'PageController@index');
Route::get('/logout', 'UserController@logout');

//User
Route::get('/@{user}', 'UserController@show');

//User must verify email
Route::group(['middleware' => 'verified'], function(){
    //User
    Route::get('/user/edit', 'UserController@edit');
    Route::put('/user/update', 'UserController@update');
    Route::post('/user/upload/avatar', 'UserController@upload');

    Route::resource('link', 'LinkController')->except(['index', 'show' ]);

    Route::post('scrape', 'LinkController@scrape');
});

Route::group(['prefix' => 'admin',  'middleware' => 'admin'], function(){
    Route::get('/dashboard', 'AdminController@dashboard');
    Route::get('/logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
});


//Filter Content
Route::get('/search/', 'LinkController@search');
Route::get('/media/{query}', 'PageController@filterMedia');
Route::get('/tag/{query}', 'PageController@filterTag');


Route::get('/link/{link}', 'LinkController@show');


