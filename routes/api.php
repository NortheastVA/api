<?php

use Illuminate\Http\Request;

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

Route::get('/auth/login', 'AuthController@getLogin');
Route::get('/auth/logout', 'AuthController@getLogout');
Route::get('/auth/jwt/renew', 'AuthController@getRenew');
Route::get('/auth/jwt/refresh', 'AuthController@getRefresh');

Route::middleware(["auth:web,jwt"])->prefix("/data")->group(function() {
    Route::get('/airport/{icao}','DataController@getAirport');
    Route::get('/route/{id?}','DataController@getRoute');
});
