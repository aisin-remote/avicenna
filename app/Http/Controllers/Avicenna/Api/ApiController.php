<?php

namespace App\Http\Controllers\Avicenna\Api;

use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Avicenna\avi_trace_ng;

class ApiController extends Controller
{
    //
    public function getQty($line,$start_time,$end_time)
{

        // get quantity NG
        // $ngQty = DB::table('avi_trace_ngs')
        // ->where('line', $line)
        // ->whereBetween('created_at', [$start_time .'%', $end_time .'%'])
        // ->count();

        // // get quantity DC
        // $dcQty = DB::table('avi_trace_casting')
        // ->where('line', $line)
        // ->whereBetween('created_at', [$start_time .'%', $end_time .'%'])
        // ->count();

        // $hour = date('H');
        
        // return response()->json([
        //     'line' => 'cek',
        //     'ngQty' => 'cek',
        //     'dcQty' => $dcQty,
        // ]);

        return 'bismillah';
    }

    public function getNgQty($line,$date){

        // get quantity NG
        $ngQty = DB::table('avi_trace_ngs')
        ->where('line', $line)
        ->where('date', $date)
        ->count();

        return response()->json([
            'line' => $line,
            'date' => $date,
            'ngQty' => $ngQty,
        ]);

    }
}
