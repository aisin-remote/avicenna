<?php

namespace App\Http\Controllers\Avicenna;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Avicenna\avi_trace_rekap_ng;
use Datatables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class RekapNgController extends Controller
{
    public function list()
    {
        return view('tracebility.rekap_ng.list');
    }

    public function create()
    {
        return view('tracebility.rekap_ng.create');
    }

    public function store(Request $request)
    {
        // Validasi data input
        // $request->validate([
        //     // 'code' => 'required|string|max:255',
        //     // 'id_ng' => 'required|string|max:255',
        // ]);
        $rekap = avi_trace_rekap_ng::pluck('code');
        if ($rekap->contains($request->code)) {
            return response()->json([
                'success' => false,
                'message' => 'code sudah ada',
            ]);
        }

        try {
            // Simpan data ke database
            $code = $request->input('code');

            // Extract year, month, and day from the code
            $year = '20' . substr($code, 6, 2); // 7th and 8th digits
            $monthDigit = substr($code, 8, 1); // 9th digit
            $day = substr($code, 9, 2); // 10th and 11th digits
    
            // Convert monthDigit to actual month
            if (is_numeric($monthDigit)) {
                $month = str_pad($monthDigit, 2, '0', STR_PAD_LEFT);
            } else {
                $month = 9 + ord(strtoupper($monthDigit)) - ord('A') + 1;
                $month = str_pad($month, 2, '0', STR_PAD_LEFT);
            }
    
            // Combine year, month, and day to create a date
            $date = Carbon::createFromFormat('Y-m-d', "$year-$month-$day");
    
            // Create new avi_trace_rekap_ng instance and save to the database
            $rekapNg = new avi_trace_rekap_ng();
            $rekapNg->code = $code;
            $rekapNg->area = $request->input('area');
            $rekapNg->date = $date;
            $rekapNg->pic = Auth::user()->name; // Mengisi kolom pic dengan ID user yang sedang login
            $rekapNg->save();

            // Respons JSON jika berhasil
            return response()->json([
                'success' => true,
                'message' => 'Data saved successfully',
            ]);
        } catch (\Exception $e) {
            // Log error untuk debug
            Log::error('Failed to save data: ' . $e->getMessage());

            // Respons JSON jika terjadi kesalahan
            return response()->json([
                'success' => false,
                'message' => 'Failed to save data: ' . $e->getMessage(),
            ]);
        }
    }

    public function getData($programnumber, $dies, $line, $area, $date)
    {
        $now = date('Y-m');
        $data = avi_trace_rekap_ng::select('*')->orderBy('created_at', 'desc');

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
            $data = $data->whereRaw('SUBSTRING(code, 5, 2) = ?', [$line]);
        }

        if ($area != 'null') {
            $data = $data->where('area', 'like', '%' . $area . '%');
        }

        if ($date != 'null') {
            $data = $data->where('date', 'like', '%' . $date . '%');
        }

        return DataTables::eloquent($data)->make(true);
    }

    public function getDataChart(Request $request)
    {
        // update by fabian 01142023 || chart NG
        $programnumber = $request->programnumber;
        $dies = $request->dies;
        $line = $request->line;
        $area = $request->area;
        $date = $request->date;
        
        $query = avi_trace_rekap_ng::select(DB::raw('COUNT(*) as jumlah_ng'), 'area')
        ->orderBy('area', 'asc')
        ->groupBy('area');

        if ($date !== 'null') {
            $query->where('date', 'like', '%' . $date . '%');
        }

        if ($programnumber !== 'null') {
            $query->where('code', 'like', $programnumber . $dies . $line .'%');
        }
    
        $data = $query->get();
        
        $labelChart = [];
        $valueChart = [];
        $totalLine = 0;
        
        foreach ($data as $datum) { 
            array_push($labelChart, $datum->area);
            array_push($valueChart, $datum->jumlah_ng);
            $totalLine = $totalLine + $datum->jumlah_ng;
        }
        
        // $line =  $request->line == 'null' ? '' : $request->line;
        $programnumber =  $request->programnumber == 'null' ? '' : $request->programnumber;
        $dies =  $request->dies == 'null' ? '' : $request->dies;
        
        return [
            'totalLine' => $totalLine,
            // 'lineChart' => $line,
            'labelChart' => $labelChart,
            'valueChart' => $valueChart,
        ];
    }
}
