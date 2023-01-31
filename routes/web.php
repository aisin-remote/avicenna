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

// API
Route::get('/trace/api/getqty/{line}/{time_start}/{time_end}', 'Avicenna\Api\ApiController@getQty');

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
	Route::get('/trace/view/filter', 'TraceListController@indexFilter');
	Route::get('/trace/view/list', 'TraceListController@indexout');
	Route::get('/trace/view/list/all', 'TraceListController@getDataAll');
	Route::get('/trace/view/list/casting', 'TraceListController@getAjaxDataCasting');
	Route::get('/trace/view/list/machining', 'TraceListController@getAjaxDataMachining');
	Route::get('/trace/view/list/assembling', 'TraceListController@getAjaxDataAssembling');
	Route::get('/trace/view/list/delivery', 'TraceListController@getAjaxDataPulling');
		// view delivered product
	Route::get('/trace/view/delivered', 'ViewDeliveryController@index');
	Route::get('/trace/view/delivered/data', 'ViewDeliveryController@getAjaxData');
	Route::get('/trace/view/delivered/filter/{date}', 'ViewDeliveryController@getAjaxFilter');



		//SCAN PART
		//Casting Dowa
	Route::get('/trace/scan/casting/dowa', 'TraceScanController@scanCastingDowa');
	Route::get('/trace/scan/casting/dowa/check-code', 'TraceScanController@checkCodeCastingDowa');
	Route::get('/trace/scan/casting/dowa/input-code', 'TraceScanController@inputCodeCastingDowa');
		//Casting
	Route::get('/trace/scan/casting/', 'TraceScanController@scancasting');

	// update by fabian 01232023 || part d98e
	Route::get('/trace/scan/casting/d98e', 'TraceScanController@scancastingd98e');
	Route::get('/trace/scan/casting/cek-part-d98e', 'TraceScanController@cekPartD98e');
	Route::get('/trace/scan/casting/ajaxCastingD98e', 'TraceScanController@getAjaxCastingD98e');

	Route::get('/trace/scan/casting/getAjax/{number}/{line}', 'TraceScanController@getAjaxcasting');
	Route::get('/trace/scan/casting/getAjax2', 'TraceScanController@getAjax2');
	Route::get('/trace/casting/index', 'TraceScanController@getAjaxcastingtable');
	Route::get('/trace/casting/update', 'TraceScanController@getAjaxcastingupdate');

		//NG Casting
	Route::get('/trace/scan/casting/ng', 'TraceScanController@castingng');
	Route::get('/trace/scan/casting/ng2', 'TraceScanController@castingng2');
	Route::get('/trace/scan/casting/getPartNg/{part}', 'TraceScanController@getPartCastingNg');
	Route::get('/trace/scan/casting/inputPartNg/{part}/{ng}', 'TraceScanController@inputPartCastingNg');
	Route::get('/trace/scan/casting/getLine/{part}', 'TraceScanController@getLineCasting');


		//Machining
	Route::get('/trace/scan/machining/getAjax/{number}/{line}/{strainer}', 'TraceScanController@getAjaxmachining');
	Route::get('/trace/scan/machining', 'TraceScanController@scanmachining');
	Route::get('/trace/machining/index', 'TraceScanController@getAjaxmachiningtable');
	Route::get('/trace/machining/update', 'TraceScanController@getAjaxmachiningupdate');
		//FG Machining
	Route::get('/trace/scan/machining/fg-machining', 'TraceScanController@machiningfg');
	Route::get('/trace/machining/cek-part', 'TraceScanController@cekCodePart');
	Route::get('/trace/scan/machining/check-fg/{line}', 'TraceScanController@checkmachiningfg');
	Route::get('/trace/scan/machining/AjaxFG', 'TraceScanController@getAjaxmachiningfg');
		//NG FG Machining
	Route::get('/trace/scan/machining/fg-machining-ng', 'TraceScanController@machiningng');
	Route::post('/trace/scan/machining/fg-machining-ng/Ajax', 'TraceScanController@machiningfgngAjax')->name('machining-fg-ng-Ajax');
	Route::get('/trace/machining/fg-machining-update', 'TraceScanController@getAjaxmachiningng');

	Route::get('/trace/scan/machining/getPartNg/{part}', 'TraceScanController@getPartMachiningNg');
	Route::get('/trace/scan/machining/inputPartNg/{part}/{ng}/{line}', 'TraceScanController@inputPartMachiningNg');



		//Delivery Dowa
	Route::get('/trace/scan/delivery/dowa', 'TraceScanController@scanDeliveryDowa');
	Route::get('/trace/scan/delivery/dowa/check-code', 'TraceScanController@checkCodeDeliveryDowa');
	Route::get('/trace/scan/delivery/dowa/input-code', 'TraceScanController@inputCodeDeliveryDowa');


		//Delivery D98
	Route::get('/trace/scan/delivery/d98', 'TraceScanController@scanDeliveryD98');
	Route::get('/trace/scan/delivery/d98/check-code', 'TraceScanController@checkCodeDeliveryD98');
	Route::get('/trace/scan/delivery/d98/input-code', 'TraceScanController@inputCodeDeliveryD98');

		//Torimetron Dowa
	Route::get('/trace/scan/torimetron', 'TraceScanController@scanTorimetron');
	Route::get('/trace/scan/torimetron/check-code', 'TraceScanController@checkCodeTorimetron');
	Route::get('/trace/scan/torimetron/input-code', 'TraceScanController@inputCodeTorimetron');
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



		//Assembling
	Route::get('/trace/scan/assembling/', 'TraceScanController@scanassembling');
	Route::get('/trace/scan/assembling/getAjax/{number}/{line}', 'TraceScanController@getAjaxassembling');
	Route::get('/trace/assembling/index', 'TraceScanController@getAjaxassemblingtable');
	Route::get('/trace/assembling/update', 'TraceScanController@getAjaxassemblingupdate');

		//Assembling-Ariansyah 10/2/2021
	Route::get('/trace/scan/assembling/fg-assembling', 'TraceScanController@assemblingfg');
	Route::get('/trace/assembling/cek-part', 'TraceScanController@cekCodePart2');
	Route::get('/trace/scan/assembling/check-fg/{line}', 'TraceScanController@checkassemblingfg');
	Route::get('/trace/scan/assembling/AjaxFG', 'TraceScanController@getAjaxassemblingfg');
		//NG FG Assembling
	Route::get('/trace/scan/assembling/fg-assembling-ng', 'TraceScanController@assemblingng');
	Route::get('/trace/scan/assembling/getPartNg/{part}', 'TraceScanController@getPartAssemblingNg');
	Route::get('/trace/scan/assembling/inputPartNg/{part}/{ng}/{line}', 'TraceScanController@inputPartAssemblingNg');


	Route::get('/trace/scan/assembling/fg-double', 'TraceScanController@assemblingfgdouble');
	Route::get('/trace/assembling/cek-part-double', 'TraceScanController@cekCodePartDouble');
	Route::get('/trace/scan/assembling/AjaxFGDouble', 'TraceScanController@getAjaxassemblingfgDouble');

	// Traceability back office
		//Traceability Stock
	Route::get('/trace/stock/index', 'Avicenna\TraceStockController@index')->name('trace.stock.index');
	Route::get('/trace/stock/filter/{start}/{end}/{product}', 'Avicenna\TraceStockController@filter')->name('trace.stock.filter');

	Route::get('/trace/export-collection', 'TraceReportController@exportCollectionIndex')->name('trace.export-collection');
	Route::get('/trace/export-collection/generate', 'TraceReportController@exportCollection')->name('trace.export-collection.generate');
	Route::get('/trace/export-collection/generateKanban', 'TraceReportController@exportCollectionKanban')->name('trace.export-collection.generateKanban');

		//Strainer
	Route::get('/trace/view/strainer', 'Avicenna\StrainerController@index');
	Route::get('/trace/view/strainer/getData', 'Avicenna\StrainerController@getDataStrainer');
	Route::get('/trace/view/strainer/create', 'Avicenna\StrainerController@create');
	Route::get('/trace/view/strainer/delete/{id}', 'Avicenna\StrainerController@destroy');
	Route::get('/trace/scan/machining/getStrainerMachining/{line}', 'Avicenna\StrainerController@getStrainerMachining');

		//Registrasi Kanban
	Route::get('/trace/regis-kanban', 'Avicenna\RegisController@index');
	Route::get('/trace/regis-kanban/tambah', 'Avicenna\RegisController@tambah')->name('tambah');
	Route::post('/trace/regis-kanban/tambah-ajax', 'Avicenna\RegisController@tambahAjax')->name('tambah-ajax');
	Route::get('/trace/regis-kanban/getData', 'Avicenna\RegisController@getData');
	Route::get('/trace/regis-kanban/delete/{id}', 'Avicenna\RegisController@destroy');
	Route::get('/manual-delivery-view', 'Avicenna\RegisController@manualDeliveryView');
	Route::post('/manual-delivery', 'Avicenna\RegisController@manualDelivery')->name('manual-delivery');

		//Reset Kanban Part NG
	Route::get('/reset-kanban-partng-View-MA', 'Avicenna\ResetController@resetngViewMA');
	Route::post('/reset-kanban-partng-MA', 'Avicenna\ResetController@resetngMA')->name('reset-ng-MA');
	Route::get('/reset-kanban-partng-View-AS', 'Avicenna\ResetController@resetngViewAS');
	Route::post('/reset-kanban-partng-AS', 'Avicenna\ResetController@resetngAS')->name('reset-ng-AS');


	// NG Master
	Route::get('/trace/ng/view', 'Avicenna\NgController@index')->name('trace.ng.view');

	// update by fabian 12272022 || get data by line,model,dies, and month
	Route::get('/trace/ng/view/getData/{line}/{model}/{dies}/{month}', 'Avicenna\NgController@getData')->name('trace.ng.view.getData');
	Route::get('/trace/ng/view/getDataChart', 'Avicenna\NgController@getDataChart')->name('trace.ng.view.getDataChart');
	Route::get('/trace/ng/view/exportData/{line}/{model}/{dies}/{month}', 'Avicenna\NgController@exportData')->name('trace.ng.view.exportData');
	// end update

	// OK Master
	Route::get('/trace/ok/view', 'Avicenna\DashboardController@index')->name('trace.ng.view');
	Route::get('/trace/ok/view/getData/{area}/{start}/{end}', 'Avicenna\DashboardController@getData')->name('trace.ng.view.getData');
	Route::post('/trace/ok/view/getDataChart', 'Avicenna\DashboardController@getDataChart')->name('trace.ng.view.getDataChart');
	Route::get('/trace/ok/view/exportData/{area}/{start}/{end}', 'Avicenna\DashboardController@exportData')->name('trace.ng.view.exportData');


	
	//end of tracebility ====================================================================================================



});

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

Route::get('direct/andon/problem', 'DashboardController@directAndonProblem')->name('direct.andon.problem'); //dev-1.0, 20180416, Andon Monitoring
Route::get('/', 'DashboardController@choose');
Route::get('/direct/andon', 'DashboardController@direct_andon')->name('direct.andon'); //dev-1.0, 20180416, Andon Monitoring
Route::get('/direct/andon2', 'DashboardController@direct_andon2')->name('direct.andon2'); //dev-1.0, 20180416, Andon Monitoring
Route::get('/direct/line', 'DashboardController@direct_line')->name('direct.line'); //dev-1.0.0, 20180416, Handika, dashboard line status
Route::get('/direct/line/index', 'DashboardController@direct_line_index')->name('direct.line'); //dev-1.0.0, 20180416, Handika, dashboard line status
Route::get('/direct/andoncharts', 'DashboardController@andon_charts')->name('direct.andoncharts'); //dev-1.0, 20180416, Andon Monitoring

Route::get('/direct/mobileline', 'DashboardController@direct_line')->name('direct.mobileline'); //dev-1.0.0, 20180416, Handika, dashboard line status
//List Traceability

// view trace product
Route::get('/trace/view/part', 'ViewTraceController@index');
Route::get('/trace/view/part/search/{barcode}', 'ViewTraceController@search');
Route::get('/trace/view/part/searchout/{barcode}', 'ViewTraceController@searchout');
Route::get('/trace/view/part/index', 'ViewTraceController@getAjaxIndex');
Route::get('/trace/view/part/{id_product}', 'ViewTraceController@getAjaxData');
Route::get('/trace/view/product/{id_product}', 'ViewTraceController@getAjaxProduct');
Route::get('/trace/view/product/dowa/{id_product}', 'ViewTraceController@getAjaxProductDowa');

//dev-1.1.0, Audi, 20180702 View Trace List

Route::get('/trace/reportdetail/list/{type}', 'TraceReportController@index');
Route::get('/trace/reportdetail/casting', 'TraceReportController@castingAjaxdata');
Route::get('/trace/reportdetail/machining', 'TraceReportController@machiningAjaxdata');
Route::get('/trace/reportdetail/assembling', 'TraceReportController@assemblingAjaxdata');
Route::get('/trace/reportdetail/delivery', 'TraceReportController@deliveryAjaxdata');

//export detail - Machining
Route::get('/trace/reportdetail/list/machining/filter/{start_date}/{end_date}','TraceReportController@getAjaxFilterMachiningDetail');
//export detail - Assembling
Route::get('/trace/reportdetail/list/assembling/filter/{start_date}/{end_date}','TraceReportController@getAjaxFilterAssemblingDetail');
//export detail - Casting
Route::get('/trace/reportdetail/list/casting/filter/{start_date}/{end_date}','TraceReportController@getAjaxFilterCastingDetail');
//export detail - Delivery
Route::get('/trace/reportdetail/list/delivery/filter/{start_date}/{end_date}','TraceReportController@getAjaxFilterDeliveryDetail');
//Export
Route::get('/trace/report/list/{barcode}', 'TraceReportController@traceviewreport');

Route::get('/trace/export/part', 'TraceListController@tracepartreport'); //dev-1.1.0, Audi 20190218, Export Part
Route::get('/tmmin', 'TraceListController@tracepartreport');

// dev-1.1.0: Ferry, merging test untuk koneksi ke MSSQL
Route::get('/test', 'HomeController@test');

	// dev-1.1.0, Ferry, 20190315, Menangani semua IoT
	Route::group(['middleware' => ['auth', 'role.menu', 'role.load'], 'prefix'	=> 'iot'], function () {

		Route::get('/prodplan', 'Avicenna\IoTController@showProdPlan');
		Route::post('/prodplan', 'Avicenna\IoTController@verifyProdPlan');
	});
