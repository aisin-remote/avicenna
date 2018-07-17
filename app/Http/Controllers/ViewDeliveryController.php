<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\avicenna\avi_trace_delivery;
use App\Models\avicenna\avi_trace_program_number;
use Yajra\Datatables\Datatables;
use Carbon\Carbon;

class ViewDeliveryController extends Controller
{
    function index(){
		return view('tracebility.delivery.index');
	}

	function getAjaxData(){

	$date      		= Carbon::now()->format('Y-m-d');
	$delivered 		= avi_trace_delivery::select('*')->where('date', $date)->get();
	$a 				= 0 ;
	$models			= avi_trace_program_number::select('product')->get();

	return Datatables::of($delivered)
			->addColumn('no', function($delivered) use($a) {
							$no = $a++ ;
			            	return $no;
			            })
			->addColumn('name', function($delivered) use($models) {

							$codes 	= $delivered->code ;
							$code 	= substr($delivered->code, 0, 2);
							$models	= avi_trace_program_number::select('product')->where('code', $code)->first();
			            	return $models->product;
			            })

	        ->addIndexColumn()
	        ->make(true);
		
	}
	public function getAjaxFilter($date)
	{
	$delivered 		= avi_trace_delivery::select('*')->where('date', $date)->get();
	$a 				= 0 ;
	$models			= avi_trace_program_number::select('product')->get();
	return Datatables::of($delivered)
			->addColumn('no', function($delivered) use($a) {
							$no = $a++ ;
			            	return $no ;
			            })
			->addColumn('name', function($delivered) use($models) {

							$codes 	= $delivered->code ;
							$code 	= substr($delivered->code, 0, 2);
							$models	= avi_trace_program_number::select('product')->where('code', $code)->first();
			            	return $models->product;
			            })

	        ->addIndexColumn()
	        ->make(true);
	}


}
