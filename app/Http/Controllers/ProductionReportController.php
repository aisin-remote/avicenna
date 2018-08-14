<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Models\Avicenna\avi_running_hours;
use Illuminate\Support\Facades\Input;
use Maatwebsite\Excel\Facades\Excel;	

class ProductionReportController extends Controller
{
    public function index()
    {	
    	$date = \Carbon\Carbon::now()->format('Y-m-d');
    	$hours = avi_running_hours::select('*')->where('date','2018-08-06')->get();
        return view('avicenna/production/productionreport', compact('hours'));
    }

    public function getindex()
    {
        $date = \Carbon\Carbon::now()->format('Y-m-d');
	    $hours = avi_running_hours::select('*')->where('date',$date);
	    return Datatables::of($hours)
	        ->addIndexColumn()
	        ->make(true);
    }

    public function filter()
    {
    	$filter = Input::all();
    	$date 	= $filter['date'];
    	$line 	= $filter['line'];
		$hours = avi_running_hours::select('*')->where('date',$date)->where('line',$line)->get();
        return view('avicenna/production/productionreport', compact('hours'));
    }

    public function exportexcel()
    {
    	$filter = Input::all();
    	$date 	= $filter['date'];
    	$line 	= $filter['line'];
		$hours = avi_running_hours::select('*')->where('date', $date)->where('line', $line)->get();
	    Excel::load('/storage/template/g2ms_(Pagi).xlsx',  function($file) use($hours){

	    	$row = "4";
	    	foreach ($hours as $result) {
	    		$back_number	= $result->back_number;
	    		$part_number	= $result->part_number;
	    		$ct 			= $result->ct;
	    		$qty_6 			= $result->qty_6;
	    		$time_6			= $result->time_6;
	    		$qty_7 			= $result->qty_7;
	    		$time_7			= $result->time_7;
	    		$qty_8 			= $result->qty_8;
	    		$time_8			= $result->time_8;
	    		$qty_9 			= $result->qty_9;
	    		$time_9			= $result->time_9;
	    		$qty_10 		= $result->qty_10;
	    		$time_10		= $result->time_10;
	    		$qty_11 		= $result->qty_11;
	    		$time_11		= $result->time_11;
	    		$qty_12 		= $result->qty_12;
	    		$time_12		= $result->time_12;
	    		$qty_13 		= $result->qty_13;
	    		$time_13		= $result->time_13;
	    		$qty_14 		= $result->qty_14;
	    		$time_14		= $result->time_14;
	    		$qty_15 		= $result->qty_15;
	    		$time_15		= $result->time_15;
	    		$qty_16 		= $result->qty_16;
	    		$time_16		= $result->time_16;
	    		$qty_17 		= $result->qty_17;
	    		$time_17		= $result->time_17;
	    		$qty_18 		= $result->qty_18;
	    		$time_18		= $result->time_18;

	    		$file->setActiveSheetIndex(0)->setCellValue('A'.$row.'', $part_number);
	    		$file->setActiveSheetIndex(0)->setCellValue('B'.$row.'', $ct);
                $file->setActiveSheetIndex(0)->setCellValue('C'.$row.'', $qty_6);
                $file->setActiveSheetIndex(0)->setCellValue('D'.$row.'', $time_6);
                $file->setActiveSheetIndex(0)->setCellValue('E'.$row.'', $qty_7);
                $file->setActiveSheetIndex(0)->setCellValue('F'.$row.'', $time_7);
                $file->setActiveSheetIndex(0)->setCellValue('G'.$row.'', $qty_8);
                $file->setActiveSheetIndex(0)->setCellValue('H'.$row.'', $time_8);
	    		$file->setActiveSheetIndex(0)->setCellValue('I'.$row.'', $qty_9);
                $file->setActiveSheetIndex(0)->setCellValue('J'.$row.'', $time_9);
                $file->setActiveSheetIndex(0)->setCellValue('K'.$row.'', $qty_10);
                $file->setActiveSheetIndex(0)->setCellValue('L'.$row.'', $time_10);
                $file->setActiveSheetIndex(0)->setCellValue('M'.$row.'', $qty_11);
                $file->setActiveSheetIndex(0)->setCellValue('N'.$row.'', $time_11);
                $file->setActiveSheetIndex(0)->setCellValue('O'.$row.'', $qty_12);
                $file->setActiveSheetIndex(0)->setCellValue('P'.$row.'', $time_12);
                $file->setActiveSheetIndex(0)->setCellValue('Q'.$row.'', $qty_13);
	    		$file->setActiveSheetIndex(0)->setCellValue('R'.$row.'', $time_13);
                $file->setActiveSheetIndex(0)->setCellValue('S'.$row.'', $qty_14);
                $file->setActiveSheetIndex(0)->setCellValue('T'.$row.'', $time_14);
                $file->setActiveSheetIndex(0)->setCellValue('U'.$row.'', $qty_15);
                $file->setActiveSheetIndex(0)->setCellValue('V'.$row.'', $time_15);
                $file->setActiveSheetIndex(0)->setCellValue('W'.$row.'', $qty_16);
                $file->setActiveSheetIndex(0)->setCellValue('X'.$row.'', $time_16);
                $file->setActiveSheetIndex(0)->setCellValue('Y'.$row.'', $qty_17);
                $file->setActiveSheetIndex(0)->setCellValue('Z'.$row.'', $time_17);

                $row++;
	    	}
	    })->setFilename("G2MS")->export('xlsx');
	}



}
