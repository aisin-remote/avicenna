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
use Maatwebsite\Excel\Facades\Excel;

class RekapNgController extends Controller
{
    public function index()
    {
        $areas = avi_trace_rekap_ng::select('area')
                ->distinct()
                ->orderBy('area', 'ASC')
                ->pluck('area');

        return view('tracebility.rekap_ng.list', compact('areas'));
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
                'message' => "code $request->code sudah ada",
                'type' => 'warning',
            ]);
        }

        try {
            // Simpan data ke database
            $code = $request->input('code');
            $area = $request->input('area');

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
            $rekapNg->area = $area;
            $rekapNg->date = $date;
            $rekapNg->pic = Auth::user()->name; // Mengisi kolom pic dengan ID user yang sedang login
            $rekapNg->save();

            // Respons JSON jika berhasil
            return response()->json([
                'success' => true,
                'message' => "Data berhasil ditambahkan dengan code $code pada area $area",
                'type' => 'success',
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

    public function update(Request $request)
    {
        $id = $request->id;
        $code = $request->code;
        $area = $request->area;
        $type = $request->type;

        $avi_trace_rekap_ng = avi_trace_rekap_ng::findOrFail($id);

        if($type == 'edit') 
        {
            try{
                $avi_trace_rekap_ng->update([
                    'code' => $code,
                    'area' => $area,
                ]);
                return response()->json([
                    'success' => true,
                    'message' => "Data berhasil diupdate dengan code $code pada area $area",
                    'type' => 'success',
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
        } else if($type == 'delete') 
        {
            try{
                $avi_trace_rekap_ng->delete();

                return response()->json([
                    'success' => true,
                    'message' => "Data berhasil dihapus dengan code $code pada area $area",
                    'type' => 'success',
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
        // update by diki 11062024 || chart Rekap NG
        $line =  $request->line === 'null' ? null : $request->line;
        $programnumber =  $request->programnumber === 'null' ? null : $request->programnumber;
        $dies =  $request->dies === 'null' ? null : $request->dies;
        $date =  $request->date === 'null' ? null : $request->date;
        $monthName = null;

        $query = avi_trace_rekap_ng::select(DB::raw('COUNT(*) as jumlah_ng'), 'area')
            ->orderBy('area', 'asc')
            ->groupBy('area');

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
            $labelChart[] = $datum->area;
            $valueChart[] = $datum->jumlah_ng;
            $totalLine += $datum->jumlah_ng;
        }

        return [
            'totalLine' => $totalLine,
            'labelChart' => $labelChart,
            'valueChart' => $valueChart,
            'monthName' => $monthName,
        ];
    }

    public function exportData($programnumber, $dies, $line, $area, $date)
    {
        if ($dies !== 'null') {
            $filenamedies = '_DIES-' . $dies; 
        } else {
            $filenamedies = '';
        }

        if ($line !== 'null') {
            $filenameline = '_LINE-DCAA0' . substr($line, 1, 1); 
        } else {
            $filenameline = '';
        }

        if ($area !== 'null') {
            $filenamearea = '_AREA-' . $area; 
        } else {
            $filenamearea = '';
        }

        if ($date !== 'null') {
            $filenamedate = '_LOT-' . $date; 
        } else {
            $filenamedate = '';
        }

        // CSH D98E dan CSH D05E
        if ($programnumber == '07') {
            Excel::load('/storage/template/Export_Rekap_NG_CSH_D98E.xlsx',  function ($file) use ($programnumber, $dies, $line, $area, $date) {
                
                $row = "21";
                $no = '1';
                $datas = avi_trace_rekap_ng::orderBy('created_at', 'DESC')->whereRaw('SUBSTRING(code, 1, 2) = ?', [$programnumber]);

                if ($dies !== 'null') {
                    $datas = $datas->whereRaw('SUBSTRING(code, 3, 2) = ?', [$dies]);
                }

                if ($line !== 'null') {
                    $datas = $datas->whereRaw('SUBSTRING(code, 5, 2) = ?', [$line]);
                }

                if ($area !== 'null') {
                    $datas = $datas->where('area', 'like', '%' . $area . '%');
                }
                
                if ($date != 'null') {
                    $year = substr($date, 2, 2);
                    $month = substr($date, 5, 2);
                    if ($month == '10'){
                        $monthDatas = 'A';
                    } else if ($month == '11'){
                        $monthDatas = 'B';
                    } else if ($month == '12'){
                        $monthDatas = 'C';
                    } else {
                        $monthDatas = ltrim($month, '0'); // Remove leading zero
                    }
                    $datas = $datas->whereRaw('SUBSTRING(code, 7, 3) = ?', [$year . $monthDatas]);
                }

                $datas = $datas->get();

                foreach ($datas as $key => $value) {
                    $year = '20' . substr($value->code, 6, 2);
                    $month = $value->code[8];
                    if ($month === 'A') {
                        $month = '10';
                    } elseif ($month === 'B') {
                        $month = '11';
                    } elseif ($month === 'C') {
                        $month = '12';
                    } elseif ($month >= '1' && $month <= '9') {
                        $month = '0' . $month;
                    }
                    $day = substr($value->code, 9, 2);
                
                    $formatted_date = $day . '/' . $month . '/' . $year;
                
                    $file->setActiveSheetIndex(0)->setCellValue('A' . $row . '', $no);
                    $file->setActiveSheetIndex(0)->setCellValue('B' . $row . '', $value->created_at->format('d/m/Y'));
                    $file->setActiveSheetIndex(0)->setCellValue('C' . $row . '', substr($value->code, 5, 1));
                    $file->setActiveSheetIndex(0)->setCellValue('D' . $row . '', $formatted_date);
                    $file->setActiveSheetIndex(0)->setCellValue('E' . $row . '', substr($value->code, 2, 2));
                    $file->setActiveSheetIndex(0)->setCellValue('F' . $row . '', substr($value->code, 12, 3));
                    $file->setActiveSheetIndex(0)->setCellValue('G' . $row . '', $value->pic);
                    $file->setActiveSheetIndex(0)->setCellValue('H' . $row . '', $value->area);
                    
                    $row++;
                    $no++;
                }
                
            })->setFilename("REKAP_NG_CSH_D98E" . $filenamedies . $filenameline . $filenamearea . $filenamedate)->export('xlsx');
        } else if ($programnumber == '08') {
            Excel::load('/storage/template/Export_Rekap_NG_CSH_D05E.xlsx',  function ($file) use ($programnumber, $dies, $line, $area, $date) {
                
                $row = "21";
                $no = '1';
                $datas = avi_trace_rekap_ng::orderBy('created_at', 'DESC')->whereRaw('SUBSTRING(code, 1, 2) = ?', [$programnumber]);

                if ($dies !== 'null') {
                    $datas = $datas->whereRaw('SUBSTRING(code, 3, 2) = ?', [$dies]);
                }

                if ($line !== 'null') {
                    $datas = $datas->whereRaw('SUBSTRING(code, 5, 2) = ?', [$line]);
                }

                if ($area !== 'null') {
                    $datas = $datas->where('area', 'like', '%' . $area . '%');
                }
                
                if ($date != 'null') {
                    $year = substr($date, 2, 2);
                    $month = substr($date, 5, 2);
                    if ($month == '10'){
                        $monthDatas = 'A';
                    } else if ($month == '11'){
                        $monthDatas = 'B';
                    } else if ($month == '12'){
                        $monthDatas = 'C';
                    } else {
                        $monthDatas = ltrim($month, '0'); // Remove leading zero
                    }
                    $datas = $datas->whereRaw('SUBSTRING(code, 7, 3) = ?', [$year . $monthDatas]);
                }

                $datas = $datas->get();

                foreach ($datas as $key => $value) {
                    $year = '20' . substr($value->code, 6, 2);
                    $month = $value->code[8];
                    if ($month === 'A') {
                        $month = '10';
                    } elseif ($month === 'B') {
                        $month = '11';
                    } elseif ($month === 'C') {
                        $month = '12';
                    } elseif ($month >= '1' && $month <= '9') {
                        $month = '0' . $month;
                    }
                    $day = substr($value->code, 9, 2);
                
                    $formatted_date = $day . '/' . $month . '/' . $year;
                
                    $file->setActiveSheetIndex(0)->setCellValue('A' . $row . '', $no);
                    $file->setActiveSheetIndex(0)->setCellValue('B' . $row . '', $value->created_at->format('d/m/Y'));
                    $file->setActiveSheetIndex(0)->setCellValue('C' . $row . '', substr($value->code, 5, 1));
                    $file->setActiveSheetIndex(0)->setCellValue('D' . $row . '', $formatted_date);
                    $file->setActiveSheetIndex(0)->setCellValue('E' . $row . '', substr($value->code, 2, 2));
                    $file->setActiveSheetIndex(0)->setCellValue('F' . $row . '', substr($value->code, 12, 3));
                    $file->setActiveSheetIndex(0)->setCellValue('G' . $row . '', $value->pic);
                    $file->setActiveSheetIndex(0)->setCellValue('H' . $row . '', $value->area);
                    
                    $row++;
                    $no++;
                }
                
            })->setFilename("REKAP_NG_CSH_D05E" . $filenamedies . $filenameline . $filenamearea . $filenamedate)->export('xlsx');
        }
    }
}
