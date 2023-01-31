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
        $ngQty = DB::table('avi_trace_ngs')
        ->where('line', $line)
        ->whereBetween('created_at', [$start_time .'%', $end_time .'%'])
        ->count();

        // delete temporary
        // $maQty = DB::table('avi_trace_machining')
        // ->select(DB::raw('SUBSTRING(code, 3, 2) AS diesid, COUNT(id) AS Jumlah'))
        // ->groupBy('diesid')
        // ->whereBetween('created_at', [date('Y-m-d H:00:00'), date('Y-m-d H:59:59')])
        // ->get();

        // $asQty = DB::table('avi_trace_assemblings')
        // ->select(DB::raw('SUBSTRING(code, 3, 2) AS diesid, COUNT(id) AS Jumlah'))
        // ->groupBy('diesid')
        // ->whereBetween('created_at', [date('Y-m-d H:00:00'), date('Y-m-d H:59:59')])
        // ->get();

        // $dcQty = DB::table('avi_trace_casting')
        // ->select(DB::raw('SUBSTRING(code, 3, 2) AS diesid, COUNT(id) AS Jumlah'))
        // ->groupBy('diesid')
        // ->where('line', $line)
        // ->whereBetween('created_at', [date('Y-m-d H:00:00'), date('Y-m-d H:59:59')])
        // ->get();

        // get quantity DC
        $dcQty = DB::table('avi_trace_casting')
        ->where('line', $line)
        ->whereBetween('created_at', [$start_time .'%', $end_time .'%'])
        ->count();

        // $hour = date('H');
        
        return response()->json([
            'line' => $line,
            'ngQty' => $ngQty,
            'dcQty' => $dcQty,
        ]);
    }
}
