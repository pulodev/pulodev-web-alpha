<?php

use Illuminate\Support\Facades\Route;

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
    
    //thread
    Route::get('tulis', 'ThreadController@create');
    Route::post('tulis', 'ThreadController@store');
    Route::get('/{thread}/edit', 'ThreadController@edit');
    Route::put('/{thread}', 'ThreadController@update');

    //comment
    Route::post('comment/{id}', 'CommentController@store');
    Route::get('comment/{id}/edit', 'CommentController@edit');
    Route::put('comment/{id}', 'CommentController@update');
    Route::get('comment/{id}/delete', 'CommentController@destroy');

});

Route::get('/link/{link}', 'LinkController@show');
Route::get('/{thread}', 'ThreadController@show');


