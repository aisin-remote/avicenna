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
     * Display a filtered list of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function filter($start, $end, $product)
    {
        dd($product);
        $back_no = $product;
        if ($product != "ALL" || $product != "") {
            $products = avi_trace_program_number::where('back_number', $product)->get();
        } else {
            $products = avi_trace_program_number::select('*')->get();
        };
        $dataStockCasting = 0;
        $dataStockMachining = 0;
        $dataStockAssembling = 0;
        $dataStockDelivery = 0;
        dd($products);
        foreach ($products as $product) {
            $dataStockCasting += avi_trace_casting::where('code', 'like', $product->code.'%')->where('date', '>=', $start)->where('date', '<=', $end)->count();
            $dataStockMachining += avi_trace_machining::where('code', 'like', $product->code.'%')->where('date', '>=', $start)->where('date', '<=', $end)->count();
            $dataStockAssembling += avi_trace_assembling::where('code', 'like', $product->code.'%')->where('date', '>=', $start)->where('date', '<=', $end)->count();
            $dataStockDelivery += avi_trace_delivery::where('code', 'like', $product->code.'%')->where('date', '>=', $start)->where('date', '<=', $end)->count();
        };
        $dataAll =  [ "data" => [
                            $back_no,
                            $dataStockCasting,
                            0,
                            $dataStockMachining,
                            $dataStockCasting - $dataStockMachining,
                            $dataStockAssembling,
                            $dataStockAssembling - $dataStockMachining,
                            $dataStockDelivery,
                            $dataStockAssembling - $dataStockDelivery,
                    ]];
        return Datatables::of($dataAll)->make(true);

    }
}
