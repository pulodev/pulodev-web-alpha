<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'PageController@index');
Route::get('/info/{page}', 'PageController@info');

//Auth
Route::get('/logout', 'UserController@logout');
Route::get('login/{provider}', 'SocialLoginController@redirectToProvider');
Route::get('login/{provider}/callback', 'SocialLoginController@handleProviderCallback');

//User
Route::get('/@{user}', 'UserController@show');

//User must verify email
Route::group(['middleware' => 'verified'], function(){
    //User
    Route::get('/user/edit', 'UserController@edit');
    Route::put('/user/update', 'UserController@update');
    Route::post('/user/upload/avatar', 'UserController@upload');

    Route::resource('link', 'LinkController')->except(['index', 'show' ]);
    Route::resource('resource', 'ResourceController')->except(['index', 'show' ]);

    Route::post('scrape', 'LinkController@scrape');
});

//Admin stuff
Route::group(['prefix' => 'admin',  'middleware' => 'admin'], function(){
    Route::get('/dashboard', 'AdminController@dashboard');
    Route::get('/dashboard/{type}', 'AdminController@show');
    Route::get('/logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');

    Route::delete('/link/bulk', 'AdminController@deleteBulk');
    Route::put('/link/bulk/publish', 'AdminController@publishBulk');
    Route::get('/rss/verify/{id}', 'AdminController@verifyRSS');
});


//Filter Content
Route::get('/search/', 'LinkController@search');
Route::get('/media/{query}', 'PageController@filterMedia');
Route::get('/tag/{query}', 'PageController@filterTag');
Route::get('/order/{query}', 'PageController@filterTime');


Route::get('/link/{link}', 'LinkController@show');


