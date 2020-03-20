<?php

namespace App\Http\Controllers;

use App\Models\Avicenna\avi_dowa_process;
use Illuminate\Http\Request;
use DB;
use Auth;
use Storage;
use App\Models\Avicenna\avi_trace_casting;
use App\Models\Avicenna\avi_trace_assembling;
use App\Models\Avicenna\avi_trace_cycle;
use App\Models\Avicenna\avi_trace_machining;
use App\Models\Avicenna\avi_trace_delivery;
use App\Models\Avicenna\avi_trace_printer;
use App\Models\Avicenna\avi_trace_program_number;
use App\Models\Avicenna\avi_trace_ng_casting_temp;
use Illuminate\Support\Facades\Cache;
use Datatables;
use GuzzleHttp\Client;

class TraceScanController extends Controller
{

// MODUL CASTING
//=======================================================================================================================================================

    public function scancasting()
    {
        return view('tracebility/casting/scan');
    }

    public function getAjaxcasting($number, $line)
    {
        // dev-1.0, Ferry, 20170926, Normalisasi string barcode
        try{

        $cek        = avi_trace_casting::where('code', $number)->first();

        if (is_null($cek)) {

        	DB::beginTransaction();
                $user           			= Auth::user();
                $scan 						= new avi_trace_casting;
                $scan->code 		        = $number;
                $scan->date 		        = date('Y-m-d');
                $scan->line                 = $line;
                $scan->npk     		        = $user->npk;
                $scan->status               = 1;
                $a                          = substr($number, 0, 2);
                $product                    = avi_trace_program_number::where('code', $a)->first();
                if (is_null($product)){
                        // $product                = new avi_trace_program_number();
                        return "Not OPN 889F Model";
                }
                $scan->save();

                DB::commit();

                $key = 'casting_'.$user->npk;
                if (Cache::has($key)) {
                    $cache = Cache::get($key);

                    if(!isset($cache[date('Y-m-d')])) {
                        $cache = [];
                        $cache = [
                            date('Y-m-d') => [
                                'counter' => 1,
                                'items' => [
                                    $number
                                ]
                            ]
                        ];
                    } else {
                        $cache[date('Y-m-d')]['counter'] += 1;
                        if (count($cache[date('Y-m-d')]['items']) >= 10) {
                            unset($cache[date('Y-m-d')]['items'][0]);
                        }
                        $cache[date('Y-m-d')]['items'][] = $number;
                        $cache[date('Y-m-d')]['items'] = array_values($cache[date('Y-m-d')]['items']);
                    }
                } else {
                    $cache = [
                        date('Y-m-d') => [
                            'counter' => 1,
                            'items' => [
                                $number
                            ]
                        ]
                    ];
                }

                Cache::forever($key, $cache);
                $arrJSON = array(
                                "code"		=> $number,
                                "counter"   => $cache[date('Y-m-d')]['counter']
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
    }
    public function getAjaxcastingtable(){
        $create= New avi_trace_casting();
        $create->code = 'No Data';
        $create->npk = 'No Data';
        $create->date = 'No Data';
        $arrayku=array($create);
        return Datatables::of($arrayku)
            ->addColumn('product', function($create) {
                return 'No Data';
            })
            ->addColumn('model', function($create) {

                return 'No Data';
            })
                ->addIndexColumn()
                ->make(true);
    }
    public function getAjaxcastingupdate(){
        $user                       = Auth::user();
        $create= avi_trace_casting::select('code','npk','date')
                ->where('npk', $user->npk)
                ->where('date', date('Y-m-d'))
                ->take(5)
                ->orderBy('id', 'DESC')
                ->get();
        return Datatables::of($create)
                ->addColumn('product', function($create) {

                    $codes  = $create->code ;
                    $code   = substr($create->code, 0, 2);
                    $models = avi_trace_program_number::select('product')->where('code', $code)->first();
                    return $models ? $models->product : '--No Product--';
                })
                ->addColumn('model', function($create) {

                    $codes  = $create->code ;
                    $code   = substr($create->code, 0, 2);
                    $models = avi_trace_program_number::select('back_number')->where('code', $code)->first();
                    return $models ? $models->back_number : '--No Back Number--';
                })
                ->addIndexColumn()
                ->make(true);

    }

// MODUL CASTING DOWA
//=======================================================================================================================================================
    public function scanCastingDowa()
    {
        return view('tracebility/casting/scan-dowa');
    }

    public function checkCodeCastingDowa(Request $request) {
        $codes = $request->all();
        $type = $codes['type'];
        $code = $codes['code'];
        if ($type == 'kbnint') {
            $codesubstr = substr($code,123,4);
            $data = avi_dowa_process::select('kbn_int_casting', 'kbn_supply')->where('kbn_int_casting', $codesubstr)->first();
            if ($data == null) {
                return array(
                    "type" => $type,
                    "code" => $code,
                    "codesubstr" => $codesubstr
                );
            } else if($data->kbn_int_casting != null && $data->kbn_customer != null) {
                return array(
                    "type" => $type,
                    "code" => $code,
                    "codesubstr" => $codesubstr
                );
            } else if($data->kbn_int_casting != null && $data->kbn_customer == null) {
                return array(
                    "type" => $type,
                    "code" => "false",
                    "codesubstr" => $codesubstr
                );
            }
        } elseif ($type == 'code') {
            $substr                     = substr($code, 0, 2);
            $product                    = avi_trace_program_number::where('code', $substr)->first();
            if (is_null($product)){
                return array(
                    "type" => $type,
                    "code" => "unregistered",
                    "codesubstr" => $code
                );
            }
            $data = avi_dowa_process::select('code')->where('code', $code)->first();
            if ($data) {
                return array(
                    "type" => $type,
                    "code" => "false",
                    "codesubstr" => $code
                );
            } else {
                return array(
                    "type" => $type,
                    "code" => $code,
                    "codesubstr" => $code
                );
            }
        } else {
            return "salah";
        }
    }

    public function inputCodeCastingDowa(Request $request) {
        $user = Auth::user()->npk;
        $code = $request->all();
        $partcodes = $code['code'];
        $line = $code['line'];
        $kbn_int = $code['kbn_int'];
        foreach ($partcodes as $key => $value) {
            $dataCasting = array(
                'code'=>$value,
                'npk'=>$user,
                'line'=>$line,
                'status'=>"1",
                'date'=>date('Y-m-d')
            );
            $dataCastingDowa = array(
                'code'=>$value,
                'kbn_int_casting'=>$kbn_int
            );
            // $key = 'casting_dowa'.$line;
            // if (Cache::has($key)) {
            //     $cache = Cache::get($key);

            //     if(!isset($cache[date('Y-m-d')])) {
            //         $cache = [];
            //         $cache = [
            //             date('Y-m-d') => [
            //                 'counter' => 1
            //             ]
            //         ];
            //     } else {
            //         $cache[date('Y-m-d')]['counter'] += 1;
            //     }
            // } else {
            //     $cache = [
            //         date('Y-m-d') => [
            //             'counter' => 1
            //         ]
            //     ];
            // }

            // Cache::forever($key, $cache);
            try {
                DB::beginTransaction();
                $casting = avi_trace_casting::create($dataCasting);
                $dowaProcess = avi_dowa_process::create($dataCastingDowa);
                DB::commit();
            } catch (\Throwable $th) {
                DB::rollBack();
                return [
                    "status" => "error",
                    "messege" => "Data Not Saved, Please Rescan Part & Kanban"
                ];
            }
        };
        return [
            "status" => "success",
            // "counter"   => $cache[date('Y-m-d')]['counter']
        ];
    }

    //MODUL DELIVERY DOWA
    //==================================================================================================================================================
    public function scanDeliveryDowa() {
        return view('tracebility/delivery/scan-dowa');
    }

    public function checkCodeDeliveryDowa(Request $request) {
        $code = $request->all();
        $kbn_int = $code['kbnint'];
        $data = avi_dowa_process::select('id')->where('kbn_int_casting', $kbn_int)->where('kbn_supply', NULL)->first();
        if ($data != null) {
            return array(
                "code" => $kbn_int,
                "codesubstr" => $kbn_int
            );
        }
        return array(
            "code" => "false",
            "codesubstr" => $kbn_int
        );
    }

    public function inputCodeDeliveryDowa(Request $request) {
        try {
            $user = Auth::user()->npk;
            $code = $request->all();
            $kbn_int = $code['kbn_int'];
            $kbn_sup = $code['kbn_sup'];
            $partcodes = avi_dowa_process::select('code', 'kbn_int_casting')->where('kbn_int_casting', $kbn_int)->get();
            $sendJson = [];
            foreach ($partcodes as $key => $value) {
                $dowaProcess = avi_dowa_process::where('code', $value->code)
                ->update(['kbn_supply' => $kbn_sup,
                 'scan_delivery_dowa_at'=>date('Y-m-d H:i:s'),
                 'npk_delivery_dowa'=>$user]);

                $data = [
                        'code' => $value->code,
                        'delivery_aiia_at' => date('Y-m-d H:i:s'),
                        'kanban' => $kbn_sup
                    ];
                $sendJson[] = $data;
            };

            $client = new Client();
            $response = $client->post(env('DOWA_BASE_URL').'/products', [
                'body' => [
                    'data' => $sendJson
                ],
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer '.Cache::get('dowa_token')
                ]
            ]);
            return [
                "status" => "success"
            ];
        } catch (\Throwable $e) {
            return [
                "status" => "error",
                "messege" => $e->getMessage()
            ];
        }
    }
    // MODUL DELIVERY
    //=======================================================================================================================================================
    public function scandelivery()
    {
        return view('tracebility/delivery/scan');
    }

    public function getAjaxdelivery($number, $wimcycle, $customer)
    {
        try{
            $user                       = Auth::user();
            $cek    = avi_trace_delivery::where('code', $number)->first();
            if (strlen($number) > 25) {
                $codes = avi_dowa_process::where('kbn_fg', substr($number, 123, 4) )->get();
                foreach ($codes as $code) {
                    if($code->code != null) {
                        DB::beginTransaction();
                        $scan                       = new avi_trace_delivery;
                        $scan->code                 = $code->code;
                        $scan->cycle                = $wimcycle;
                        $scan->customer             = $customer;
                        $scan->npk                  = $user->npk;
                        $scan->date                 = date('Y-m-d');
                        $scan->status               = 1;
                        $scan->save();
                        DB::commit();
                    } else {
                        return [
                            "code" => "not found"
                        ];
                    }

                }
                $counter = avi_trace_delivery::where('date', date('Y-m-d'))
                            ->where('cycle', $wimcycle)
                            ->count();
                $arrJSON = array(
                                "code"      => substr($number, 123, 4),
                                "counter"   => $counter
                        );
                return $arrJSON;
            }
            if (is_null($cek)) {

                DB::beginTransaction();
                    $scan                       = new avi_trace_delivery;
                    $scan->code                 = $number;
                    $scan->cycle                = $wimcycle;
                    $scan->customer             = $customer;
                    $scan->npk                  = $user->npk;
                    $scan->date                 = date('Y-m-d');
                    $scan->status               = 1;
                    $scan->save();
                DB::commit();
                $counter = avi_trace_delivery::where('date', date('Y-m-d'))
                                            ->where('cycle', $wimcycle)
                                            ->count();
                    $arrJSON = array(
                                    "code"      => $number,
                                    "counter"   => $counter
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


// MODUL NG DELIVERY

    public function scandeliveryng()
    {

        return view('tracebility/delivery/ng');
    }

    public function getAjaxdeliveryng($number)
    {
        try{

        $cek    = avi_trace_delivery::where('code', $number)->first();

        if ($cek) {

            DB::beginTransaction();
                $user                       = Auth::user();
                $scan                       = avi_trace_delivery::where('code', $number)->first();
                $scan->date_ng              = date('Y-m-d');
                $scan->status               = 0;
                $scan->npk_ng               = $user->npk;
                $scan->save();
                DB::commit();

                // dev-1.0.0, Handika, 20180724, counter
                $counter = avi_trace_delivery::where('date_ng', date('Y-m-d'))
                                        ->where('npk_ng', $user->npk)
                                        ->count();

                $arrJSON = array(
                                "code"      => $number,
                                "counter"    => $counter,
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
    public function getAjaxdeliveryngtable(){
            $create= New avi_trace_delivery();
            $create->code = 'No Data';
            $create->npk_ng = 'No Data';
            $create->date_ng = 'No Data';
            $arrayku=array($create);
            return Datatables::of($arrayku)
                    ->addIndexColumn()
                    ->make(true);
    }
    public function getAjaxdeliveryngupdate(){
        $user                       = Auth::user();
        $create= avi_trace_delivery::select('code','npk_ng','date_ng')
                ->where('npk_ng', $user->npk)
                ->where('date_ng', date('Y-m-d'))
                ->get();
        return Datatables::of($create)
                ->addIndexColumn()
                ->make(true);

    }


// MODULE MACHINING
//=======================================================================================================================================================

    public function scanmachining()
    {
        return view('tracebility/machining/scan');
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
                $scan->status               = 1;
                $scan->npk                  = $user->npk;

                $a                          = substr($number, 0, 2);
                $product                    = avi_trace_program_number::where('code', $a)->first();
                if (is_null($product)){
                        return "Not OPN 889F Model";
                }

                $scan->save();

                $key = 'machining_'.$user->npk;
                if (Cache::has($key)) {
                    $cache = Cache::get($key);

                    if(!isset($cache[date('Y-m-d')])) {
                        $cache = [];
                        $cache = [
                            date('Y-m-d') => [
                                'counter' => 1,
                                'items' => [
                                    $number
                                ]
                            ]
                        ];
                    } else {
                        $cache[date('Y-m-d')]['counter'] += 1;
                        if (count($cache[date('Y-m-d')]['items']) >= 10) {
                            unset($cache[date('Y-m-d')]['items'][0]);
                        }
                        $cache[date('Y-m-d')]['items'][] = $number;
                        $cache[date('Y-m-d')]['items'] = array_values($cache[date('Y-m-d')]['items']);
                    }
                } else {
                    $cache = [
                        date('Y-m-d') => [
                            'counter' => 1,
                            'items' => [
                                $number
                            ]
                        ]
                    ];
                }

                Cache::forever($key, $cache);

                $arrJSON = array(
                                "code"      => $number,
                                "counter"   => $cache[date('Y-m-d')]['counter']
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

                // dev-1.1.0, Ali, Handle untuk data yang tidak di print di line yg sedang jalan
                if ($printer) {
                    $printer->part_code         = $number;
                    $printer->part_number       = $product->part_number;
                    $printer->back_number       = $product->back_number;
                    $printer->part_name         = $product->part_name;
                    if ($product->is_assy == 0) {
                        $printer->flag              = 0;
                    }else{
                        $printer->flag              = 1;
                    }
                    $printer->save();
                }
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
     public function getAjaxmachiningtable(){
            $create= New avi_trace_machining();
            $create->code = 'No Data';
            $create->npk = 'No Data';
            $create->date = 'No Data';
            $arrayku=array($create);
            return Datatables::of($arrayku)
            ->addColumn('product', function($create) {
                    return 'No Data';
                })
                ->addColumn('model', function($create) {

                    return 'No Data';
                })
                    ->addIndexColumn()
                    ->make(true);
    }
    public function getAjaxmachiningupdate(){
        $user                       = Auth::user();
        $create= avi_trace_machining::select('code','npk','date')
                ->where('npk', $user->npk)
                ->where('date', date('Y-m-d'))
                ->take(5)
                ->orderBy('id', 'DESC')
                ->get();
        return Datatables::of($create)
                ->addColumn('product', function($create) {

                    $codes  = $create->code ;
                    $code   = substr($create->code, 0, 2);
                    $models = avi_trace_program_number::select('product')->where('code', $code)->first();
                    return $models ? $models->product : '--No Product--';
                })
                ->addColumn('model', function($create) {

                    $codes  = $create->code ;
                    $code   = substr($create->code, 0, 2);
                    $models = avi_trace_program_number::select('back_number')->where('code', $code)->first();
                    return $models ? $models->back_number : '--No Back Number--';
                })
                ->addIndexColumn()
                ->make(true);

    }

// MODULE ASSEMBLING
//=======================================================================================================================================================

    public function scanassembling()
    {
        return view('tracebility/assembling/scan');
    }

    public function getAjaxassembling($number, $line)
    {
        try{

        $cek    = avi_trace_assembling::where('code', $number)->first();
        if (is_null($cek)) {
            DB::beginTransaction();
                $user                       = Auth::user();
                $scan                       = new avi_trace_assembling;
                $scan->code                 = $number;
                $scan->date                 = date('Y-m-d');
                $scan->line                 = $line;
                $scan->status               = 1;
                $scan->npk                  = $user->npk;

                $a                          = substr($number, 0, 2);
                $product                    = avi_trace_program_number::where('code', $a)->first();
                if (is_null($product)){
                        return "Not OPN 889F Model";
                }
                $scan->save();

                // dev-1.0.0, Handika, 20180724, counter
                $key = 'assembling_'.$user->npk;
                if (Cache::has($key)) {
                    $cache = Cache::get($key);

                    if(!isset($cache[date('Y-m-d')])) {
                        $cache = [];
                        $cache = [
                            date('Y-m-d') => [
                                'counter' => 1,
                                'items' => [
                                    $number
                                ]
                            ]
                        ];
                    } else {
                        $cache[date('Y-m-d')]['counter'] += 1;
                        if (count($cache[date('Y-m-d')]['items']) >= 10) {
                            unset($cache[date('Y-m-d')]['items'][0]);
                        }
                        $cache[date('Y-m-d')]['items'][] = $number;
                        $cache[date('Y-m-d')]['items'] = array_values($cache[date('Y-m-d')]['items']);
                    }
                } else {
                    $cache = [
                        date('Y-m-d') => [
                            'counter' => 1,
                            'items' => [
                                $number
                            ]
                        ]
                    ];
                };

                Cache::forever($key, $cache);
                $arrJSON = array(
                                "code"      => $number,
                                "counter"   => $cache[date('Y-m-d')]['counter']
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
                if ($printer) {
                    $printer->part_code         = $number;
                    $printer->part_number       = $product->part_number;
                    $printer->back_number       = $product->back_number;
                    $printer->part_name         = $product->part_name;
                    $printer->flag              = 0;
                    $printer->save();
                }
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
     public function getAjaxassemblingtable(){
            $create= New avi_trace_assembling();
            $create->code = 'No Data';
            $create->npk = 'No Data';
            $create->date = 'No Data';
            $arrayku=array($create);
            return Datatables::of($arrayku)
            ->addColumn('product', function($create) {
                    return 'No Data';
                })
                ->addColumn('model', function($create) {

                    return 'No Data';
                })
                    ->addIndexColumn()
                    ->make(true);
    }
    public function getAjaxassemblingupdate(){
        $user                       = Auth::user();
        $create= avi_trace_assembling::select('code','npk','date')
                ->where('npk', $user->npk)
                ->where('date', date('Y-m-d'))
                ->take(5)
                ->orderBy('id', 'DESC')
                ->get();
        return Datatables::of($create)
                ->addColumn('product', function($create) {

                    $codes  = $create->code ;
                    $code   = substr($create->code, 0, 2);
                    $models = avi_trace_program_number::select('product')->where('code', $code)->first();
                    return $models ? $models->product : '--No Product--';
                })
                ->addColumn('model', function($create) {

                    $codes  = $create->code ;
                    $code   = substr($create->code, 0, 2);
                    $models = avi_trace_program_number::select('back_number')->where('code', $code)->first();
                    return $models ? $models->back_number : '--No Back Number--';
                })
                ->addIndexColumn()
                ->make(true);

    }
    //MODUL TORIMETRON DOWA
    //==================================================================================================================================================
    public function scanTorimetron() {
        return view('tracebility/torimetron/scan-dowa');
    }

    public function checkCodeTorimetron(Request $request) {
        $user = Auth::user()->npk;
        $today = date("Y-m-d H:i:s");
        $codes = $request->all();
        $type = $codes['type'];
        $code = $codes['code'];
        if ($type == 'kbnfg') {
            $codesubstr = substr($code,123,4);
            $data = avi_dowa_process::select('kbn_fg')->where('kbn_fg', $codesubstr)->first();
            if ($data == null) {
                return array(
                    "type" => $type,
                    "code" => $code,
                    "codesubstr" => $codesubstr
                );
            } else if($data->kbn_fg == null) {
                return array(
                    "type" => $type,
                    "code" => $code,
                    "codesubstr" => $codesubstr
                );
            } else {
                return array(
                    "type" => $type,
                    "code" => "false",
                    "codesubstr" => $codesubstr
                );
            }
        } elseif ($type == 'code') {
            $substr                     = substr($code, 0, 2);
            $product                    = avi_trace_program_number::where('code', $substr)->first();
            if (is_null($product)){
                return array(
                    "type" => $type,
                    "code" => "unregistered",
                    "codesubstr" => $code
                );
            };
            $data = avi_dowa_process::select('*')->where('code', $code)->first();
            if ($data != null && $data->code != null && $data->kbn_fg ==  null ) {
                if ($codes['isNg'] == 1) {
                    $array = [
                        'scan_torimetron_at' => $today,
                        'npk_torimetron' => $user,
                        'status' => 0
                    ];
                    $update = avi_dowa_process::select('code', 'scan_torimetron_at', 'npk_torimetron', 'status')->where('code', $code)->update($array);
                    return array(
                        "type" => $type,
                        "code" => "ng",
                        "codesubstr" => $code
                    );
                }
                return array(
                    "type" => $type,
                    "code" => $code,
                    "codesubstr" => $code
                );
            } else if ($data != null && $data->code != null && $data->kbn_fg !=  null) {
                return array(
                    "type" => $type,
                    "code" => "false",
                    "codesubstr" => $code
                );
            } else {
                return array(
                    "type" => $type,
                    "code" => "ngnotfound",
                    "codesubstr" => $code
                );
            }
        } else {
            return "salah";
        }
    }

    public function inputCodeTorimetron(Request $request) {
        $user = Auth::user()->npk;
        $code = $request->all();
        $partcodes = $code['code'];
        $now = date('Y-m-d H:i:s');
        $kbn_fg = $code['kbn_fg'];
        foreach ($partcodes as $key => $value) {
            $dataTorimetron = array(
                'kbn_fg'=>$kbn_fg,
                'scan_torimetron_at'=>$now,
                'npk_torimetron'=>$user,
                'status'=>1
            );
            $dowaProcess = avi_dowa_process::select('kbn_fg', 'scan_torimetron_at', 'npk_torimetron', 'status')->where('code',$value)->update($dataTorimetron);
        };
        return [
            "status" => "success"
        ];
    }

}
