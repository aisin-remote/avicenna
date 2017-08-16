<?php

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

Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => 'auth'], function () {
    //    Route::get('/link1', function ()    {
//        // Uses Auth Middleware
//    });


	Route::get('/home', 'HomeController@index')->name('home');

	//dev-1.0, 20170816 by yudo, modul pis
	Route::get('/pis', 'PisController@index')->name('pis');
	Route::get('/pis/getAjaxMutation', 'PisController@getPisTransaction');
	Route::get('/pis/getAjaxImage/{image}', 'PisController@getAjaxImage');
	

	Route::post('/pis/insertMutation', 'PisController@insertMutation');
	//end of modul pis

    //Please do not remove this if you want adminlte:route and adminlte:link commands to works correctly.
    #adminlte_routes
});

