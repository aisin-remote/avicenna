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
use Yajra\Datatables\Datatables;

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
    function index($type){
        return view('tracebility.list.'.$type.'');
    }
    public function castingAjaxdata(){

    $list           = avi_trace_casting::select('line')->groupby('line');
    return Datatables::of($list)
            ->addColumn('shift_1', function($list) {
                            $shift_1 = avi_trace_casting::where('line', $list->line)->where('date', date('Y-m-d'))->count();
                            return  '--No Data--';
                        })
            ->addColumn('shift_2', function($list)  {
                            return  '--No Data--';
                        })
            ->addColumn('shift_3', function($list) {
                            return  '--No Data--';
                        })
            ->addColumn('total', function($list) {
                            $total = avi_trace_casting::where('line', $list->line)->where('date', date('Y-m-d'))->count();
                            return $total;
                        })

            ->addIndexColumn()
            ->make(true);
        
    }
    public function machiningAjaxdata(){

    $list           = avi_trace_machining::select('line')->groupby('line');
    return Datatables::of($list)
            ->addColumn('shift_1', function($list) {
                            $shift_1 = avi_trace_casting::where('line', $list->line)->where('date', date('Y-m-d'))->count();
                            return  '--No Data--';
                        })
            ->addColumn('shift_2', function($list)  {
                            return  '--No Data--';
                        })
            ->addColumn('shift_3', function($list) {
                            return  '--No Data--';
                        })
            ->addColumn('total', function($list) {
                            $total = avi_trace_machining::where('line', $list->line)->where('date', date('Y-m-d'))->count();
                            return $total;
                        })
            ->addIndexColumn()
            ->make(true);
        
    }
    public function deliveryAjaxdata(){

    $list           = avi_trace_delivery::select('cycle')->groupby('cycle');
    return Datatables::of($list)
            ->addColumn('customer', function($list) {
                            $customer = avi_trace_delivery::select('customer')->where('cycle', $list->cycle)->first();
                            return $customer->customer;
                        })
            ->addColumn('cycle', function($list) {
                            $cycle = avi_trace_cycle::select('name')->where('code', $list->cycle)->first();
                            return $cycle->name;
                        })
            ->addColumn('total', function($list) {
                            $total = avi_trace_delivery::where('cycle', $list->cycle)->where('date', date('Y-m-d'))->count();
                            return $total;
                        })

            ->addIndexColumn()
            ->make(true);
        
    }
}
