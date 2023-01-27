<?php

namespace App\Http\Controllers\Avicenna\Api;

use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Avicenna\avi_trace_ng;

class ApiController extends Controller
{
    //
    public function getQty(){
        $ngQty = DB::table('avi_trace_ngs')
        ->select(DB::raw('SUBSTRING(code, 3, 2) AS diesid, COUNT(id) AS Jumlah'))
        ->groupBy('diesid')
        ->whereBetween('created_at', [date('Y-m-d H:00:00'), date('Y-m-d H:59:59')])
        ->get();

        $maQty = DB::table('avi_trace_machining')
        ->select(DB::raw('SUBSTRING(code, 3, 2) AS diesid, COUNT(id) AS Jumlah'))
        ->groupBy('diesid')
        ->whereBetween('created_at', [date('Y-m-d H:00:00'), date('Y-m-d H:59:59')])
        ->get();

        $asQty = DB::table('avi_trace_assemblings')
        ->select(DB::raw('SUBSTRING(code, 3, 2) AS diesid, COUNT(id) AS Jumlah'))
        ->groupBy('diesid')
        ->whereBetween('created_at', [date('Y-m-d H:00:00'), date('Y-m-d H:59:59')])
        ->get();

        $dcQty = DB::table('avi_trace_casting')
        ->select(DB::raw('SUBSTRING(code, 3, 2) AS diesid, COUNT(id) AS Jumlah'))
        ->groupBy('diesid')
        ->whereBetween('created_at', [date('Y-m-d H:00:00'), date('Y-m-d H:59:59')])
        ->get();

        $hour = date('H');
        
        return response()->json([
            'ngQty' => $ngQty,
            'maQty' => $maQty,
            'asQty' => $asQty,
            'dcQty' => $dcQty,
            'hour' => $hour. ':00'
        ]);
    }
}
