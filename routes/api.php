<?php

use Illuminate\Http\Request;
use App\Helpers\RoleHelper;

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
Route::get('/auth/jwt/renew', 'AuthController@getRefresh');
Route::get('/auth/jwt/refresh', 'AuthController@getRefresh');

Route::middleware(["auth:web,jwt"])->prefix("/data")->group(function() {
    Route::get('/airport/{icao?}','DataController@getAirport');
    Route::get('/route/{id?}','DataController@getRoute');

    Route::prefix("/airport")
        ->middleware(['role:' . RoleHelper::roleForAction("airport")])
        ->group(function() {
            Route::post("{icao}", "DataController@postAirport");
            Route::delete("{icao}", "DataController@deleteAirport");
    });
    Route::prefix("/route")
        ->middleware(["role:" . RoleHelper::roleForAction("route")])
        ->group(function() {
            Route::post("{id?}", "DataController@postRoute");
            Route::delete("{id}", "DataController@deleteRoute");
    });
});

Route::group(['prefix' => '/dispatch', 'middleware' => 'auth:web,jwt'], function() {
    Route::get('bookings/{id?}', 'DispatchController@getBooking');
    Route::post("bookings", "DispatchController@postBooking");
    Route::delete("bookings/{id}", "DispatchController@deleteBooking");
});

Route::group(['prefix' => '/user', 'middleware' => 'auth:web,jwt'], function() {
    Route::get('/', 'UserController@getUser');
    Route::group(['middleware' => 'role:HR'], function() {
        Route::get('/{id}', 'UserController@getUser');
        Route::get('/{callsign}', 'UserController@getUserByCallsign');
    });
});
