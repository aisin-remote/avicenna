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

// dev-1.1.0, Ferry, 20190103, Tanpa otentikasi
Route::get('/avicenna/stock/mutation',"Avicenna\StockMutationController@getView");
Route::get('/avicenna/stock/mutation/ajax/getHeader','Avicenna\StockMutationController@getAjaxHeader');
Route::get('/avicenna/stock/mutation/ajax/getDetailHead/{part_number}','Avicenna\StockMutationController@getAjaxDetailHead');
Route::get('/avicenna/stock/mutation/filter/{start_date}/{end_date}','Avicenna\StockMutationController@getAjaxFilter');
Route::get('/avicenna/stock/mutation/ajax/getDetailFilter/{part_number}/{start_date}/{end_date}','Avicenna\StockMutationController@getAjaxDetailFilter');

// dev-1.1.0, Ferry, 20190103, Dengan otentikasi
Route::group(['middleware' => ['auth', 'role.menu', 'role.load']], function () {
    //    Route::get('/link1', function ()    {
	//        // Uses Auth Middleware
	//    });

	// dev-1.0, Ferry, 20170830, Route AISYA ==========================================================
	// Route::get('/', 'HomeController@choose');
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
	// dev-1.0, Ferry, 20170830, Route PIS ============================================================
	Route::get('/pis', 'PisController@index')->name('pis');
	Route::get('/pis/packing', 'PisController@packing')->name('packing');
	// dev-1.0, Ferry, 20170822, Merged
	Route::get('/pis/master', 'PisController@PisMasterView'); //dev-1.0, 20170926, view master pis
	Route::get('/pis/add', 'PisController@add_new_part'); //dev-1.0, 20171018, add part no
	Route::get('/pis/preview/{img}', 'PisController@PisPreview'); //dev-1.0, 20170926, view 
	Route::get('/pis/edit/{id}', 'PisController@UpdatePis'); //dev-1.0, 20170926, view update pis
	Route::get('/pis/update/{id}', 'PisController@UpdatePisProses'); //dev-1.0, 20170926, view update pis
	Route::post('/updatepis','PisController@UpdatePisProses');
	Route::post('/pis/search','PisController@PisSearch');
	Route::get('/pis/getAjaxImage/{image}/{type}/{dock}', 'PisController@getAjaxImage');
	Route::post('/pis/add', 'PisController@AddNewPis'); //dev-1.0, 20170926, view master pis
	Route::get('/pis/add', 'PisController@AddNewPis');
	Route::post('/pis/addpis', 'PisController@addpis');
	Route::post('/pis/addpart', 'PisController@addpart');
	Route::get('pis/validasi/', 'PisController@validasi'); //dev-1.0, 20171031, validasi
	Route::get('/getajaxpartPis','PisController@GetAjaxPartPis');


	//end of modul pis

	// dev-1.0, Ario, 20171010, Route Part Master
	Route::get('/part/master','PartController@index');
	Route::post('/part/master','PartController@AddNewParts');
	Route::get('/part/edit/{id}', 'PartController@UpdateParts'); //dev-1.0, 20170926, view update pis
	Route::post('/updatepart','PartController@UpdatePartProses');
	

	
	// dev-1.0, Ferry, 20170830, Route DASHBOARD ======================================================
	//dev-1.0, by Yudo, 20170824, Dashboard
	Route::get('/dashboard/viewDashboardMutation', 'PisController@viewDashboardMutation');
	Route::get('/dashboard/getAjaxMutation', 'PisController@getAjaxMutation');
	Route::get('/dashboard/viewDashboardGenba', 'DashboardController@viewDashboardGenba'); //dev-1.0, 20170904, view genba
	Route::get('/dashboard/getAjaxGenba', 'DashboardController@getAjaxGenba'); //dev-1.0, 20170904, ajax genba
	Route::get('/dashboard/viewDashboardModel', 'DashboardController@viewDashboardModel'); //dev-1.0, 20170905, view Model
	Route::get('/dashboard/getAjaxModel', 'DashboardController@getAjaxModel'); //dev-1.0, 20170905, ajax Model

	Route::get('/dashboard/andon', 'DashboardController@andon'); //dev-1.0, 20180416, Andon Monitoring
	//end of dashboard
	

	// dev-1.0, Handika, 20180707, Route Production Report =========================================================================

	Route::get('/production/report', 'ProductionReportController@index');
	Route::get('/production/report/getindex', 'ProductionReportController@getindex');
	Route::post('/production/report/filter', 'ProductionReportController@filter');
	Route::post('/production/report/export', 'ProductionReportController@exportexcel');



	// End of Route Production Report ==============================================================================================

	// dev-1.0, Handika, 20180702, Route TRACEBILITY =========================================================================

	// view trace product
	Route::get('/trace/view/part', 'ViewTraceController@index');
	Route::get('/trace/view/part/search/{barcode}', 'ViewTraceController@search');
	Route::get('/trace/view/part/index', 'ViewTraceController@getAjaxIndex');
	Route::get('/trace/view/part/{id_product}', 'ViewTraceController@getAjaxData');
	Route::get('/trace/view/product/{id_product}', 'ViewTraceController@getAjaxProduct');

	//dev-1.1.0, Audi, 20180702 View Trace List
	Route::get('/trace/view/list', 'TraceListController@index');
	Route::get('/trace/view/listout', 'TraceListController@indexout');
	Route::get('/trace/view/list', 'TraceListController@indexout');
	Route::get('/trace/view/list/all', 'TraceListController@getDataAll');
	Route::get('/trace/view/list/casting', 'TraceListController@getAjaxDataCasting');
	Route::get('/trace/view/list/machining', 'TraceListController@getAjaxDataMachining');
	Route::get('/trace/view/list/delivery', 'TraceListController@getAjaxDataPulling');
	// =====================================================================================================================
	// view delivered product
	Route::get('/trace/view/delivered', 'ViewDeliveryController@index');
	Route::get('/trace/view/delivered/data', 'ViewDeliveryController@getAjaxData');
	Route::get('/trace/view/delivered/filter/{date}', 'ViewDeliveryController@getAjaxFilter');

	//SCAN PART
		//Casting
	Route::get('/trace/scan/casting/{line}', 'TraceScanController@scancasting');
	Route::get('/trace/scan/casting/getAjax/{number}/{line}', 'TraceScanController@getAjaxcasting');
	Route::get('/trace/scan/casting/getAjax2', 'TraceScanController@getAjax2');
	Route::get('/trace/casting/index', 'TraceScanController@getAjaxcastingtable');
	Route::get('/trace/casting/update', 'TraceScanController@getAjaxcastingupdate');
		//NG Casting
	Route::get('/trace/scan/casting/ng/{line}', 'TraceScanController@castingng');
	Route::get('/trace/scan/casting/ng/{id_product}/{date}/{line}', 'TraceScanController@getAjaxcastingng');
	Route::get('/trace/scan/casting/getDatacastingng', 'TraceScanController@getDatacastingng');

		//Machining
	Route::get('/trace/scan/machining/{line}', 'TraceScanController@scanmachining');
	Route::get('/trace/scan/machining/getAjax/{number}/{line}', 'TraceScanController@getAjaxmachining');
	// Route::get('/trace/scan/machining/getAjax2', 'TraceScanController@getAjax2');
	Route::get('/trace/machining/index', 'TraceScanController@getAjaxmachiningtable');
	Route::get('/trace/machining/update', 'TraceScanController@getAjaxmachiningupdate');
		//NG Machining
	Route::get('/trace/scan/machining/ng/{line}', 'TraceScanController@machiningng');
	Route::get('/trace/scan/machining/getAjax2', 'TraceScanController@getAjaxmachiningng');

		//Delivery
	Route::get('/trace/scan/delivery', 'TraceScanController@scandelivery');
	Route::get('/trace/scan/delivery/getAjax/{number}/{wimcycle}/{customer}', 'TraceScanController@getAjaxdelivery');
	Route::get('/trace/scan/delivery/getAjaxcycle/{code}', 'TraceScanController@getAjaxcycle');
	Route::get('/trace/logout', 'Auth\LoginController@logout');

		//NG Delivery
	Route::get('/trace/scan/delivery/ng', 'TraceScanController@scandeliveryng');
	Route::get('/trace/scan/delivery/getAjaxng/{number}', 'TraceScanController@getAjaxdeliveryng');
	Route::get('/trace/delivery/ng/index', 'TraceScanController@getAjaxdeliveryngtable');
	Route::get('/trace/delivery/ng/update', 'TraceScanController@getAjaxdeliveryngupdate');


});

	//end of tracebility ====================================================================================================

    //Please do not remove this if you want adminlte:route and adminlte:link commands to works correctly.
    #adminlte_routes
// });

//Dandori Page===============================================================
Route::get('/dandori/make/{line_number}','CreateDandoriController@viewpage');
Route::post('/dandori/make','CreateDandoriController@Create');
Route::get('/dandori/quantity','CreateDandoriController@GetQuantityRunningModel');
//End Dandori Page ============================================================================

//Unit Plant Dashboard=======================================================
Route::get('/dashboard/unittools','Avicenna\UnitDashboardController@viewpage');
Route::get('/dashboard/dataunittools','Avicenna\UnitDashboardController@getAjaxData');
Route::get('/dashboard/datatools/{id_mesin}','Avicenna\UnitDashboardController@getAjaxMesin');
Route::get('/dashboard/datatools2/{id_mesin}','Avicenna\UnitDashboardController@getAjaxMesin2');

//End Unit Plant Dashboard


//Dashboard andon
Route::get('/', 'DashboardController@choose');
Route::get('/direct/andon', 'DashboardController@direct_andon')->name('direct.andon'); //dev-1.0, 20180416, Andon Monitoring
Route::get('/direct/andon2', 'DashboardController@direct_andon2')->name('direct.andon2'); //dev-1.0, 20180416, Andon Monitoring
Route::get('/direct/line', 'DashboardController@direct_line')->name('direct.line'); //dev-1.0.0, 20180416, Handika, dashboard line status
Route::get('/direct/line/index', 'DashboardController@direct_line_index')->name('direct.line'); //dev-1.0.0, 20180416, Handika, dashboard line status

//List Traceability

	// view trace product
	Route::get('/trace/view/part', 'ViewTraceController@index');
	Route::get('/trace/view/part/search/{barcode}', 'ViewTraceController@search');
	Route::get('/trace/view/part/searchout/{barcode}', 'ViewTraceController@searchout');
	Route::get('/trace/view/part/index', 'ViewTraceController@getAjaxIndex');
	Route::get('/trace/view/part/{id_product}', 'ViewTraceController@getAjaxData');
	Route::get('/trace/view/product/{id_product}', 'ViewTraceController@getAjaxProduct');

	//dev-1.1.0, Audi, 20180702 View Trace List
	

	Route::get('/trace/reportdetail/list/{type}', 'TraceReportController@index');
	Route::get('/trace/reportdetail/casting', 'TraceReportController@castingAjaxdata');
	Route::get('/trace/reportdetail/machining', 'TraceReportController@machiningAjaxdata');
	Route::get('/trace/reportdetail/delivery', 'TraceReportController@deliveryAjaxdata');

	//export detail - Machining
	Route::get('/trace/reportdetail/list/machining/filter/{start_date}/{end_date}','TraceReportController@getAjaxFilterMachiningDetail');
	//export detail - Casting
	Route::get('/trace/reportdetail/list/casting/filter/{start_date}/{end_date}','TraceReportController@getAjaxFilterCastingDetail');

	//Export
	Route::get('/trace/report/list/{barcode}', 'TraceReportController@traceviewreport');

	//trial
	Route::get('/andon/view', 'AndonTrial@index');
	Route::get('/andon/view/list', 'AndonTrial@getData');
	Route::get('/andon/view/status', 'AndonTrial@getStatus');
	// Route::get('/andon/view/list/all', 'DashboardController@getDataAll');