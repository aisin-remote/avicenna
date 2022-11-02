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

        $line = $request->line;
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $programnumber = $request->programnumber;
        $date = date('Y-m-d');


        $data = avi_trace_ng::select('*')->with('ngdetail');

        if ($start_date == 'null' && $end_date == 'null') {
            $from = date_create($date);
            $to = date('Y-m-d', strtotime("+1 day", strtotime($date)));
            $to = date_create($to);
            $from =  date_format($from, "Y-m-d 06:00:00");

            $to = date_format($to, "Y-m-d 06:00:00");

            $data = $data->where('created_at', '>=', $from);
            $data = $data->where('created_at', '<=', $to);
        }

        if ($line != 'null') {
            $data = $data->where('line', $line);
        }

        if ($start_date != 'null') {
            $from = date_create($start_date);
            $from =  date_format($from, "Y-m-d 06:00:00");
            $data = $data->where('created_at', '>=', $from);
        }

        if ($end_date != 'null') {
            $to = date('Y-m-d', strtotime("+1 day", strtotime($end_date)));
            $to = date_create($to);

            $to = date_format($to, "Y-m-d 06:00:00");
            $data = $data->where('created_at', '<=', $to);
        }

        if ($programnumber != 'null') {
            $data = $data->where(DB::raw('substring(code,1,2)'), '=', $programnumber);
        }

        $data = $data->get()->groupBy('id_ng');
        $labelChart = [];
        $valueChart = [];
        $totalLine = 0;
        foreach ($data as $datum) {
            array_push($labelChart, $datum[0]->ngdetail->name);
            array_push($valueChart, count($datum));
            $totalLine = $totalLine + count($datum);
        }

        $line =  $request->line == 'null' ? '' : $request->line;

        return [
            'totalLine' => $totalLine,
            'lineChart' => $line,
            'labelChart' => $labelChart,
            'valueChart' => $valueChart
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getData($line, $start, $end)
    {
        $date = date('Y-m-d');
        $data = avi_trace_ng::select('*')->with('ngdetail');

        if ($start == 'null' && $end == 'null') {
            $data = $data->where('date', '=', $date);
        }

        if ($line != 'null') {
            $data = $data->where('line', $line);
        }

        if ($start != 'null') {
            $data = $data->where('date', '>=', $start);
        }

        if ($end != 'null') {
            $data = $data->where('date', '<=', $end);
        }

        return DataTables::eloquent($data)
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function exportData($line, $start_date, $end_date)
    {
        $date = date('Y-m-d');


        $data = avi_trace_ng::select('*')->with('ngdetail');

        if ($start_date == 'null' && $end_date == 'null') {
            $data = $data->where('date', '=', $date);
        }

        if ($line != 'null') {
            $data = $data->where('line', $line);
        }

        if ($start_date != 'null') {
            $data = $data->where('date', '>=', $start_date);
        }

        if ($end_date != 'null') {
            $data = $data->where('date', '<=', $end_date);
        }

        $data = $data->get()->groupBy('id_ng');
        Excel::load('/storage/template/Export_NG.xlsx',  function ($file) use ($data, $start_date, $end_date) {

            $row = "3";
            $no = "1";
            $file->setActiveSheetIndex(0)->setCellValue('A1', 'DATA NG PERIODE ' . $start_date . ' - ' . $end_date);
            foreach ($data as $datum) {

                $file->setActiveSheetIndex(0)->setCellValue('A' . $row . '', $no);
                $file->setActiveSheetIndex(0)->setCellValue('B' . $row . '', $datum[0]->ngdetail->name);
                $file->setActiveSheetIndex(0)->setCellValue('C' . $row . '', $datum[0]->line);
                $file->setActiveSheetIndex(0)->setCellValue('D' . $row . '', count($datum));

                $row++;
                $no++;
            }
        })->setFilename("NG PERIODE " . $start_date . ' - ' . $end_date)->export('xlsx');
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
