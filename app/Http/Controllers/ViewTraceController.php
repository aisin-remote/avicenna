<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Avicenna\avi_trace_casting;
use App\Models\Avicenna\avi_trace_machining;
use App\Models\Avicenna\avi_trace_delivery;
use App\Models\Avicenna\avi_trace_machine_tonase;
use App\Models\Avicenna\avi_trace_program_number;
use App\Models\Avicenna\avi_trace_cycle;
use Yajra\Datatables\Datatables;
use Storage;

class ViewTraceController extends Controller
{
    function index(){
		return view('tracebility.index');
	}
	function search($barcode = null){
		return view('tracebility.list.search', compact('barcode'));
	}
	function searchout($barcode = null){
		return view('tracebility.list.searchout', compact('barcode'));
	}

	function getAjaxIndex(){
	$create= New avi_trace_casting();
	$create->code = 'No Data';
	$create->npk = 'No Data';
	$create->date = 'No Data';
	$create->location = "No Data" ;
	$arrayku=array($create);
	return Datatables::of($arrayku)
	        ->addColumn('time', function($arrayku) {
	        		$b = $arrayku->created_at;
	        		$a = substr($b, 11, 5);

	        		if ($a == false ) {
	        			$a = 'No Data';
	        		}

	            	return $a;


	            })
	        ->addIndexColumn()
	        ->make(true);
		
	}


	public function getAjaxProduct($id_product)
	{	

		$b 				= substr($id_product, 5, 1);
		$npk 			= "DCAA0".$b."";
		if ($b == "A") {
			$npk 			= "DCAA10";
		}

		$a = substr($id_product, 0, 2);
		$product = avi_trace_program_number::select('product')->where('code', $a)->first();
		if (is_null($product)){
			$product 			= new avi_trace_program_number();
			$product->product 	= "No Data";
		}

		$cycle 	= avi_trace_cycle::select('name')
					->join('avi_trace_delivery', 'avi_trace_cycles.code', '=', 'avi_trace_delivery.cycle')
					->where('avi_trace_delivery.code', $id_product )
					->first();
		if (is_null($cycle)){
			$cycle 			= new avi_trace_cycle();
			$cycle->name 	= "No Data" ;
		}

		$customer = avi_trace_delivery::select('customer')
					->where('code', $id_product)
					->first();
		if (is_null($customer)){
			$customer 			= new avi_trace_cycle();
			$customer->customer	= "No Data" ;
		}
		$b = substr($id_product, 4, 1);
		$tonase = avi_trace_machine_tonase::select('tonase')
					->where('code', $b)
					->first();
		if (is_null($tonase)){
			$tonase 			= new avi_trace_machine_tonase();
			$tonase->tonase		= "No Data" ;
		}

		return array(	"img_path" =>  asset('storage/tracebility/'.$product->product.'.JPG') ,
						"product" => $product->product ,
						"cycle" => $cycle->name ,
						"customer"=>$customer->customer,
						"mesin"=>$npk,
						"tonase"=>$tonase->tonase);
		// return $cycle ;

	}

	public function getAjaxData($id_product)
	{

		$code 			= $id_product;
		$a 				= substr($id_product, 6, 1);
		$npk 			= "DCAA0".$a."";
		if ($a == "A") {
			$npk 			= "DCAA10";
		}

			$a = substr($id_product, 8, 1) ;
			if ($a == "A") {
				$a = "10";
			}elseif ($a == "B") {
				$a = "11";
			}elseif ($a == "C") {
				$a = "12";
			}else{
				$a = '0'.$a ;
			}
		$date  				= '20'.substr($id_product, 6, 2).'-'.$a.'-'.substr($id_product, 9, 2); 
		$create 			= New avi_trace_casting();
		$create->code 		= $code;
		$create->npk 		= $npk;
		$create->date 		= $date;
		$create->location 	= "01 Casting" ;
			$machining 		=avi_trace_machining::select('*', \DB::raw('"03 Lastman Machining" as location'))->where('code','like','%'.$id_product.'%')->first();
			if (is_null($machining)){
				$machining= new avi_trace_machining();
				$machining->code = "--";
				$machining->npk = "--";
				$machining->date = "--";
				$machining->location = "03 Last Machining" ;
			}
			$delivery 		=avi_trace_delivery::select('*', \DB::raw('"04 Pulling" as location'))->where('code','like','%'.$id_product.'%')->first();
			if (is_null($delivery)){
				$delivery= new avi_trace_delivery();
				$delivery->code = "--";
				$delivery->npk = "--";
				$delivery->date = "--";
				$delivery->location = "04 Delivery" ;
			}
			$casting 		=avi_trace_casting::select('*', \DB::raw('"02 Lastman Casting" as location'))->where('code','like','%'.$id_product."%")->first();
			if (is_null($casting)){
				$casting= new avi_trace_casting();
				$casting->code = "--";
				$casting->npk = "--";
				$casting->date = "--";
				$casting->location = "02 Lastman Casting" ;
			}
		   $arrayku=array($create, $casting, $machining, $delivery); 
		   return Datatables::of($arrayku)
		        ->addColumn('time', function($arrayku) {
		        		$b = $arrayku->created_at;
		        		$a = substr($b, 11, 5);
		        		if ($a == false ) {
		        			$a = '--';
		        		}
		            	return $a;
		            })
		        ->addIndexColumn()
		        ->make(true);


	}
}
