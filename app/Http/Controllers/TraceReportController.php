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
  //   public function traceviewreport($id_product)
  //   {	
  //       $file           = "xl_barcode.xlsx";
  //   	$code 			= $id_product;
		// $a 				= substr($id_product, 0, 2);
		// $part 			= avi_trace_program_number::select('*')->where('code', $a)->first();

  //       return $part;

	 //    Excel::load('/storage/template/xl_barcode.xlsx',  function($file) use($part, $id_product){
  //   		$part_number	= $part->part_number;
  //   		$model 			= $part->product;
  //   		$part_name 		= $part->part_name;

  //   		$file->setActiveSheetIndex(0)->setCellValue('A2', $id_product);
  //   		$file->setActiveSheetIndex(0)->setCellValue('C9', $id_product);
  //   		$file->setActiveSheetIndex(0)->setCellValue('C10', $part_number);
  //   		$file->setActiveSheetIndex(0)->setCellValue('C11', $model);
  //   		$file->setActiveSheetIndex(0)->setCellValue('A12', $part_name);

		// })->export('xlsx');
  //   }

    public function traceviewreport($id_product)
    {
        $file           = "xl_barcode";
        $code           = $id_product;
        $a              = substr($id_product, 0, 2);
        $part           = avi_trace_program_number::where('code', $a)->first();

        ob_end_clean();
        ob_start();
        Excel::load('/storage/template/'.$file.'.xlsx', function($file) use($part, $id_product){
            $part_number    = $part->part_number;
            $model          = $part->product;
            $part_name      = $part->part_name;

            $file->setActiveSheetIndex(0)->setCellValue('A2', $id_product);
            $file->setActiveSheetIndex(0)->setCellValue('C9', $id_product);
            $file->setActiveSheetIndex(0)->setCellValue('C10', $part_number);
            $file->setActiveSheetIndex(0)->setCellValue('C11', $model);
            $file->setActiveSheetIndex(0)->setCellValue('A12', $part_name);    
        })->export('xlsx');
    }
}
