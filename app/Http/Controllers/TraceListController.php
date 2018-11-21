<?php

namespace App\Http\Controllers;
use App\Models\Avicenna\avi_trace_program_number;
use App\Models\Avicenna\avi_trace_machining;
use App\Models\Avicenna\avi_trace_casting;
use App\Models\Avicenna\avi_trace_delivery;
use Yajra\Datatables\Datatables;
use Carbon\Carbon;
use Response;
use DB;

use Illuminate\Http\Request;

class TraceListController extends Controller
{
    function index(){
		return view('tracebility.list.index');
	}
	function getAjaxDataCasting(){

	$list 			= avi_trace_casting::select('*');

	return Datatables::of($list)
			->addColumn('part_number', function($list) {

							$codes 	= $list->code ;
							$code 	= substr($list->code, 0, 2);
							$models	= avi_trace_program_number::select('part_number')->where('code', $code)->first();
			            	return $models ? $models->part_number : '--No Part Number--';
			            })
			->addColumn('back_number', function($list)  {

							$codes 	= $list->code ;
							$code 	= substr($list->code, 0, 2);
							$models	= avi_trace_program_number::select('back_number')->where('code', $code)->first();
			            	return $models ? $models->back_number : '--No Back Number--';
			            })
			->addColumn('part_name', function($list) {

							$codes 	= $list->code ;
							$code 	= substr($list->code, 0, 2);
							$models	= avi_trace_program_number::select('part_name')->where('code', $code)->first();
			            	return $models ? $models->part_name : '--No Part Name--';
			            })

	        ->addIndexColumn()
	        ->make(true);
		
	}
	function getAjaxDataMachining(){

	$list 			= avi_trace_machining::select('*');

	return Datatables::of($list)
			->addColumn('part_number', function($list) {

							$codes 	= $list->code ;
							$code 	= substr($list->code, 0, 2);
							$models	= avi_trace_program_number::select('part_number')->where('code', $code)->first();
			            	return $models ? $models->part_number : '--No Part Number--';
			            })
			->addColumn('back_number', function($list){

							$codes 	= $list->code ;
							$code 	= substr($list->code, 0, 2);
							$models	= avi_trace_program_number::select('back_number')->where('code', $code)->first();
			            	return $models ? $models->back_number : '--No Back Number--';
			            })
			->addColumn('part_name', function($list){

							$codes 	= $list->code ;
							$code 	= substr($list->code, 0, 2);
							$models	= avi_trace_program_number::select('part_name')->where('code', $code)->first();
			            	return $models ? $models->part_name : '--No Part Name';
			            })

	        ->addIndexColumn()
	        ->make(true);
		
	}
	function getAjaxDataPulling(){

	$list 			= avi_trace_delivery::select('*');

	return Datatables::of($list)
			->addColumn('part_number', function($list) {

							$codes 	= $list->code ;
							$code 	= substr($list->code, 0, 2);
							$models	= avi_trace_program_number::select('part_number')->where('code', $code)->first();
			            	return $models ? $models->part_number : '--No Part Number--';
			            })
			->addColumn('back_number', function($list)  {

							$codes 	= $list->code ;
							$code 	= substr($list->code, 0, 2);
							$models	= avi_trace_program_number::select('back_number')->where('code', $code)->first();
			            	return $models ? $models->back_number : '--No Back Number--';
			            })
			->addColumn('part_name', function($list) {

							$codes 	= $list->code ;
							$code 	= substr($list->code, 0, 2);
							$models	= avi_trace_program_number::select('part_name')->where('code', $code)->first();
			            	return $models ? $models->part_name : '--No Part Name--';
			            })

	        ->addIndexColumn()
	        ->make(true);
		
	}
	function getDataAll(){ 
			
		$casting 	= avi_trace_casting::select('*');
		$machining 	= avi_trace_machining::select('*');
		$delivery 	= avi_trace_delivery::select('*');
		// $models		= avi_trace_program_number::select('part_number','part_name','back_number')->where('code', $code)->first();

	    $arrayku	= array($casting, $machining, $delivery);

	   // return $arrayku;

	   return Datatables::of($arrayku)
	        ->addColumn('part_number', function($arrayku){
	        		$codes 	= $arrayku->code ;
					$code 	= substr($arrayku->code, 0, 2);
					$models	= avi_trace_program_number::select('part_number')->where('code', $code)->first();
	            	return $models->part_number;
	            })
			->addColumn('back_number', function($arrayku){

					$codes 	= $arrayku->code ;
					$code 	= substr($arrayku->code, 0, 2);
					$models	= avi_trace_program_number::select('back_number')->where('code', $code)->first();
	            	return $models->back_number;
	            })
			->addColumn('part_name', function($arrayku){

					$codes 	= $arrayku->code ;
					$code 	= substr($arrayku->code, 0, 2);
					$models	= avi_trace_program_number::select('part_name')->where('code', $code)->first();
	            	return $models->part_name;
	            })
	        ->addIndexColumn()
	        ->make(true);
	}
}
