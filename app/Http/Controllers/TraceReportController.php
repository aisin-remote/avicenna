<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Avicenna\avi_trace_casting;
use App\Models\Avicenna\avi_trace_machining;
use App\Models\Avicenna\avi_trace_assembling;
use App\Models\Avicenna\avi_trace_delivery;
use App\Models\Avicenna\avi_trace_program_number;
use App\Models\Avicenna\avi_trace_cycle;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\DB;

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

    		$file->setActiveSheetIndex(0)->setCellValue('A2', '*'.$id_product.'*');
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
                ->addColumn('date', function($list) {

                                $date       = \Carbon\Carbon::now()->format('Y-m-d');
                                return  $date;
                            })
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

                                $date       = \Carbon\Carbon::now()->format('Y-m-d');
                                $yesterday  = \Carbon\Carbon::yesterday()->format('Y-m-d');
                                $now        = \Carbon\Carbon::now();

                                $start1     = \Carbon\Carbon::createFromTimestamp(strtotime($date . '06:00:00'));
                                $end1       = \Carbon\Carbon::createFromTimestamp(strtotime($date . '23:59:59'));

                                $start2     = \Carbon\Carbon::createFromTimestamp(strtotime($yesterday . '06:00:00'));
                                $end2       = \Carbon\Carbon::createFromTimestamp(strtotime($yesterday . '23:59:59'));

                                $start      = \Carbon\Carbon::createFromTimestamp(strtotime($date . '00:00:00'));
                                $end        = \Carbon\Carbon::createFromTimestamp(strtotime($date . '05:59:59'));

                                if ($now > $start && $now < $end ) {

                                    $shift_a    = avi_trace_casting::where('line', $list->line)->where('created_at','>',$start2)->where('created_at','<',$end2)->count();
                                    $shift_b    = avi_trace_casting::where('line', $list->line)->where('created_at','>',$start)->where('created_at','<',$end)->count();

                                    return  $shift_a + $shift_b ;
                                }else{
                                    $shift_3    = avi_trace_casting::where('line', $list->line)->where('created_at','>',$start1)->where('created_at','<',$end1)->count();
                                    return  $shift_3 ;
                                }

                            })

                ->addIndexColumn()
                ->make(true);

    }
    public function machiningAjaxdata(){

        $list           = avi_trace_machining::select('line')->groupby('line');

        return Datatables::of($list)
                ->addColumn('date', function($list) {

                                $date       = \Carbon\Carbon::now()->format('Y-m-d');
                                return  $date;
                            })
                ->addColumn('shift_1', function($list) {
                                $date       = \Carbon\Carbon::now()->format('Y-m-d');
                                $start      = \Carbon\Carbon::createFromTimestamp(strtotime($date  . ' 06:00:00'));
                                $end        = \Carbon\Carbon::createFromTimestamp(strtotime($date  . ' 14:14:59'));
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
                                $date       = \Carbon\Carbon::now()->format('Y-m-d');
                                $yesterday  = \Carbon\Carbon::yesterday()->format('Y-m-d');
                                $now        = \Carbon\Carbon::now();

                                $start1     = \Carbon\Carbon::createFromTimestamp(strtotime($date . '06:00:00'));
                                $end1       = \Carbon\Carbon::createFromTimestamp(strtotime($date . '23:59:59'));

                                $start2     = \Carbon\Carbon::createFromTimestamp(strtotime($yesterday . '06:00:00'));
                                $end2       = \Carbon\Carbon::createFromTimestamp(strtotime($yesterday . '23:59:59'));

                                $start      = \Carbon\Carbon::createFromTimestamp(strtotime($date . '00:00:00'));
                                $end        = \Carbon\Carbon::createFromTimestamp(strtotime($date . '05:59:59'));

                                if ($now > $start && $now < $end ) {

                                    $shift_a    = avi_trace_machining::where('line', $list->line)->where('created_at','>',$start2)->where('created_at','<',$end2)->count();
                                    $shift_b    = avi_trace_machining::where('line', $list->line)->where('created_at','>',$start)->where('created_at','<',$end)->count();

                                    return  $shift_a + $shift_b ;
                                }else{
                                    $shift_3    = avi_trace_machining::where('line', $list->line)->where('created_at','>',$start1)->where('created_at','<',$end1)->count();
                                    return  $shift_3 ;
                                }
                            })
                ->addIndexColumn()
                ->make(true);

    }
    public function assemblingAjaxdata(){

        $list           = avi_trace_assembling::select('line')->groupby('line');

        return Datatables::of($list)
                ->addColumn('date', function($list) {

                                $date       = \Carbon\Carbon::now()->format('Y-m-d');
                                return  $date;
                            })
                ->addColumn('shift_1', function($list) {
                                $date       = \Carbon\Carbon::now()->format('Y-m-d');
                                $start      = \Carbon\Carbon::createFromTimestamp(strtotime($date  . ' 06:00:00'));
                                $end        = \Carbon\Carbon::createFromTimestamp(strtotime($date  . ' 14:14:59'));
                                $shift_1    = avi_trace_assembling::where('line', $list->line)->where('created_at','>',$start)->where('created_at','<',$end)->count();
                                return  $shift_1;
                            })
                ->addColumn('shift_2', function($list)  {
                                $date       = \Carbon\Carbon::now()->format('Y-m-d');
                                $start      = \Carbon\Carbon::createFromTimestamp(strtotime($date . '14:15:00'));
                                $end        = \Carbon\Carbon::createFromTimestamp(strtotime($date . '22:14:59'));
                                $shift_2    = avi_trace_assembling::where('line', $list->line)->where('created_at','>',$start)->where('created_at','<',$end)->count();
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

                                    $shift_a    = avi_trace_assembling::where('line', $list->line)->where('created_at','>',$start1)->where('created_at','<',$end1)->count();
                                    $shift_b    = avi_trace_assembling::where('line', $list->line)->where('created_at','>',$start)->where('created_at','<',$end)->count();
                                    return  $shift_a + $shift_b ;
                                }else{
                                    $shift_3    = avi_trace_assembling::where('line', $list->line)->where('created_at','>',$start1)->where('created_at','<',$end1)->count();
                                    return  $shift_3 ;
                                }
                            })
                ->addColumn('total', function($list) {
                                $date       = \Carbon\Carbon::now()->format('Y-m-d');
                                $yesterday  = \Carbon\Carbon::yesterday()->format('Y-m-d');
                                $now        = \Carbon\Carbon::now();

                                $start1     = \Carbon\Carbon::createFromTimestamp(strtotime($date . '06:00:00'));
                                $end1       = \Carbon\Carbon::createFromTimestamp(strtotime($date . '23:59:59'));

                                $start2     = \Carbon\Carbon::createFromTimestamp(strtotime($yesterday . '06:00:00'));
                                $end2       = \Carbon\Carbon::createFromTimestamp(strtotime($yesterday . '23:59:59'));

                                $start      = \Carbon\Carbon::createFromTimestamp(strtotime($date . '00:00:00'));
                                $end        = \Carbon\Carbon::createFromTimestamp(strtotime($date . '05:59:59'));

                                if ($now > $start && $now < $end ) {

                                    $shift_a    = avi_trace_assembling::where('line', $list->line)->where('created_at','>',$start2)->where('created_at','<',$end2)->count();
                                    $shift_b    = avi_trace_assembling::where('line', $list->line)->where('created_at','>',$start)->where('created_at','<',$end)->count();

                                    return  $shift_a + $shift_b ;
                                }else{
                                    $shift_3    = avi_trace_assembling::where('line', $list->line)->where('created_at','>',$start1)->where('created_at','<',$end1)->count();
                                    return  $shift_3 ;
                                }
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

    public function getAjaxFilterMachiningDetail($start_date, $end_date){

        $list           = avi_trace_machining::select('line','date')
        ->where('date' , '>=' ,  $start_date )
        ->where('date' , '<=' ,  $end_date )
        ->groupby('line','date')
        ->orderby('line')
        ->orderby('date')
        ->get();

        return Datatables::of($list)

                ->addColumn('shift_1', function($list){

                                $temp       = avi_trace_machining::where('line', $list->line)->where('created_at','>=',$list->date.' 06:00:00')->where('created_at','<=',$list->date. ' 14:14:59')->count();

                                return  $temp;
                            })
                ->addColumn('shift_2', function($list){
                                $temp       = avi_trace_machining::where('line', $list->line)->where('created_at','>=',$list->date.' 14:15:00')->where('created_at','<=',$list->date. ' 22:14:59')->count();

                                return  $temp;
                            })
                ->addColumn('shift_3', function($list){

                                $besok = new \DateTime($list->date. ' 05:59:59');

                                $besok->modify('+1 day');

                                $temp       = avi_trace_machining::where('line', $list->line)->where('created_at','>=',$list->date.' 22:15:00')->where('created_at','<=',$besok)->count();

                                return  $temp;
                            })
                ->addColumn('total', function($list) {
                                $besok = new \DateTime($list->date. ' 05:59:59');

                                $besok->modify('+1 day');

                                $total = avi_trace_machining::where('line', $list->line)
                                ->where('created_at','>=',$list->date.' 06:00:00')
                                ->where('created_at','<=',$besok)
                                ->count();
                                return $total;
                            })

                ->addIndexColumn()
                ->make(true);
    }

    public function getAjaxFilterAssemblingDetail($start_date, $end_date){

        $list           = avi_trace_assembling::select('line','date')
        ->where('date' , '>=' ,  $start_date )
        ->where('date' , '<=' ,  $end_date )
        ->groupby('line','date')
        ->orderby('line')
        ->orderby('date')
        ->get();

        return Datatables::of($list)

                ->addColumn('shift_1', function($list){

                                $temp       = avi_trace_assembling::where('line', $list->line)->where('created_at','>=',$list->date.' 06:00:00')->where('created_at','<=',$list->date. ' 14:14:59')->count();

                                return  $temp;
                            })
                ->addColumn('shift_2', function($list){
                                $temp       = avi_trace_assembling::where('line', $list->line)->where('created_at','>=',$list->date.' 14:15:00')->where('created_at','<=',$list->date. ' 22:14:59')->count();

                                return  $temp;
                            })
                ->addColumn('shift_3', function($list){

                                $besok = new \DateTime($list->date. ' 05:59:59');

                                $besok->modify('+1 day');

                                $temp       = avi_trace_assembling::where('line', $list->line)->where('created_at','>=',$list->date.' 22:15:00')->where('created_at','<=',$besok)->count();

                                return  $temp;
                            })
                ->addColumn('total', function($list) {
                                $besok = new \DateTime($list->date. ' 05:59:59');

                                $besok->modify('+1 day');

                                $total = avi_trace_assembling::where('line', $list->line)
                                ->where('created_at','>=',$list->date.' 06:00:00')
                                ->where('created_at','<=',$besok)
                                ->count();
                                return $total;
                            })

                ->addIndexColumn()
                ->make(true);
    }

    public function getAjaxFilterCastingDetail($start_date, $end_date){

        $list           = avi_trace_casting::select('line','date')
        ->where('date' , '>=' ,  $start_date )
        ->where('date' , '<=' ,  $end_date )
        ->groupby('line','date')
        ->orderby('line')
        ->orderby('date')
        ->get();

        return Datatables::of($list)

                ->addColumn('shift_1', function($list){

                                $temp       = avi_trace_casting::where('line', $list->line)->where('created_at','>=',$list->date.' 06:00:00')->where('created_at','<=',$list->date. ' 14:14:59')->count();

                                return  $temp;
                            })
                ->addColumn('shift_2', function($list){
                                $temp       = avi_trace_casting::where('line', $list->line)->where('created_at','>=',$list->date.' 14:15:00')->where('created_at','<=',$list->date. ' 22:14:59')->count();

                                return  $temp;
                            })
                ->addColumn('shift_3', function($list){

                                $besok = new \DateTime($list->date. ' 05:59:59');

                                $besok->modify('+1 day');

                                $temp       = avi_trace_casting::where('line', $list->line)->where('created_at','>=',$list->date.' 22:15:00')->where('created_at','<=',$besok)->count();

                                return  $temp;
                            })
                ->addColumn('total', function($list) use($start_date, $end_date){
                        $besok = new \DateTime($list->date. ' 05:59:59');

                        $besok->modify('+1 day');

                        $total = avi_trace_casting::where('line', $list->line)
                        ->where('created_at','>=',$list->date.' 06:00:00')
                        ->where('created_at','<=',$besok)
                        ->count();
                        return $total;
                    })

                ->addIndexColumn()
                ->make(true);
    }

    public function getAjaxFilterDeliveryDetail($start_date, $end_date){
        $list           = avi_trace_delivery::select('cycle')
        ->where('date' , '>=' ,  $start_date )
        ->where('date' , '<=' ,  $end_date )
        ->groupby('cycle')
        ->get();

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

    /**
     * Export trace data
     */
    public function exportCollectionIndex()
    {
        $lines = config('traceability.production_lines');

        return view('tracebility.export_collection.index', compact('lines'));
    }

    /**
     * Export trace data to excel
     */
    public function exportCollection(Request $request)
    {
        $startDate = $request->start_date;
        $endDate = $request->end_date;
        $line = $request->line;

        $existingLine = config('traceability.production_lines');

        if (!in_array($line, $existingLine)) {
            abort(400);
        }

        // hardcode line to get tablename
        $prefixLine = strtolower(substr($line, 0, 2));

        switch ($prefixLine) {
            case 'dc':
                $tableName = 'avi_trace_casting';
                break;

            case 'ma':
                $tableName = 'avi_trace_machining';
                break;

            case 'as':
                $tableName = 'avi_trace_assemblings';
                break;

            case 'pp':
                $tableName = 'avi_trace_delivery';
                break;

            default:
                abort (400);
                break;
        }

        // use query builder
        $data = DB::table($tableName)
            ->select('code')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->where('line', $line)
            ->pluck('code')->toArray();

        $data = DB::table('avi_trace_casting as atc')
            ->select('atc.code', 'atc.npk as mp_casting', 'atm.npk as mp_ma', 'ata.npk as mp_as', 'atd.npk as mp_pulling', 'atc.created_at as scan_at_casting', 'atm.created_at as scan_at_ma', 'ata.created_at as scan_at_as', 'atd.created_at as scan_at_delivery')
            ->leftJoin('avi_trace_machining as atm', 'atm.code', '=', 'atc.code')
            ->leftJoin('avi_trace_assemblings as ata', 'atm.code', '=', 'ata.code')
            ->leftJoin('avi_trace_delivery as atd', 'atm.code', '=', 'atd.code')
            ->whereIn('atc.code', $data)
            ->get()->toJson();

        ob_end_clean();
        ob_start();
        return Excel::create('TRACE_' . $line . '_' . date('Y-m-d', strtotime($startDate)) . '_' . date('Y-m-d', strtotime($endDate)), function($excel) use ($data){
            $excel->sheet('TRACEABILITY', function($sheet) use ($data) {
                $sheet->fromArray(json_decode($data, true));
            });
        })->export('xlsx');
    }
}
