<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use Storage;
use App\Models\Avicenna\avi_trace_casting;

class TraceScanController extends Controller
{
    //
    public function scan()
    {
        //
        // $customer = avi_customers::all();
        return view('tracebility/scan/index');
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
}
