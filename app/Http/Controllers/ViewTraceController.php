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

	   $casting 		=avi_trace_casting::select('*', \DB::raw('"Casting" as location'))->where('code',$id_product)->first();
	   $machining 		=avi_trace_machining::select('*', \DB::raw('"Machining" as location'))->where('code',$id_product)->first();
	   $delivery 		=avi_trace_delivery::select('*', \DB::raw('"Delivery" as location'))->where('code',$id_product)->first();

	   $arrayku=array($casting, $machining, $delivery);
	   return Datatables::of($arrayku)
	        ->addColumn('time', function($arrayku) {
	        		$b = $arrayku->create_at;
	        		$a = substr($b, 11, 5);
	            	return $a;
	            })
	        ->addIndexColumn()
	        ->make(true);


	}
}
