<?php

namespace App\Http\Controllers\Avicenna;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Avicenna\avi_trace_ng;
use App\Models\Avicenna\avi_trace_machining;
use App\Models\Avicenna\avi_trace_assembling;
use App\Models\Avicenna\avi_trace_casting;
use App\Models\Avicenna\avi_trace_rekap_ng;

use Datatables;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;


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
    // public function getDataChart(Request $request)
    // {
    //     // update by fabian 01142023 || chart NG
    //     $line = $request->line;
    //     $date = $request->date;
    //     $programnumber = $request->programnumber;
    //     $dies = $request->dies;
        
    //     $data = avi_trace_ng::select(DB::raw('COUNT(*) as jumlah_ng'), 'id_ng', 'line', 'date')
    //     ->with('ngdetail')->where('line', $line)
    //     ->where('code', 'like', $programnumber .$dies .'%')
    //     ->where('date', 'like', $date . '%')
    //     ->orderBy('id_ng','desc')
    //     ->groupBy('id_ng')
    //     ->get();
        
    //     $labelChart = [];
    //     $valueChart = [];
    //     $totalLine = 0;
        
    //     foreach ($data as $datum) { 
    //         array_push($labelChart, $datum->ngdetail->name);
    //         array_push($valueChart, $datum->jumlah_ng);
    //         $totalLine = $totalLine + $datum->jumlah_ng;
    //     }
        
    //     $line =  $request->line == 'null' ? '' : $request->line;
    //     $programnumber =  $request->programnumber == 'null' ? '' : $request->programnumber;
    //     $dies =  $request->dies == 'null' ? '' : $request->dies;
        
    //     return [
    //         'totalLine' => $totalLine,
    //         'lineChart' => $line,
    //         'labelChart' => $labelChart,
    //         'valueChart' => $valueChart,
    //     ];
    // }

    public function getDataChart(Request $request)
    {
        // update by diki 11062024 || chart Rekap NG
        $line =  $request->line === 'null' ? null : $request->line;
        $programnumber =  $request->programnumber === 'null' ? null : $request->programnumber;
        $dies =  $request->dies === 'null' ? null : $request->dies;
        $date =  $request->date === 'null' ? null : $request->date;
        $monthName = null;

        if ($date !== null && $line === null && $programnumber === null && $dies === null) {
            $query = avi_trace_ng::select(DB::raw('COUNT(*) as jumlah_ng'), 'line')
                ->orderBy('line', 'asc')
                ->groupBy('line');

            if ($programnumber !== null) {
                $query->whereRaw('SUBSTRING(code, 1, 2) = ?', [$programnumber]);
            }

            if ($line !== null) {
                $query->whereRaw('SUBSTRING(code, 5, 2) = ?', [$line]);
            }

            if ($dies !== null) {
                $query->whereRaw('SUBSTRING(code, 3, 2) = ?', [$dies]);
            }

            if ($date !== null) {
                if (strlen($date) == 7) { // yyyy-mm
                    $monthName = Carbon::parse($date . '-01')->format('F Y');
                    $query->where('date', 'like', $date . '%');
                } else {
                    $monthName = Carbon::createFromFormat('Y-m-d', $date)->format('F Y');
                    $query->where('date', 'like', '%' . $date . '%');
                }
            } else {
                // If date is null, filter data for the current month
                $startOfMonth = Carbon::now()->startOfMonth()->toDateString();
                $endOfMonth = Carbon::now()->endOfMonth()->toDateString();
                $query->whereBetween('date', [$startOfMonth, $endOfMonth]);
                $monthName = Carbon::now()->format('F Y');
            }

            $data = $query->get();

            $labelChart = [];
            $valueChart = [];
            $totalLine = 0;

            foreach ($data as $datum) {
                $labelChart[] = $datum->line;
                $valueChart[] = $datum->jumlah_ng;
                $totalLine += $datum->jumlah_ng;
            }

            return [
                'totalLine' => $totalLine,
                'labelChart' => $labelChart,
                'valueChart' => $valueChart,
                'monthName' => $monthName,
                'lineName' => "-",
            ];
        } elseif ($line !== null || $programnumber !== null || $dies !== null || $date !== null) {
            $query = avi_trace_ng::select(DB::raw('COUNT(*) as jumlah_ng'), 'avi_trace_ng_masters.name')
                ->join('avi_trace_ng_masters', 'avi_trace_ngs.id_ng', 'avi_trace_ng_masters.id')
                ->orderBy('avi_trace_ng_masters.name', 'asc')
                ->groupBy('avi_trace_ng_masters.name');

            if ($programnumber !== null) {
                $query->whereRaw('SUBSTRING(code, 1, 2) = ?', [$programnumber]);
            }

            if ($line !== null) {
                $query->where('line', $line);
            }
            
            if ($dies !== null) {
                $query->whereRaw('SUBSTRING(code, 3, 2) = ?', [$dies]);
            }
            
            if ($date !== null) {
                if (strlen($date) == 7) { // yyyy-mm
                    $monthName = Carbon::parse($date . '-01')->format('F Y');
                    $query->where('date', 'like', $date . '%');
                } else {
                    $monthName = Carbon::createFromFormat('Y-m-d', $date)->format('F Y');
                    $query->where('date', 'like', '%' . $date . '%');
                }
            } else {
                // If date is null, filter data for the current month
                $startOfMonth = Carbon::now()->startOfMonth()->toDateString();
                $endOfMonth = Carbon::now()->endOfMonth()->toDateString();
                $query->whereBetween('date', [$startOfMonth, $endOfMonth]);
                $monthName = Carbon::now()->format('F Y');
            }

            $data = $query->get();

            $labelChart = [];
            $valueChart = [];
            $totalLine = 0;
            $lineName = 0;

            foreach ($data as $datum) {
                $labelChart[] = $datum->name;
                $valueChart[] = $datum->jumlah_ng;
                $totalLine += $datum->jumlah_ng;
            }

            return [
                'totalLine' => $totalLine,
                'labelChart' => $labelChart,
                'valueChart' => $valueChart,
                'monthName' => $monthName,
                'lineName' => $line,
            ];
        } else {
            $query = avi_trace_ng::select(DB::raw('COUNT(*) as jumlah_ng'), 'line')
                ->orderBy('line', 'asc')
                ->groupBy('line');

            if ($programnumber !== null) {
                $query->whereRaw('SUBSTRING(code, 1, 2) = ?', [$programnumber]);
            }

            if ($line !== null) {
                $query->whereRaw('SUBSTRING(code, 5, 2) = ?', [$line]);
            }

            if ($dies !== null) {
                $query->whereRaw('SUBSTRING(code, 3, 2) = ?', [$dies]);
            }

            if ($date !== null) {
                if (strlen($date) == 7) { // yyyy-mm
                    $monthName = Carbon::parse($date . '-01')->format('F Y');
                    $query->where('date', 'like', $date . '%');
                } else {
                    $monthName = Carbon::createFromFormat('Y-m-d', $date)->format('F Y');
                    $query->where('date', 'like', '%' . $date . '%');
                }
            } else {
                // If date is null, filter data for the current month
                $startOfMonth = Carbon::now()->startOfMonth()->toDateString();
                $endOfMonth = Carbon::now()->endOfMonth()->toDateString();
                $query->whereBetween('date', [$startOfMonth, $endOfMonth]);
                $monthName = Carbon::now()->format('F Y');
            }

            $data = $query->get();

            $labelChart = [];
            $valueChart = [];
            $totalLine = 0;

            foreach ($data as $datum) {
                $labelChart[] = $datum->line;
                $valueChart[] = $datum->jumlah_ng;
                $totalLine += $datum->jumlah_ng;
            }

            return [
                'totalLine' => $totalLine,
                'labelChart' => $labelChart,
                'valueChart' => $valueChart,
                'monthName' => $monthName,
                'lineName' => "Semua Line",
            ];
        }      
    }
    
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    // public function getData($line,$model,$dies,$month)
    // {
    //     $date = date('Y-m');
    //     $data = avi_trace_ng::select('*')->with('ngdetail');
        
    //     if ($month == 'null') {
    //         $data = $data->where('date', 'like', $date .'%');
    //     }
        
    //     if ($month != 'null') {
    //         $data = $data->where('date', 'like', $month .'%');
    //     }
        
    //     if ($line != 'null') {
    //         $data = $data->where('line', $line);
    //     }
        
    //     if ($line != 'null') {
    //         $data = $data->where('line', $line);
    //     }
        
    //     if ($model != 'null') {
    //         $data = $data->where('code', 'like', $model . $dies .'%');
    //     }
        
    //     return DataTables::eloquent($data)
    //     ->make(true);
    // }

    public function getData($programnumber, $dies, $line, $date)
    {
        $now = date('Y-m');
        $data = avi_trace_ng::select('*')->with('ngdetail')->orderBy('created_at', 'desc');

        // if ($date == 'null') {
        //     $data = $data->where('date', 'like', '%' . $now . '%');
        // }
        if ($programnumber != 'null') {
            $data = $data->whereRaw('SUBSTRING(code, 1, 2) = ?', [$programnumber]);
        }

        if ($dies != 'null') {
            $data = $data->whereRaw('SUBSTRING(code, 3, 2) = ?', [$dies]);
        }

        if ($line != 'null') {
            $data = $data->where('line', 'like', '%' . $line . '%');
        }

        if ($date != 'null') {
            $data = $data->where('date', 'like', '%' . $date . '%');
        } else {
            // If no specific date is provided, filter by the current month
            $data = $data->where('date', 'like', '%' . $now . '%');
        }

        return DataTables::eloquent($data)->make(true);
    }
    
    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function exportData($line, $model, $dies, $month)
    {
        // Update 
        Excel::load('/storage/template/Export_NG.xlsx',  function ($file) use ($line,$model,$dies,$month) {
            
            $row = "7";
            $dataNg = [];
            $col = [];

            // update by fabian 01142023 || report NG per line,model,dies,date
            $casting = new avi_trace_casting;
            $machining = new avi_trace_machining;
            $assembling = new avi_trace_assembling;
            
            $dates = date_parse($month);
            $total_days = cal_days_in_month(CAL_GREGORIAN, $dates['month'], $dates['year']);
            
            // getOK function to get total part OK for each line, model, dies and month
            function getOK($table,$line,$model,$dies,$month,$days){
                return $table->select(DB::raw('COUNT(*) as jumlah_ok'))
                ->where('line', $line)
                ->where('code', 'like', $model . $dies . '%')
                ->where('date', $month .'-'. $days)
                ->groupBy('date')
                ->orderBy('line', 'DESC')->get();
            }
            
            for ($days = 1; $days <= $total_days; $days++) {
                $ng_data = avi_trace_ng::select(DB::raw('COUNT(*) as jumlah_ng'), 'id_ng', 'line', 'date')
                ->with('ngdetail')->where('line', $line)
                ->where('code', 'like', $model . $dies.'%')
                ->where('date', $month .'-'. $days)
                ->orderBy('id_ng','desc')
                ->groupBy('id_ng')
                ->get();

                if(str_contains($line,'DC')){
                    // get ok casting
                    $dataOk = getOK($casting,$line,$model,$dies,$month,$days);
                }elseif(str_contains($line,'MA')){
                    // get ok machining
                    $dataOk = getOK($machining,$line,$model,$dies,$month,$days);
                }elseif(str_contains($line,'AS')){
                    // get ok assembling
                    $dataOk = getOK($assembling,$line,$model,$dies,$month,$days);  
                }
                
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
                
                foreach ($dataOk as $data){
                    $file->setActiveSheetIndex(0)->setCellValue($column. '4' , $data->jumlah_ok );
                }
                
            }
            
            foreach ($dataNg as $key => $value) {
                $file->setActiveSheetIndex(0)->setCellValue('A' . $row . '', $value);
                for($i = 0; $i < count($jumlah_ng[$key]['jumlah']); $i++){
                    $file->setActiveSheetIndex(0)->setCellValue($col[$jumlah_ng[$key]['date'][$i] - 1] . $row . '', $jumlah_ng[$key]['jumlah'][$i]);
                }
                $row++;
            }
            
        })->setFilename("NG PERIODE " . $month . " LINE " . $line . " MODEL " . $model)->export('xlsx');
    }


    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function exportDataHarpan($line, $model, $dies, $month)
    {
        
        // Update 
        Excel::load('/storage/template/Export_NG_Harpan.xlsx',  function ($file) use ($line,$model,$dies,$month) {
            
            $row = "2";
            $no = '1';
            $datas = avi_trace_ng::where('date', 'like', '%'. $month . '%');
            if ($line != 'null') {
                $datas = $datas->where('line', $line);
            };
            // dd(avi_trace_ng::where('date', 'like', '%'. $month . '%')->orderBy('created_at', 'DESC')->get());

            $datas = $datas->orderBy('created_at', 'DESC')->get();
            // dd($datas);
            
            foreach ($datas as $key => $value) {
                $file->setActiveSheetIndex(0)->setCellValue('A' . $row . '', $no);
                $file->setActiveSheetIndex(0)->setCellValue('B' . $row . '', $value->code);
                $file->setActiveSheetIndex(0)->setCellValue('C' . $row . '', $value->line);
                $file->setActiveSheetIndex(0)->setCellValue('D' . $row . '', $value->pic);
                $file->setActiveSheetIndex(0)->setCellValue('E' . $row . '', $value->date);
                
                $row++;
                $no++;
            }
            
        })->setFilename("NG PERIODE " . $month . " LINE " . $line . " MODEL " . $model)->export('xlsx');
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
