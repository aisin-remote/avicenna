<?php

namespace App\Http\Controllers;
use App\Models\avicenna\avi_trace_program_number;
use App\Models\avicenna\avi_trace_machining;
use App\Models\avicenna\avi_trace_casting;
use App\Models\avicenna\avi_trace_delivery;
use Yajra\Datatables\Datatables;
use Carbon\Carbon;

use Illuminate\Http\Request;

class TraceListController extends Controller
{
    function index(){
		return view('tracebility.list.index');
	}
	function getAjaxDataCasting(){

	$date      		= Carbon::now()->format('Y-m-d');
	$list 			= avi_trace_casting::select('*')->get();
	$a 				= 0 ;
	$models			= avi_trace_program_number::select('part_number','part_name','back_number')->get();

	return Datatables::of($list)
			->addColumn('no', function($list) use($a) {
							$z = $a+1;
							$x = $z++;
							return $x;
						
			            })
			->addColumn('part_number', function($list) use($models) {

							$codes 	= $list->code ;
							$code 	= substr($list->code, 0, 2);
							$models	= avi_trace_program_number::select('part_number')->where('code', $code)->first();
			            	return $models->part_number;
			            })
			->addColumn('part_name', function($list) use($models) {

							$codes 	= $list->code ;
							$code 	= substr($list->code, 0, 2);
							$models	= avi_trace_program_number::select('part_name')->where('code', $code)->first();
			            	return $models->part_name;
			            })
			->addColumn('back_number', function($list) use($models) {

							$codes 	= $list->code ;
							$code 	= substr($list->code, 0, 2);
							$models	= avi_trace_program_number::select('back_number')->where('code', $code)->first();
			            	return $models->back_number;
			            })
			->addColumn('part_name', function($list) use($models) {

							$codes 	= $list->code ;
							$code 	= substr($list->code, 0, 2);
							$models	= avi_trace_program_number::select('part_name')->where('code', $code)->first();
			            	return $models->part_name;
			            })

	        ->addIndexColumn()
	        ->make(true);
		
	}
	function getAjaxDataMachining(){

	$date      		= Carbon::now()->format('Y-m-d');
	$list 			= avi_trace_machining::select('*')->get();
	$a 				= 0 ;
	$models			= avi_trace_program_number::select('part_number','part_name','back_number')->get();

	return Datatables::of($list)
			->addColumn('no', function($list) use($a) {
							$z = $a+1;
							$x = $z++;
							return $x;
						
			            })
			->addColumn('part_number', function($list) use($models) {

							$codes 	= $list->code ;
							$code 	= substr($list->code, 0, 2);
							$models	= avi_trace_program_number::select('part_number')->where('code', $code)->first();
			            	return $models->part_number;
			            })
			->addColumn('part_name', function($list) use($models) {

							$codes 	= $list->code ;
							$code 	= substr($list->code, 0, 2);
							$models	= avi_trace_program_number::select('part_name')->where('code', $code)->first();
			            	return $models->part_name;
			            })
			->addColumn('back_number', function($list) use($models) {

							$codes 	= $list->code ;
							$code 	= substr($list->code, 0, 2);
							$models	= avi_trace_program_number::select('back_number')->where('code', $code)->first();
			            	return $models->back_number;
			            })
			->addColumn('part_name', function($list) use($models) {

							$codes 	= $list->code ;
							$code 	= substr($list->code, 0, 2);
							$models	= avi_trace_program_number::select('part_name')->where('code', $code)->first();
			            	return $models->part_name;
			            })

	        ->addIndexColumn()
	        ->make(true);
		
	}
	function getAjaxDataPulling(){

	$date      		= Carbon::now()->format('Y-m-d');
	$list 			= avi_trace_delivery::select('*')->get();
	$a 				= 0 ;
	$models			= avi_trace_program_number::select('part_number','part_name','back_number')->get();

	return Datatables::of($list)
			->addColumn('no', function($list) use($a) {
							$z = $a+1;
							$x = $z++;
							return $x;
						
			            })
			->addColumn('part_number', function($list) use($models) {

							$codes 	= $list->code ;
							$code 	= substr($list->code, 0, 2);
							$models	= avi_trace_program_number::select('part_number')->where('code', $code)->first();
			            	return $models->part_number;
			            })
			->addColumn('part_name', function($list) use($models) {

							$codes 	= $list->code ;
							$code 	= substr($list->code, 0, 2);
							$models	= avi_trace_program_number::select('part_name')->where('code', $code)->first();
			            	return $models->part_name;
			            })
			->addColumn('back_number', function($list) use($models) {

							$codes 	= $list->code ;
							$code 	= substr($list->code, 0, 2);
							$models	= avi_trace_program_number::select('back_number')->where('code', $code)->first();
			            	return $models->back_number;
			            })
			->addColumn('part_name', function($list) use($models) {

							$codes 	= $list->code ;
							$code 	= substr($list->code, 0, 2);
							$models	= avi_trace_program_number::select('part_name')->where('code', $code)->first();
			            	return $models->part_name;
			            })

	        ->addIndexColumn()
	        ->make(true);
		
	}
}
