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
use \Carbon;

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
                            $date       = \Carbon\Carbon::now()->format('Y-m-d');
                            $start      = \Carbon\Carbon::createFromTimestamp(strtotime($date . '06:00:00'));
                            $end        = \Carbon\Carbon::createFromTimestamp(strtotime($date . '14:14:59'));
                            $shift_1    = avi_trace_casting::where('line', $list->line)->where('created_at','>',$start)->where('created_at','<',$end)->count();
                            return  $shift_1;
                        })
            ->addColumn('shift_2', function($list)  {
                            $date       = \Carbon\Carbon::now()->format('Y-m-d');
                            $start      = \Carbon\Carbon::createFromTimestamp(strtotime($date . '14:15:00'));
                            $end        = \Carbon\Carbon::createFromTimestamp(strtotime($date . '22:14:59'));
                            $shift_2    = avi_trace_casting::where('line', $list->line)->where('created_at','>',$start)->where('created_at','<',$end)->count();
                            return  $shift_2;
                        })
            ->addColumn('shift_3', function($list) {
                            $date       = \Carbon\Carbon::now()->format('Y-m-d');
                            $yesterday  = \Carbon\Carbon::yesterday()->format('Y-m-d');
                            $now        = \Carbon\Carbon::now();

                            $start1     = \Carbon\Carbon::createFromTimestamp(strtotime($date . '22:14:59'));
                            $end1       = \Carbon\Carbon::createFromTimestamp(strtotime($date . '23:59:59'));

                            $start2     = \Carbon\Carbon::createFromTimestamp(strtotime($yesterday . '22:14:59'));
                            $end2       = \Carbon\Carbon::createFromTimestamp(strtotime($yesterday . '23:59:59'));

                            $start      = \Carbon\Carbon::createFromTimestamp(strtotime($date . '00:00:00'));
                            $end        = \Carbon\Carbon::createFromTimestamp(strtotime($date . '05:59:59'));

                            if ($now > $start && $now < $end ) {

                                $shift_a    = avi_trace_casting::where('line', $list->line)->where('created_at','>',$start1)->where('created_at','<',$end1)->count();
                                $shift_b    = avi_trace_casting::where('line', $list->line)->where('created_at','>',$start)->where('created_at','<',$end)->count();
                                return  $shift_a + $shift_b ;
                            }else{
                                $shift_3    = avi_trace_casting::where('line', $list->line)->where('created_at','>',$start1)->where('created_at','<',$end1)->count();
                                return  $shift_3 ;
                            }
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
                            $date       = \Carbon\Carbon::now()->format('Y-m-d');
                            $start      = \Carbon\Carbon::createFromTimestamp(strtotime($date . '06:00:00'));
                            $end        = \Carbon\Carbon::createFromTimestamp(strtotime($date . '14:14:59'));
                            $shift_1    = avi_trace_machining::where('line', $list->line)->where('created_at','>',$start)->where('created_at','<',$end)->count();
                            return  $shift_1;
                        })
            ->addColumn('shift_2', function($list)  {
                            $date       = \Carbon\Carbon::now()->format('Y-m-d');
                            $start      = \Carbon\Carbon::createFromTimestamp(strtotime($date . '14:15:00'));
                            $end        = \Carbon\Carbon::createFromTimestamp(strtotime($date . '22:14:59'));
                            $shift_2    = avi_trace_machining::where('line', $list->line)->where('created_at','>',$start)->where('created_at','<',$end)->count();
                            return  $shift_2;
                        })
            ->addColumn('shift_3', function($list) {
                            $date       = \Carbon\Carbon::now()->format('Y-m-d');
                            $yesterday  = \Carbon\Carbon::yesterday()->format('Y-m-d');
                            $now        = \Carbon\Carbon::now();

                            $start1     = \Carbon\Carbon::createFromTimestamp(strtotime($date . '22:14:59'));
                            $end1       = \Carbon\Carbon::createFromTimestamp(strtotime($date . '23:59:59'));

                            $start2     = \Carbon\Carbon::createFromTimestamp(strtotime($yesterday . '22:14:59'));
                            $end2       = \Carbon\Carbon::createFromTimestamp(strtotime($yesterday . '23:59:59'));

                            $start      = \Carbon\Carbon::createFromTimestamp(strtotime($date . '00:00:00'));
                            $end        = \Carbon\Carbon::createFromTimestamp(strtotime($date . '05:59:59'));

                            if ($now > $start && $now < $end ) {

                                $shift_a    = avi_trace_machining::where('line', $list->line)->where('created_at','>',$start1)->where('created_at','<',$end1)->count();
                                $shift_b    = avi_trace_machining::where('line', $list->line)->where('created_at','>',$start)->where('created_at','<',$end)->count();
                                return  $shift_a + $shift_b ;
                            }else{
                                $shift_3    = avi_trace_machining::where('line', $list->line)->where('created_at','>',$start1)->where('created_at','<',$end1)->count();
                                return  $shift_3 ;
                            }
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
