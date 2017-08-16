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


Route::get('/part',"CreateOpnameController@GetPart");
Route::post('/saveopname',"CreateOpnameController@SaveOpname");



Route::group(['middleware' => 'auth'], function () {
    //    Route::get('/link1', function ()    {
//        // Uses Auth Middleware
//    });
	Route::get('opname2',function(){
		return view('opname.CreateOpname');
	});
	Route::get('/opname',"CreateOpnameController@Opname");
    //Please do not remove this if you want adminlte:route and adminlte:link commands to works correctly.
    #adminlte_routes
});
