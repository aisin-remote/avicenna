<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use Storage;
use App\Models\Avicenna\avi_trace_casting;
use App\Models\Avicenna\avi_trace_machining;
use App\Models\Avicenna\avi_trace_delivery;
use App\Models\Avicenna\avi_trace_printer;

class TraceScanController extends Controller
{
    //
    public function scan()
    {
        //
        // $customer = avi_customers::all();
        return view('tracebility/casting/scan');
    }

    public function getAjax($number)
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
                $scan->npk     		        = $user->npk;
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
    public function getAjax2()
    {
        

                // dev-1.0.0, Handika, 20180724, 10 last scan

                $user      = Auth::user();
                $last_scan = avi_trace_casting::selectRaw('*')
                							->where('npk', $user->npk)
                                            ->orderBy('created_at', 'desc')
                                            ->take(10)
                                            ->get();

                return $last_scan;       	
    }

    public function scandelivery()
    {
        //
        // $customer = avi_customers::all();
        return view('tracebility/delivery/scan');
    }

    public function getAjaxdelivery($number, $wimcycle, $customer)
    {
        // dev-1.0, Ferry, 20170926, Normalisasi string barcode
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
    public function scanmachining($line)
    {
        return view('tracebility/machining/scan',compact('line'));
    }

    public function getAjaxmachining($number, $line)
    {
        // dev-1.0, Ferry, 20170926, Normalisasi string barcode
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
                DB::commit();

                // dev-1.0.0, Handika, 20180724, counter
                $counter = avi_trace_machining::where('date', date('Y-m-d'))
                                        ->where('npk', $user->npk)
                                        ->count();

                // dev-1.0.0, Handika, 20180724, 10 last scan
                $last_scan = avi_trace_machining::selectRaw('code')
                                            ->orderBy('created_at', 'desc')
                                            ->take(10)
                                            ->get();
                $arrJSON = array(
                                "code"      => $number,
                                "counter"   => $counter,
                                "last_scan" => $last_scan
                        );

                $printer                    = avi_trace_printer::where('line', $line)->first();
                $printer->part_code         = $number;
                $printer->flag              = 1;
                $printer->save();

                // $fd = $data;
                // $hn = printer_open("HP LaserJet P2050 Series PCL6");
                // printer_set_option($hn, PRINTER_MODE, "RAW");
                // printer_write($hn, $fd);
                // printer_close($hn);

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
