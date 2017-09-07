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

Route::group(['middleware' => ['auth', 'role.menu', 'role.load']], function () {
    //    Route::get('/link1', function ()    {
	//        // Uses Auth Middleware
	//    });

	// dev-1.0, Ferry, 20170830, Route AISYA ==========================================================
	Route::get('/', 'HomeController@index');
	Route::get('/home', 'HomeController@index');
	//
	//
	//
	// dev-1.0, Ferry, 20170830, Route STOCK OPNAME ===================================================
	Route::get('opname2',function(){
		return view('opname.CreateOpname');
	}); // Dev-10, Alliq, 20170816, Route untuk tampil page stock opname di luar folder adminlte
	Route::get('/opname',"CreateOpnameController@Opname"); // Dev-10, Alliq, 20170816, Route untuk tampil page stock opname di dalam folder adminlte
	Route::get('/getajaxpart',"CreateOpnameController@GetAjaxPart");
	Route::post('/saveopname',"CreateOpnameController@SaveOpname");
	//
	//
	//
	// dev-1.0, Ferry, 20170830, Route PIS ============================================================
	Route::get('/pis', 'PisController@index')->name('pis');
	// dev-1.0, Ferry, 20170822, Merged
	Route::get('/pis/getAjaxImage/{image}', 'PisController@getAjaxImage');
	//end of modul pis
	//
	//
	//
	// dev-1.0, Ferry, 20170830, Route DASHBOARD ======================================================
	//dev-1.0, by Yudo, 20170824, Dashboard
	Route::get('/dashboard/viewDashboardMutation', 'PisController@viewDashboardMutation');
	Route::get('/dashboard/getAjaxMutation', 'PisController@getAjaxMutation');
	Route::get('/dashboard/viewDashboardGenba', 'DashboardController@viewDashboardGenba'); //dev-1.0, 20170904, view genba
	Route::get('/dashboard/getAjaxGenba', 'DashboardController@getAjaxGenba'); //dev-1.0, 20170904, ajax genba
	Route::get('/dashboard/viewDashboardModel', 'DashboardController@viewDashboardModel'); //dev-1.0, 20170905, view Model
	Route::get('/dashboard/getAjaxModel', 'DashboardController@getAjaxModel'); //dev-1.0, 20170905, ajax Model
	//end of dashboard
	
    //Please do not remove this if you want adminlte:route and adminlte:link commands to works correctly.
    #adminlte_routes
});

