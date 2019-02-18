<?php

namespace App\Http\Controllers;
use App\Models\Avicenna\avi_trace_program_number;
use App\Models\Avicenna\avi_trace_machining;
use App\Models\Avicenna\avi_trace_casting;
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
    	// $casting = avi_trace_casting::select('*')->get();
    	// $machining = avi_trace_machining::select('*')->get();
    	// $delivery = avi_trace_delivery::select('*')->get();
    	// $arrayku = array($casting,$machining,$delivery);

    	$castings = avi_trace_casting::select('avi_trace_casting.code as code_casting','avi_trace_casting.npk as npk_casting','avi_trace_casting.line as line_casting','avi_trace_casting.date as date_casting',
    		'avi_trace_machining.line as line_machining','avi_trace_machining.npk as npk_machining','avi_trace_machining.date as date_machining',
    		'avi_trace_delivery.cycle as cycle_delivery','avi_trace_delivery.date as date_delivery','avi_trace_delivery.npk as npk_delivery')
    	->join('avi_trace_machining', 'avi_trace_casting.code', '=', 'avi_trace_machining.code')
    	->leftjoin('avi_trace_delivery', 'avi_trace_casting.code', '=', 'avi_trace_delivery.code')
    	->get();

    	// return $castings;

  //   	$code 			= $id_product;
		// $a 				= substr($id_product, 0, 2);
		// $part 			= avi_trace_program_number::select('*')->where('code', $a)->first();

	    Excel::load('/storage/template/print_part_tmiin.csv',  function($file) use($castings){

    		$a = "2";
    		foreach ($castings as $casting){
    			$code_casting	= $casting->code_casting;
    			$line_casting	= $casting->line_casting;
    			$npk_casting	= $casting->npk_casting;
    			$date_casting	= $casting->date_casting;
    			$line_machining	= $casting->line_machining;
    			$npk_machining	= $casting->npk_machining;
    			$date_machining	= $casting->date_machining;
    			$line_delivery	= $casting->line_delivery;
    			$npk_delivery	= $casting->npk_delivery;
    			$date_delivery	= $casting->date_delivery;

    			$file->setActiveSheetIndex(0)->setCellValue('A'.$a.'', '807J');
    			$file->setActiveSheetIndex(0)->setCellValue('B'.$a.'', '6');
    			$file->setActiveSheetIndex(0)->setCellValue('C'.$a.'', '5011');
    			$file->setActiveSheetIndex(0)->setCellValue('D'.$a.'', '2');
    			$file->setActiveSheetIndex(0)->setCellValue('E'.$a.'', $code_casting);
    			$file->setActiveSheetIndex(0)->setCellValue('F'.$a.'', 'null');
    			$file->setActiveSheetIndex(0)->setCellValue('G'.$a.'', $line_casting);
    			$file->setActiveSheetIndex(0)->setCellValue('H'.$a.'', $date_casting);
    			$file->setActiveSheetIndex(0)->setCellValue('I'.$a.'', $npk_casting);
    			$file->setActiveSheetIndex(0)->setCellValue('J'.$a.'', $line_machining);
    			$file->setActiveSheetIndex(0)->setCellValue('K'.$a.'', $date_machining);
    			$file->setActiveSheetIndex(0)->setCellValue('L'.$a.'', $npk_machining);
    			$file->setActiveSheetIndex(0)->setCellValue('M'.$a.'', $line_delivery);
    			$file->setActiveSheetIndex(0)->setCellValue('N'.$a.'', $date_delivery);
    			$file->setActiveSheetIndex(0)->setCellValue('O'.$a.'', $npk_delivery);
    			$file->setActiveSheetIndex(0)->setCellValue('P'.$a.'', '12101-OYO40');

    			$a++;
    		}
    		
    		

    		// $file->setActiveSheetIndex(0)->setCellValue('A2', '*'.$id_product.'*');
    		// $file->setActiveSheetIndex(0)->setCellValue('A2', $code);
    		// $file->setActiveSheetIndex(0)->setCellValue('C10', $part_number);
    		// $file->setActiveSheetIndex(0)->setCellValue('C11', $model);
    		// $file->setActiveSheetIndex(0)->setCellValue('A12', $part_name);

		})->setFilename("test")->export('csv');
    }

    function tes(){ 
			
		$tmmin = array('name'=>'', 'body' => 'Test mail');
		$penerima = array('handika@aiia.co.id','alliq@aiia.co.id','audi.r@aiia.co.id','fachrul@aiia.co.id','m.nurbaitullah@aiia.co.id');
		Mail::send('tracebility.email.index', $tmmin, function($message) use ($penerima) {
		$message->to('imam@aiia.co.id')
					->subject('Traceability')
					->attach('../storage/traceability/print_part_tmiin.csv');
		$message->cc($penerima);
		$message->from('aisinbisa@aiia.co.id');
		});

		// Mail::to('handika@aiia.co.id')->send(new TmminReport($tmmin));
	}

}
