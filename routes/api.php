<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login', 'Api\AuthController@login');

Route::middleware('auth:api')->group(function () {
    Route::get('me', 'Api\AuthController@user');
    Route::post('link', 'Api\LinkController@store');
    Route::get('resources', 'Api\ResourceController@get');
});