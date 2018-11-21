<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use Storage;
use App\Models\Avicenna\avi_trace_casting;
use App\Models\Avicenna\avi_trace_cycle;
use App\Models\Avicenna\avi_trace_machining;
use App\Models\Avicenna\avi_trace_delivery;
use App\Models\Avicenna\avi_trace_printer;
use App\Models\Avicenna\avi_trace_program_number;
use App\Models\Avicenna\avi_trace_ng_casting_temp;
use Illuminate\Support\Facades\Cache;
use Datatables;

class TraceScanController extends Controller
{

// MODUL CASTING

    public function scancasting($line)
    {
        // $customer = avi_customers::all();
        return view('tracebility/casting/scan',compact('line'));
    }

    public function getAjaxcasting($number, $line)
    {
        // dev-1.0, Ferry, 20170926, Normalisasi string barcode
        try{

        $cek 	= avi_trace_casting::where('code', $number)->first();

        if (is_null($cek)) {

        	DB::beginTransaction();
                $user           			= Auth::user();
                $scan 						= new avi_trace_casting;
                $scan->code 		        = $number;
                $scan->date 		        = date('Y-m-d');
                $scan->line                 = $line;
                $scan->npk     		        = $user->npk;
                $scan->status               = 1;
                $scan->save();
                DB::commit();

                // dev-1.0.0, Handika, 20180724, counter
                $counter = avi_trace_casting::where('date', date('Y-m-d'))
                                        ->where('npk', $user->npk)
                                        ->count();

                // dev-1.0.0, Handika, 20180724, 10 last scan
                $last_scan = avi_trace_casting::selectRaw('code')
                                            ->orderBy('created_at', 'desc')
                                            ->take(10)
                                            ->get();
                $arrJSON = array(
                                "code"		=> $number,
                                "counter"   => $counter,
                                "last_scan" => $last_scan
                        );

                return $arrJSON;       	
        }else{ 
				// return response()->json($part);      // dev-1.0, Ferry, Commented ganti yg lebih bersih
	            return array("code" => "");      	
        }               
           
        }catch(\Exception $e){

         DB::rollBack();
            return array( "code" => "", "error" => $e->getMessage() );
        }
        

    }
    
    public function castingng($line)
    {
        return view('tracebility/casting/ng',compact('line'));
    }

    public function getAjaxcastingng($number, $date, $line)
    {
        try{
            \DB::beginTransaction();

            $user = Auth::user();
            $npk  = $user->npk;

            $temp               = new avi_trace_ng_casting_temp ;
            $temp->code         = $number ;
            $temp->npk          = $npk ;
            $temp->line         = $line ;
            $temp->date         = $date ;
            $temp->save();

            \DB::commit();
            $arrJSON = array(
                                "code"      => $number,
                        );

            return $arrJSON;
                    
        }catch(\Exception $e){

         DB::rollBack();
            return array( "code" => "", "error" => $e->getMessage() );
        }
        

    }
    public function getDatacastingng()
    {
        $npk        =   Auth::user()->npk;
        // $data       =   avi_trace_ng_casting_temp::select('id','code','npk','date')
        //                 ->where('npk', $npk)->get();
        $data = avi_trace_ng_casting_temp::all();
        return Datatables::of($data)
        ->make();
        // return Datatables::of($data)
        //         ->addColumn('action', function($data) {
        //             $btn_action = 
        //                             '<div style="text-align:center;">
        //                                 <span type="button" class="btn btn-sm bg-maroon" 
        //                                         data-toggle="modal" data-target="#modal-delete" 
        //                                         onclick="$(\'#btn-delete\').val(' . $data->id . ')">
        //                                     <i class="fa fa-times"></i> Delete
        //                                 </span>
        //                             </div>';
        //                         return $btn_action;
        //         })
               
        //         ->addIndexColumn()
        //         ->make(true);

    }


// MODUL DELIVERY

    public function scandelivery()
    {
        //
        // $customer = avi_customers::all();
        return view('tracebility/delivery/scan');
    }

    public function getAjaxdelivery($number, $wimcycle, $customer)
    {
        try{

        $cek    = avi_trace_delivery::where('code', $number)->first();

        if (is_null($cek)) {

            DB::beginTransaction();
                $user                       = Auth::user();
                $scan                       = new avi_trace_delivery;
                $scan->code                 = $number;
                $scan->cycle                = $wimcycle;
                $scan->customer             = $customer;
                $scan->date                 = date('Y-m-d');
                $scan->npk                  = $user->npk;
                $scan->save();
                DB::commit();

                $arrJSON = array(
                                "code"      => $number,
                        );

                return $arrJSON;        
        }else{ 
                // return response()->json($part);      // dev-1.0, Ferry, Commented ganti yg lebih bersih
                return array("code" => "");         
        }               
           
        }catch(\Exception $e){

         DB::rollBack();
            return array( "code" => "", "error" => $e->getMessage() );
        }
        

    }
    public function getAjaxcycle($code)
    {
                // dev-1.0.0, Handika, 20180724, cycle
                $user      = Auth::user();

                $code = avi_trace_cycle::where('code', $code)->first();

                return array( "cycle" => $code->name ); 
    }


// MODULE MACHINING

    public function scanmachining($line)
    {
        return view('tracebility/machining/scan',compact('line'));
    }

    public function getAjaxmachining($number, $line)
    {
        try{

        $cek    = avi_trace_machining::where('code', $number)->first();

        if (is_null($cek)) {

            DB::beginTransaction();
                $user                       = Auth::user();
                $scan                       = new avi_trace_machining;
                $scan->code                 = $number;
                $scan->date                 = date('Y-m-d');
                $scan->line                 = $line;
                $scan->npk                  = $user->npk;
                $scan->save();

                // dev-1.0.0, Handika, 20180724, counter
                $counter = avi_trace_machining::where('date', date('Y-m-d'))
                                        ->where('npk', $user->npk)
                                        ->count();

                // dev-1.0.0, Handika, 20180724, 10 last scan
                $last_scan = avi_trace_machining::selectRaw('code')
                                            ->orderBy('created_at', 'desc')
                                            ->take(10)
                                            ->get();
                                        $last_scan = "0";
                $arrJSON = array(
                                "code"      => $number,
                                "counter"   => $counter,
                                "last_scan" => $last_scan
                        );
                
                $a                          = substr($number, 0, 2);
                $product                    = avi_trace_program_number::select('*')->where('code', $a)->first();
                    if (is_null($product)){
                            $product                = new avi_trace_program_number();
                            $product->part_number   = "No Data";
                            $product->back_number   = "No Data";
                            $product->part_name     = "No Data";
                    }
                $printer                    = avi_trace_printer::where('line', $line)->first();
                $printer->part_code         = $number;
                $printer->part_number       = $product->part_number;
                $printer->back_number       = $product->back_number;
                $printer->part_name         = $product->part_name;
                $printer->flag              = 0;
                $printer->save();
                DB::commit();

                return $arrJSON;        
        }else{ 
                // return response()->json($part);      // dev-1.0, Ferry, Commented ganti yg lebih bersih
                return array("code" => "");         
        }               
           
        }catch(\Exception $e){

         DB::rollBack();
            return array( "code" => "", "error" => $e->getMessage() );
        }
        

    }
}