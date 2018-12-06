<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Avicenna\avi_trace_casting;
use App\Models\Avicenna\avi_trace_machining;
use App\Models\Avicenna\avi_trace_delivery;
use App\Models\Avicenna\avi_trace_machine_tonase;
use App\Models\Avicenna\avi_trace_program_number;
use App\Models\Avicenna\avi_trace_cycle;

class TraceReportController extends Controller
{
    public function traceviewreport($id_product)
    {	
    	$code 			= $id_product;
		$a 				= substr($id_product, 0, 2);
		$part 			= avi_trace_program_number::select('*')->where('code', $a)->first();

	    Excel::load('/storage/template/xl_barcode.xlsx',  function($file) use($part, $id_product){
    		$part_number	= $part->part_number;
    		$model 			= $part->product;
    		$part_name 		= $part->part_name;

    		$file->setActiveSheetIndex(0)->setCellValue('A2', $id_product);
    		$file->setActiveSheetIndex(0)->setCellValue('C9', $id_product);
    		$file->setActiveSheetIndex(0)->setCellValue('C10', $part_number);
    		$file->setActiveSheetIndex(0)->setCellValue('C11', $model);
    		$file->setActiveSheetIndex(0)->setCellValue('A12', $part_name);

		})->setFilename($id_product)->export('xlsx');
    }
}
