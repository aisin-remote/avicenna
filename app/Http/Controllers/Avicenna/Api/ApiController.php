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

        try {
            // get quantity DC
            $dcQty = DB::table('avi_trace_trial')
            ->where('line', $line)
            ->whereBetween('created_at', [$start_time .'%', $end_time .'%'])
            ->count();

            // $hour = date('H');
            
            return response()->json([
                'line' => 0,
                // 'ngQty' => $ngQty,
                'dcQty' => 0,
            ],200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
            ],500);
        }

        
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
