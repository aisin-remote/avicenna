<?php

namespace App\Http\Controllers\Avicenna;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Avicenna\avi_trace_ng;
use Datatables;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class NgController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        return view('tracebility.ng.index');
    }
    
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function getDataChart(Request $request)
    {
        // update
        $line = $request->line;
        $date = $request->keyMonth;
        
        $data = avi_trace_ng::select('*')
                ->with('ngdetail')
                ->where('line', $line)
                ->where('date', 'LIKE' , $date . '%')
                ->groupBy('id_ng')
                ->first();
                

        $labelChart = [];
        $valueChart = [];
        $totalLine = 0;
        
        foreach ($data as $datum) {
            array_push($labelChart, $datum->name);
            array_push($valueChart, count($datum));
            $totalLine = $totalLine + count($datum);
        }
        
        // $line =  $request->line == 'null' ? '' : $request->line;
        
        return response()->json([
            'totalLine' => $totalLine,
            'lineChart' => $line,
            'labelChart' => $labelChart,
            'valueChart' => $valueChart,
        ]);
    }
    
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function getData($line, $month)
    {
        $date = date('Y-m');
        $data = avi_trace_ng::select('*')->with('ngdetail');
        
        if ($month == 'null') {
            $data = $data->where('date', 'like', $date .'%');
        }
        
        if ($month != 'null') {
            $data = $data->where('date', 'like', $month .'%');
        }
        
        if ($line != 'null') {
            $data = $data->where('line', $line);
        }
        
        // if ($start != 'null') {
            //     $data = $data->where('date', '>=', $start);
            // }
            
            // if ($end != 'null') {
                //     $data = $data->where('date', '<=', $end);
                // }
                
                return DataTables::eloquent($data)
                ->make(true);
            }
            
            /**
            * Show the form for creating a new resource.
            *
            * @return \Illuminate\Http\Response
            */
            public function exportData($line, $month)
            {
                // Update 
                Excel::load('/storage/template/Export_NG.xlsx',  function ($file) use ($line, $month) {
                    
                    $row = "3";
                    $dataNg = [];
                    $col = [];
                    
                    $dates = date_parse($month);
                    $total_days = cal_days_in_month(CAL_GREGORIAN, $dates['month'], $dates['year']);
                    
                    for ($days = 1; $days <= $total_days; $days++) {
                        $ng_data = avi_trace_ng::select(DB::raw('COUNT(*) as jumlah_ng'), 'id_ng', 'line', 'date')
                        ->with('ngdetail')->where('line', $line)
                        ->where('date', $month .'-'. $days)
                        ->orderBy('id_ng','desc')
                        ->groupBy('id_ng')
                        ->get();

                        foreach ($ng_data as $ng){
                            if(!in_array($ng->id_ng, $dataNg)){
                                $dataNg[$ng->id_ng] = $ng->ngdetail->name;
                            }
                            $jumlah_ng[$ng->id_ng]['jumlah'][] = $ng->jumlah_ng;
                            $jumlah_ng[$ng->id_ng]['date'][] = date('d', strtotime($ng->date));
                        }
                        $column = '';
                        if ($days >= 26) {
                            $column .= chr(65 + floor(($days) / 26) - 1);
                        }
                        $column .= chr(65 + ($days) % 26);
                        $col[] = $column;
                        $file->setActiveSheetIndex(0)->setCellValue($column. '2' , $days);
                    }
                    foreach ($dataNg as $key => $value) {
                        $file->setActiveSheetIndex(0)->setCellValue('A' . $row . '', $value);
                        for($i = 0; $i < count($jumlah_ng[$key]['jumlah']); $i++){
                            $file->setActiveSheetIndex(0)->setCellValue($col[$jumlah_ng[$key]['date'][$i] - 1] . $row . '', $jumlah_ng[$key]['jumlah'][$i]);
                        }
                        $row++;
                    }
                    
                })->setFilename("NG PERIODE " . $month . " LINE " . $line)->export('xlsx');
            }
            
            /**
            * Show the form for creating a new resource.
            *
            * @return \Illuminate\Http\Response
            */
            public function create()
            {
                //
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
