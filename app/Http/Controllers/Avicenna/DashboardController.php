<?php

namespace App\Http\Controllers\Avicenna;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Avicenna\avi_trace_ng;
use App\Models\Avicenna\avi_trace_machining;
use App\Models\Avicenna\avi_trace_casting;
use App\Models\Avicenna\avi_trace_assembling;
use Datatables;
use Maatwebsite\Excel\Facades\Excel;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('tracebility.dashboard.dashboard_ok');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getDataChart(Request $request)
    {

        $area = $request->area;
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $date = date('Y-m-d');
        if ($area == "casting") {
			$data = avi_trace_casting::select('*')->orderBy('line', 'ASC');
		} elseif ($area == "machining") {
			$data = avi_trace_machining::select('*')->orderBy('line', 'ASC');
		} elseif ($area == "assembling") {
			$data = avi_trace_assembling::select('*')->orderBy('line', 'DESC');
		}

        if ($start_date == 'null' && $end_date == 'null') {
            $data = $data->where('date', '=', $date);
        }

        if ($start_date != 'null') {
            $data = $data->where('date', '>=', $start_date);
        }

        if ($end_date != 'null') {
            $data = $data->where('date', '<=', $end_date);
        }
        $line = $data->groupBy('line')->get();
        $labelChart = [];
        $valueChart = [];
        foreach ($line as $datum) {

            array_push($labelChart, $datum->line);
            array_push($valueChart, $data->where('line', $datum->line)->count());
        }

        $area =  $request->area == 'null' ? '' : $request->area;

        return [
            'areaChart' => $area,
            'labelChart' => $labelChart,
            'valueChart' => $valueChart
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getData($area, $start, $end)
    {
        $date = date('Y-m-d');
        $data = avi_trace_ng::select('*')->with('ngdetail');

        return Datatables::eloquent($data)
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function exportData($area, $start_date, $end_date)
    {
        $date = date('Y-m-d');


        $data = avi_trace_ng::select('*')->with('ngdetail');

        if ($start_date == 'null' && $end_date == 'null') {
            $data = $data->where('date', '=', $date);
        }

        if ($area != 'null') {
            $data = $data->where('line', $area);
        }

        if ($start_date != 'null') {
            $data = $data->where('date', '>=', $start_date);
        }

        if ($end_date != 'null') {
            $data = $data->where('date', '<=', $end_date);
        }

        $data = $data->get()->groupBy('id_ng');
        Excel::load('/storage/template/Export_NG.xlsx',  function($file) use($data, $start_date, $end_date){

            $row = "3";
            $no = "1";
            $file->setActiveSheetIndex(0)->setCellValue('A1', 'DATA NG PERIODE '.$start_date.' - '.$end_date);
            foreach ($data as $datum) {

                $file->setActiveSheetIndex(0)->setCellValue('A'.$row.'', $no);
                $file->setActiveSheetIndex(0)->setCellValue('B'.$row.'', $datum[0]->ngdetail->name);
                $file->setActiveSheetIndex(0)->setCellValue('C'.$row.'', $datum[0]->line);
                $file->setActiveSheetIndex(0)->setCellValue('D'.$row.'', count($datum));

                $row++;
                $no++;
            }
        })->setFilename("NG PERIODE ".$start_date.' - '.$end_date)->export('xlsx');

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
