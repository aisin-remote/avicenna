<?php

namespace App\Http\Controllers;

use App\Models\Avicenna\avi_dowa_process;
use Illuminate\Http\Request;
use App\Models\Avicenna\avi_trace_casting;
use App\Models\Avicenna\avi_trace_machining;
use App\Models\Avicenna\avi_trace_delivery;
use App\Models\Avicenna\avi_trace_assembling;
use App\Models\Avicenna\avi_trace_machine_tonase;
use App\Models\Avicenna\avi_trace_program_number;
use App\Models\Avicenna\avi_trace_cycle;
use App\Models\Avicenna\avi_trace_torimetron;
use DateTime;
use Yajra\Datatables\Datatables;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;
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
		$a 				= substr($id_product, 5, 1);
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

			$casting 		=avi_trace_casting::select('*', \DB::raw('"02 Lastman Casting" as location'))->where('code','like','%'.$id_product."%")->first();
			if (is_null($casting)){
				$casting= new avi_trace_casting();
				$casting->code = "--";
				$casting->npk = "--";
				$casting->date = "--";
				$casting->location = "02 Lastman Casting" ;
			}
			$machining 		=avi_trace_machining::select('*', \DB::raw('"03 Lastman Machining" as location'))->where('code','like','%'.$id_product.'%')->first();
			if (is_null($machining)){
				$machining= new avi_trace_machining();
				$machining->code = "--";
				$machining->npk = "--";
				$machining->date = "--";
				$machining->location = "03 Last Machining" ;
			}
			$assembling 	=avi_trace_assembling::select('*', \DB::raw('"04 Lastman Assembling" as location'))->where('code','like','%'.$id_product.'%')->first();
			if (is_null($assembling)){
				$assembling= new avi_trace_assembling();
				$assembling->code = "--";
				$assembling->npk = "--";
				$assembling->date = "--";
				$assembling->location = "04 Last Assembling" ;
			}
			$delivery 		=avi_trace_delivery::select('*', \DB::raw('"05 Pulling" as location'))->where('code','like','%'.$id_product.'%')->first();
			if (is_null($delivery)){
				$delivery= new avi_trace_delivery();
				$delivery->code = "--";
				$delivery->npk = "--";
				$delivery->date = "--";
				$delivery->location = "05 Pulling" ;
			}
		   $arrayku=array($create, $casting, $machining, $assembling, $delivery);

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

	public function getAjaxProductDowa($id_product) {
		try {
			$dowaData = avi_dowa_process::where('code', $id_product)->first();
			if ( $dowaData == null) {
				return [
					"status" => "notfound"
				];
			}
			try {
				$client = new Client();
				$response = $client->get(env('DOWA_BASE_URL').'/products/'.$id_product, [
					'headers' => [
						'Accept' => 'application/json',
						'Authorization' => 'Bearer '.Cache::get('dowa_token')
					]
				]);
				$api = $response->json();
			} catch (\Throwable $th) {
				$api = null;
			}

			$torimetron = avi_trace_torimetron::where('product_code', $id_product)->first();

			$datedelivery = $dowaData->scan_delivery_dowa_at ? DateTime::createFromFormat('Y-m-d H:i:s',$dowaData->scan_delivery_dowa_at)->format('Y-m-d') : '--';
			$datereceivedowa = $api['data']['received_dowa_at'] ? DateTime::createFromFormat('Y-m-d H:i:s',$api['data']['received_dowa_at'])->format('Y-m-d') : '--';
			$datesenddowa = $api['data']['finished_dowa_at'] ? DateTime::createFromFormat('Y-m-d H:i:s',$api['data']['finished_dowa_at'])->format('Y-m-d') : '--';
			$datetorimetrondowa = $dowaData->scan_torimetron_at ? DateTime::createFromFormat('Y-m-d H:i:s',$dowaData->scan_torimetron_at )->format('Y-m-d') : '--';
			$timedelivery = $dowaData->scan_delivery_dowa_at ? DateTime::createFromFormat('Y-m-d H:i:s',$dowaData->scan_delivery_dowa_at)->format('H:i:s') : '--';
			$timereceivedowa = $api['data']['received_dowa_at'] ? DateTime::createFromFormat('Y-m-d H:i:s',$api['data']['received_dowa_at'])->format('H:i:s') : '--';
			$timesenddowa = $api['data']['finished_dowa_at'] ? DateTime::createFromFormat('Y-m-d H:i:s',$api['data']['finished_dowa_at'])->format('H:i:s') : '--';
			$timetorimetrondowa = $dowaData->scan_torimetron_at ? DateTime::createFromFormat('Y-m-d H:i:s',$dowaData->scan_torimetron_at )->format('H:i:s') : '--';
			$ngsenddowa = $api['data']['status'] == '1' ? 'OK':'NG';

			if ($torimetron) {
				if ($dowaData->status == '1' && $torimetron->status == avi_trace_torimetron::STATUS_OK) {
					$statusTorimetron = 'OK';
				} elseif ($dowaData->status == '1' && $torimetron->status == avi_trace_torimetron::STATUS_NG) {
					$statusTorimetron = 'NG Torimetron';
				} elseif ($dowaData->status == '0' && $torimetron->status == avi_trace_torimetron::STATUS_OK) {
					$statusTorimetron = 'NG Visual';
				} else {
					$statusTorimetron = 'NG';
				}
			} else {
				$statusTorimetron = $dowaData->status == '1'? 'OK' : 'NG Visual';
			}

			$avgt01 = $torimetron ? $torimetron->avgt01 : '-';
			$avgt02 = $torimetron ? $torimetron->avgt02 : '-';
			$avgt03 = $torimetron ? $torimetron->avgt03 : '-';
			$avgt04 = $torimetron ? $torimetron->avgt04 : '-';
			$avgt05 = $torimetron ? $torimetron->avgt05 : '-';
			$avgt06 = $torimetron ? $torimetron->avgt06 : '-';
			$avgt07 = $torimetron ? $torimetron->avgt07 : '-';
			$avgt08 = $torimetron ? $torimetron->avgt08 : '-';
			$avgt09 = $torimetron ? $torimetron->avgt09 : '-';
			$avgt10 = $torimetron ? $torimetron->avgt10 : '-';
			$avgt11 = $torimetron ? $torimetron->avgt11 : '-';
			$avgt12 = $torimetron ? $torimetron->avgt12 : '-';
			$avgt13 = $torimetron ? $torimetron->avgt13 : '-';
			$avgt14 = $torimetron ? $torimetron->avgt14 : '-';
			$avgt15 = $torimetron ? $torimetron->avgt15 : '-';
			$avgt16 = $torimetron ? $torimetron->avgt16 : '-';
			$avgt17 = $torimetron ? $torimetron->avgt17 : '-';
			$avgt18 = $torimetron ? $torimetron->avgt18 : '-';
			$deliverydowa = [
				'kbn_sup' => $dowaData->kbn_supply ? $dowaData->kbn_supply : '--',
				'npk_delivery_dowa' => $dowaData->npk_delivery_dowa ? $dowaData->npk_delivery_dowa : '--',
				'date_delivery_dowa' => $datedelivery,
				'time_delivery_dowa' => $timedelivery,
				'note_delivery_dowa' => $dowaData->npk_delivery_dowa ? 'OK' : '--',
				'npk_receive_dowa' =>$api['data']['received_by']['npk']? $api['data']['received_by']['npk']: '--',
				'date_receive_dowa' =>$datereceivedowa,
				'time_receive_dowa' =>$timereceivedowa,
				'npk_send_dowa' =>$api['data']['finished_by']['npk'] ? $api['data']['finished_by']['npk'] : '--',
				'date_send_dowa' => $datesenddowa,
				'time_send_dowa' => $timesenddowa,
				'note_send_dowa' => $api['data']['received_dowa_at'] ? $ngsenddowa : '--',
				'note_receive_dowa' =>  $dowaData->npk_delivery_dowa ? 'OK' : '--',
				'kbn_fg'=>$dowaData->kbn_fg ? $dowaData->kbn_fg : '--',
				'npk_torimetron_dowa'=>$dowaData->npk_torimetron ? $dowaData->npk_torimetron : '--',
				'date_torimetron_dowa'=>$datetorimetrondowa,
				'time_torimetron_dowa'=>$timetorimetrondowa,
				'note_torimetron_dowa'=> $statusTorimetron,
				'avgt01' => $avgt01,
				'avgt02' => $avgt02,
				'avgt03' => $avgt03,
				'avgt04' => $avgt04,
				'avgt05' => $avgt05,
				'avgt06' => $avgt06,
				'avgt07' => $avgt07,
				'avgt08' => $avgt08,
				'avgt09' => $avgt09,
				'avgt10' => $avgt10,
				'avgt11' => $avgt11,
				'avgt12' => $avgt12,
				'avgt13' => $avgt13,
				'avgt14' => $avgt14,
				'avgt15' => $avgt15,
				'avgt16' => $avgt16,
				'avgt17' => $avgt17,
				'avgt18' => $avgt18,
			];
			return [
				"status" => "success",
				"data" => $deliverydowa
			];
		} catch (\Throwable $e) {
			//throw $th;
			return [
				"status" => "error",
				"messege" => $e->getMessage()
			];
		}

	}
}
