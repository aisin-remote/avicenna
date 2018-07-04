<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\avicenna\avi_trace_casting;
use App\Models\avicenna\avi_trace_machining;
use App\Models\avicenna\avi_trace_delivery;
use Yajra\Datatables\Datatables;

class ViewTraceController extends Controller
{
    function index(){
		return view('tracebility.index');
	}

	public function getAjaxData($id_product)
	{

	$code 			= $id_product;
	$npk 			= substr($id_product, 4, 2);
	$date  			= strlen($id_product) == 15 ? substr($id_product, 6, 5) : substr($id_product, 6, 6);
	$time 			= strlen($id_product) == 15 ? substr($id_product, 11, 1) : substr($id_product, 12, 1);
	$create= New avi_trace_casting();
	$create->code = $code;
	$create->npk = $npk;
	$create->date = $date;
	$create->location = "Casting" ;
		$casting 		=avi_trace_casting::select('*', \DB::raw('"QA Casting" as location'))->where('code',$id_product)->first();
		if (is_null($casting)){
			$casting= new avi_trace_casting();
			$casting->code = "--";
			$casting->npk = "--";
			$casting->date = "--";
			$casting->location = "QA Casting" ;
		}
		$machining 		=avi_trace_machining::select('*', \DB::raw('"Lastman Machining" as location'))->where('code',$id_product)->first();
		if (is_null($machining)){
			$machining= new avi_trace_machining();
			$machining->code = "--";
			$machining->npk = "--";
			$machining->date = "--";
			$machining->location = "Last Machining" ;
		}
		$delivery 		=avi_trace_delivery::select('*', \DB::raw('"Delivery" as location'))->where('code',$id_product)->first();
		if (is_null($delivery)){
			$delivery= new avi_trace_delivery();
			$delivery->code = "--";
			$delivery->npk = "--";
			$delivery->date = "--";
			$delivery->location = "Delivery" ;
		}
	   $arrayku=array($create, $casting, $machining, $delivery); 
	   return Datatables::of($arrayku)
	        ->addColumn('time', function($arrayku) {
	        		$b = $arrayku->created_at;
	        		$a = substr($b, 11, 5);
	            	return $a;
	            })
	        ->addIndexColumn()
	        ->make(true);


	}
}
