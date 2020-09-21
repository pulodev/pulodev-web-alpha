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

    //link
    Route::get('link', 'LinkController@create');
    Route::post('link', 'LinkController@store');
    Route::get('link/{link}/edit', 'LinkController@edit');
    Route::put('link/{link}', 'LinkController@update');

    Route::post('scrape', 'LinkController@scrape');


});

Route::get('/search/', 'LinkController@search');
Route::get('/link/{link}', 'LinkController@show');


