<?php

namespace App\Http\Controllers;
use App\Models\Avicenna\avi_trace_program_number;
use App\Models\Avicenna\avi_trace_machining;
use App\Models\Avicenna\avi_trace_casting;
use App\Models\Avicenna\avi_trace_cycle;
use App\Models\Avicenna\avi_trace_delivery;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\Datatables\Datatables;
use Carbon\Carbon;
use Response;
use DB;
use App\Mail\TmminReport;
use Illuminate\Support\Facades\Mail;

use Illuminate\Http\Request;

class TraceListController extends Controller
{
	function indexout(){
		return view('tracebility.list.indexout');
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
		$yesterday = \Carbon\Carbon::yesterday()->format('Y-m-d');
    	$query = avi_trace_delivery::select('avi_trace_delivery.code as code_delivery','avi_trace_delivery.npk as npk_delivery','avi_trace_delivery.cycle as cycle_delivery','avi_trace_delivery.date as date_delivery',
    		'avi_trace_casting.line as line_casting','avi_trace_casting.npk as npk_casting','avi_trace_casting.date as date_casting',
    		'avi_trace_machining.line as line_machining','avi_trace_machining.npk as npk_machining','avi_trace_machining.date as date_machining')
    	->join('avi_trace_casting','avi_trace_delivery.code','=','avi_trace_casting.code')
    	->join('avi_trace_machining','avi_trace_delivery.code','=','avi_trace_machining.code')
    	->where('avi_trace_delivery.date', $yesterday)
    	->where('avi_trace_delivery.customer','TMMIN')
    	->get();

	    Excel::load('/storage/template/print_part_tmiin.csv',  function($file) use($query){

    		$a = "2";
    		foreach ($query as $queries){
    			$code_delivery	= $queries->code_delivery;
    			$line_casting	= $queries->line_casting;
    			$npk_casting	= $queries->npk_casting;
    			$date_casting	= $queries->date_casting;
    			$line_machining	= $queries->line_machining;
    			$npk_machining	= $queries->npk_machining;
    			$date_machining	= $queries->date_machining;
    			$cycle_delivery	= avi_trace_cycle::select('name')->where('code',$queries->cycle_delivery)->first();
    			$npk_delivery	= $queries->npk_delivery;
    			$date_delivery	= $queries->date_delivery;
    			$c 				= substr($queries->code_delivery, 0, 2);
    			$part_number	= avi_trace_program_number::where('code',$c)->first();


    			$file->setActiveSheetIndex(0)->setCellValue('A'.$a.'', $part_number->company_code);
    			$file->setActiveSheetIndex(0)->setCellValue('B'.$a.'', $part_number->plant_code);
    			$file->setActiveSheetIndex(0)->setCellValue('C'.$a.'', $part_number->supplier_code);
    			$file->setActiveSheetIndex(0)->setCellValue('D'.$a.'', $part_number->supplier_plant);
    			$file->setActiveSheetIndex(0)->setCellValue('E'.$a.'', $code_delivery);
    			$file->setActiveSheetIndex(0)->setCellValue('F'.$a.'', $part_number->part_name);
    			$file->setActiveSheetIndex(0)->setCellValue('G'.$a.'', $line_casting);
    			$file->setActiveSheetIndex(0)->setCellValue('H'.$a.'', $date_casting);
    			$file->setActiveSheetIndex(0)->setCellValue('I'.$a.'', $npk_casting);
    			$file->setActiveSheetIndex(0)->setCellValue('J'.$a.'', $line_machining);
    			$file->setActiveSheetIndex(0)->setCellValue('K'.$a.'', $date_machining);
    			$file->setActiveSheetIndex(0)->setCellValue('L'.$a.'', $npk_machining);
    			$file->setActiveSheetIndex(0)->setCellValue('M'.$a.'', $cycle_delivery->name);
    			$file->setActiveSheetIndex(0)->setCellValue('N'.$a.'', $date_delivery);
    			$file->setActiveSheetIndex(0)->setCellValue('O'.$a.'', $npk_delivery);
    			$file->setActiveSheetIndex(0)->setCellValue('P'.$a.'', $part_number->part_number);

    			$a++;
    		}

		})->save('csv', storage_path('traceability'), true);

	    $this->tes();
		return view('tracebility.list.indexout');
    }

    function tes(){ 
		$yesterday = \Carbon\Carbon::yesterday()->format('Y-m-d');
		$tmmin = array('tanggal' => $yesterday);
		$penerima = array('handika@aiia.co.id', 'alliq@aiia.co.id', 'm.nurbaitullah@aiia.co.id', 'audi.r@aiia.co.id', 'fachrul@aiia.co.id');
		// $penerima = array('audi.r@aiia.co.id');

		Mail::send('tracebility.email.index', $tmmin, function($message) use ($penerima)  {
		$message->to('destya.amifa@toyota.co.id', 'heri.surachman@toyota.co.id', 'harpan@aiia.co.id', 'ferry@aiia.co.id')
		// $message->to('handika@aiia.co.id')
					->subject('Traceability')
					->attach(storage_path('traceability/print_part_tmiin.csv'));
		$message->cc($penerima);
		$message->from('aisinbisa@aiia.co.id');
		});
	}
}
