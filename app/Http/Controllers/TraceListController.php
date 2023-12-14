<?php

namespace App\Http\Controllers;
use App\Models\Avicenna\avi_trace_program_number;
use App\Models\Avicenna\avi_trace_machining;
use App\Models\Avicenna\avi_trace_casting;
use App\Models\Avicenna\avi_tmmin_log;
use App\Models\Avicenna\avi_trace_assembling;
use App\Models\Avicenna\avi_trace_strainer_master;
use App\Models\Avicenna\avi_trace_delivery;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\Datatables\Datatables;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Response;
use DB;
use App\Mail\TmminReport;
use Illuminate\Support\Facades\Mail;

use Illuminate\Http\Request;
use Config;
use Storage;

class TraceListController extends Controller
{
	function indexout(){
		return view('tracebility.list.indexout');
	}
	function indexFilter(Request $request){
		$data = $request->all();
		if ($data["process"] == "casting") {
			$list 			= avi_trace_casting::select('*')->orderBy('created_at', 'DESC');
		} elseif ($data["process"] == "machining") {
			$list 			= avi_trace_machining::select('*')->orderBy('created_at', 'DESC');
		} elseif ($data["process"] == "assembling") {
			$list 			= avi_trace_assembling::select('*')->orderBy('created_at', 'DESC');
		}

		if ($data["start_date"]) {
			$list = $list->where('date', '>=', $data["start_date"]);
		}

		if ($data["end_date"]) {
			$list = $list->where('date', '<=', $data["end_date"]);
		}

		if ($data["line"]) {
			$list = $list->where('line', '=', $data["line"]);
		}

		if ($data["back_no"]) {
			$back_no = avi_trace_program_number::select('code')->where('back_number', $data['back_no'])->get();
			foreach ($back_no as $key => $value) {
				$list = $list->orWhere('code', 'like', $value->code.'%');
			}

		}
		$datatable = Datatables::of($list)
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
				->addColumn('status', function($list) {
								if ($list->status == 1) {
	                                return '<span class="label label-success">OK</span>';
	                            } else {
	                                return '<span class="label label-danger">NG</span>';
	                            }
				            })

		        ->addIndexColumn()
		        ->rawColumns(['status'])
				->make(true);

		return $datatable;
	}
	function getAjaxDataCasting(){

		$list 			= avi_trace_casting::select('*')->orderBy('created_at', 'DESC');

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
				->addColumn('status', function($list) {
								if ($list->status == 1) {
	                                return '<span class="label label-success">OK</span>';
	                            } else {
	                                return '<span class="label label-danger">NG</span>';
	                            }
				            })
				->addColumn('strainer', "-")
		        ->addIndexColumn()
		        ->rawColumns(['status'])
		        ->make(true);

	}
	function getAjaxDataMachining(){

		$list 			= avi_trace_machining::select('*')->orderBy('created_at', 'DESC');

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
				->addColumn('status', function($list) {
								if ($list->status == 1) {
	                                return '<span class="label label-success">OK</span>';
	                            } else {
	                                return '<span class="label label-danger">NG</span>';
	                            }
				            })
				->addColumn('strainer', function($list) {
								$strainer = avi_trace_strainer_master::where('id', $list->strainer_id)->first();
								if ($strainer) {
									return $strainer->customer;
								} else {
									return '-';
								}
				            })
		        ->addIndexColumn()
		        ->rawColumns(['status'])
		        ->make(true);

	}
	function getAjaxDataAssembling(){

		$list 			= avi_trace_assembling::select('*')->orderBy('created_at', 'DESC');

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
				->addColumn('status', function($list) {
								if ($list->status == 1) {
	                                return '<span class="label label-success">OK</span>';
	                            } else {
	                                return '<span class="label label-danger">NG</span>';
	                            }
				            })
				->addColumn('strainer', "-")

		        ->addIndexColumn()
		        ->rawColumns(['status'])
		        ->make(true);

	}
	function getAjaxDataPulling(){

	$list 			= avi_trace_delivery::select('*')->orderBy('created_at', 'DESC');

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
			->addColumn('status', function($list) {
							if ($list->status == 1) {
                                return '<span class="label label-success">OK</span>';
                            } else {
                                return '<span class="label label-danger">NG</span>';
                            }
			            })
			->addColumn('line', function($list) {

							if ($list->status == 1) {
                                return $list->npk;
                            } else {
                                return $list->npk_ng;
                            }
			            })
			->addColumn('strainer', "-")

	        ->addIndexColumn()
	        ->rawColumns(['status'])
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

	public function tracepartreport()
    {
		$client = new Client();
        $response = $client->post('http://18.140.222.208:8010/scc/api/identity/v1/login', ['verify' => false, 'json' => [
			'username' => 'adminAisinKrw',
			'password' => 'c3VwZXJhZG1pbjEyMw==',
		]]);
        $data = json_decode($response->getBody(), true);
		$token = 'Bearer ' . $data['data']['accessToken'];

		if ($data['data']['accessToken']) {
			//DO
			try{
				$yesterday = \Carbon\Carbon::yesterday()->format('Y-m-d');
				$now = \Carbon\Carbon::now()->format('Ymdhis');
				$query = avi_trace_delivery::select('avi_trace_delivery.code as code_delivery','avi_trace_delivery.npk as npk_delivery','avi_trace_delivery.cycle as cycle_delivery','avi_trace_delivery.created_at as date_delivery',
					'avi_trace_casting.line as line_casting','avi_trace_casting.npk as npk_casting','avi_trace_casting.created_at as date_casting',
					'avi_trace_machining.line as line_machining','avi_trace_machining.npk as npk_machining','avi_trace_machining.created_at as date_machining')
				->join('avi_trace_casting','avi_trace_delivery.code','=','avi_trace_casting.code')
				->join('avi_trace_machining','avi_trace_delivery.code','=','avi_trace_machining.code')
				->where('avi_trace_delivery.date', $yesterday)
				->orWhere('avi_trace_delivery.code', 'LIKE' , '10%')
				->orWhere('avi_trace_delivery.code', 'LIKE' , '15%')
				->orWhere('avi_trace_delivery.code', 'LIKE' , '18%')
				->orWhere('avi_trace_delivery.code', 'LIKE' , '11%')
				->orWhere('avi_trace_delivery.code', 'LIKE' , '19%')
				->orWhere('avi_trace_delivery.code', 'LIKE' , '14%')
				->where('avi_trace_delivery.customer','7A00034')
				->get();

				$sendData = [];

				foreach ($query as $key => $value) {
					$code_delivery	= $value->code_delivery;
					$line_casting	= $value->line_casting;
					$npk_casting	= $value->npk_casting;
					$date_casting	= Carbon::createFromFormat('Y-m-d H:i:s', $value->date_casting)->format('d-M-Y H:i:s');
					$line_machining	= $value->line_machining;
					$npk_machining	= $value->npk_machining;
					$date_machining	= Carbon::createFromFormat('Y-m-d H:i:s', $value->date_machining)->format('d-M-Y H:i:s');
					$npk_delivery	= $value->npk_delivery;
					$date_delivery	= Carbon::createFromFormat('Y-m-d H:i:s', $value->date_delivery)->format('d-M-Y H:i:s');
					$c 				= substr($value->code_delivery, 0, 2);
					$part_number	= avi_trace_program_number::where('code',$c)->first();
					$date_now		= Carbon::now()->format('d-M-Y H:i:s');


					$dataArray = [
						"itemCd" => $part_number->part_number,
						"supplierCd" => "AISIN-KRW",
						"inputDt" => $date_now,
						"attribute_key" => (object)[
							"PART_CODE" => $code_delivery,
						],
						"attribute" => (object)[
							"dateScanMA" => $date_machining,
							"NPKDelivery" => $npk_delivery,
							"custPartNumber" => $part_number->part_number,
							"proDt" => $date_now,
							"uomType" => "UNIT",
							"partCode" => $code_delivery,
							"supplierCode" => $part_number->supplier_code,
							"NPKMA" => $npk_machining,
							"lineMA" => $line_machining,
							"partName" => $part_number->part_name,
							"plantCode1" => $part_number->plant_code,
							"supplierPlant" => $part_number->supplier_plant,
							"uom" => "PCS",
							"companyCd" => $part_number->company_code,
							"lineDelivery" => "Cycle " . $value->cycle_delivery,
							"dateScanDC" => $date_casting,
							"lineDC" => $line_casting,
							"qty" => "1",
							"NPKDC" => $npk_casting,
							"dateScanDelivery" => $date_delivery,
						],
						"statusData" => "New"
					];
					
					// Membuat objek PHP dari array
					$object = (object)$dataArray;
					array_push($sendData, $object);
					
				}

				$tempSend = [
					"pointCd" => "PT_GENERAL_TP1_OILPAN_005",
					"inputTypeCd" => "IT_AGENT",
					"rawTypeCd" => "RT_ITEM",
					"data" => $sendData
				];

				
				$jsonSend = (object)$tempSend;
				dd($jsonSend);

				$client2 = new Client();
				$response = $client2->post('http://18.140.222.208:9040/scc/api/raw/item/v1/raw', [
					'verify' => false,
					'headers' => [
						'Authorization' => $token,
						'Content-Type' => 'application/json',
						'X-Client-Id' => 'AISIN-KRW-Agent' // Sesuaikan dengan tipe konten yang dikirimkan
					],
					'json' => $jsonSend, // Mengirimkan data sebagai JSON (jika ada)
				]);
				
				// Mendekode respons JSON menjadi array
				$data2 = json_decode($response->getBody(), true);
				
				$avi_tmmin_log = new avi_tmmin_log;
				$avi_tmmin_log->message = $data2['message']. '|' . $data2['data']['processID'];
				$avi_tmmin_log->save();

				

				//	    $this->tes(); //dev-1.1.0 , Handika, Non aktif fitur email
			}catch(\Exception $e){
				echo "Error ".$e;
			}
		}


    	

    }

}
