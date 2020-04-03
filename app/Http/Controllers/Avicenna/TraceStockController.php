<?php

namespace App\Http\Controllers\Avicenna;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Avicenna\avi_trace_assembling;
use App\Models\Avicenna\avi_trace_casting;
use App\Models\Avicenna\avi_trace_delivery;
use App\Models\Avicenna\avi_trace_machining;
use App\Models\Avicenna\avi_trace_program_number;
use Yajra\Datatables\Facades\Datatables;

class TraceStockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $today = date('Y-m-d');
            $dataStockCasting = avi_trace_casting::where('date', $today)->count();
            $dataStockMachining = avi_trace_machining::where('date', $today)->count();
            $dataStockAssembling = avi_trace_assembling::where('date', $today)->count();
            $dataStockDelivery = avi_trace_delivery::where('date', $today)->count();
            $dataAll =[ "data" => [
                        'All',
                        $dataStockCasting,
                        0,
                        $dataStockMachining,
                        $dataStockCasting - $dataStockMachining,
                        $dataStockAssembling,
                        $dataStockAssembling - $dataStockMachining,
                        $dataStockDelivery,
                        $dataStockAssembling - $dataStockDelivery,
                    ]
                ];
            return Datatables::of($dataAll)->make(true);
        }
        $models = avi_trace_program_number::select('back_number')->distinct()->get();
        // dd($model);
        return view('tracebility.stock.index',compact('models'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
