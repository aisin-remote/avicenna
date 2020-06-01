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
Route::group(['prefix' => 'v1'], function() {
    Route::group([
        'prefix' => 'auth',
    ], function () {
        Route::post('login', 'AuthController@login');

        Route::group(['middleware' => 'auth:api'], function() {
            Route::post('logout', 'AuthController@logout');
            Route::post('refresh', 'AuthController@refresh');
        });
    });

    Route::group(['middleware' => 'auth:api'], function() {
        Route::post('torimetron', 'TraceTorimetronController@store');
        Route::get('torimetron', 'TraceTorimetronController@index');
        Route::get('torimetron/{product}', 'TraceTorimetronController@show');
    });
});