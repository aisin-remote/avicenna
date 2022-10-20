<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// dev-1.0, 20170906, Ferry, Declare disini jika butuh Class bawaan laravel yang tidak auto-generated

// dev-1.0, 20170906, Ferry, Declare disini jika butuh Class customizing sendiri
use App\Models\Avicenna\avi_dashboard_genbas;
use App\Models\Avicenna\avi_andon_target;
use App\Models\Avicenna\avi_andon;
use App\Models\Avicenna\avi_andon_color;
use App\Models\Avicenna\avi_andon_status;
use App\Models\Avicenna\avi_furnace_status;
use App\Models\Avicenna\avi_trace_torimetron;
use App\Models\Avicenna\avi_andon_charts;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;



class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function choose()
    {
        return view('welcome');
    }
    function viewDashboardGenba()
    {

        return view('adminlte::dashboard.genba');
    }

    function getAjaxGenba()
    {

        $arr_result = avi_dashboard_genbas::all();
        return $arr_result;
    }

    function viewDashboardModel()
    {

        return view('adminlte::dashboard.model');
    }

    function getAjaxModel()
    {
        // $arr_result = avi_dashboard_models::all();
        // return $arr_result;
    }

    function andon()
    {
        $andons = avi_andon_target::with('actual', 'running')->get();
        return view('adminlte::dashboard.andon', compact('andons'));
    }

    function direct_andon()
    {
        $andons = avi_andon_target::with('actual', 'running')->get();
        return view('adminlte::dashboard.direct.andon', compact('andons'));
    }

    function direct_andon2()
    {
        $andons = avi_andon::join('avi_andon_details','avi_andons.back_number', '=', 'avi_andon_details.back_no')
            ->get();
        // return $andons;
        return view('adminlte::dashboard.direct.andon2' , compact('andons'));
    }
    function direct_line()
    {
        return view('adminlte::dashboard.direct.line' );
    }

    function mobileline()
    {
        return view('adminlte::dashboard.direct.mobileline' );
    }

    function direct_line_index()
    {
        $lines = [];
        $warning_status = avi_andon_status::select('line', 'error_at', 'pic_ldr', 'pic_spv', 'pic_mgr', 'pic_gm', 'plant', 'status')
            ->get();

        foreach ($warning_status as $warning ) {
            $now = Carbon::now();
            $pic = User::where('npk', $warning->pic_ldr)->first();
            switch ($warning->status) {
                case 1:
                    $message = 'OK';
                    break;

                case 2:
                    $message = 'PROBLEM MESIN';
                    break;

                case 3:
                    $message = 'PROBLEM QUALITY';
                    break;

                case 4:
                    $message = 'PROBLEM SUPPLY PART';
                    break;

                case 5:
                    $message = 'DANDORI';
                    break;

                default:
                    $message = 'MACHINE OFF';
                    break;
            }

            $line = [
                'email' => $pic->email,
                'phone' => $pic->phone_number,
                'name' => $pic->name,
                'error_at' => $warning->error_at ? $warning->error_at : $now->format('Y-m-d H:i:s'),
                'line' => $warning->line,
                'plant' => $warning->plant,
                'status' => $warning->status,
                'message' => $message
            ];

            if ($warning->error_at) {
                $errorAt = Carbon::createFromFormat('Y-m-d H:i:s', $warning->error_at);
                if ($errorAt->diffInSeconds($now) > env('AVI_EMAIL_LINE_3', 7200)) {
                    $pic = User::where('npk', $warning->pic_gm)->first();
                } elseif ($errorAt->diffInSeconds($now) > env('AVI_EMAIL_LINE_2', 3600)) {
                    $pic = User::where('npk', $warning->pic_mgr)->first();
                } elseif ($errorAt->diffInSeconds($now) > env('AVI_EMAIL_LINE_1', 1800)) {
                    $pic = User::where('npk', $warning->pic_ldr)->first();
                }
                $line['name'] = $pic->name;
                $line['phone'] = $pic->phone_number;
                $line['email'] = $pic->email;
            }
            $lines[] = $line;
        }


        $furnaces = avi_furnace_status::where('value', 1)->get();
        foreach($furnaces as $furnace) {
            $key = array_search($furnace->line, array_column($lines, 'line'));
            $furPic = $furnace->user;

            if ($lines[$key]['status'] != 1 && $lines[$key]['status'] != 0) {
                // jika tidak mati atau error maka concat statusnya
                if (!strpos(strtolower(str_replace(' ', '', $lines[$key]['email'])), strtolower($furPic->email))) {
                    // handle duplicate name in message
                    $lines[$key]['name'] .= ', ' . $furPic->name;
                    $lines[$key]['phone'] .= ', ' . $furPic->phone_number;
                    $lines[$key]['email'] .= ', ' . $furPic->email;
                }
                $lines[$key]['message'] .= ', ' . $furnace->furnace . ' mati 30 menit';
            } else {
                // ubah statusnya menjadi 2 (problem mesin)
                $lines[$key]['name'] = $furPic->name;
                $lines[$key]['phone'] = $furPic->phone_number;
                $lines[$key]['email'] = $furPic->email;
                $lines[$key]['message'] = $furnace->furnace . ' mati 30 menit';
                $lines[$key]['status'] = 3;
            }
        }

        return $lines;
    }

    function andon_charts()
    {
        $prevMonthStart = Carbon::now()->subMonth()->startOfMonth();
        $prevMonthEnd = Carbon::now()->subMonth()->endOfMonth();
        $start = Carbon::now()->startOfMonth();
        $today = Carbon::now()->startOfDay();
        $end = Carbon::now();
        $startMonth = Carbon::now()->startOfMonth();
        $endMonth = Carbon::now()->endofMonth();
        $notNgToday = avi_trace_torimetron::where('status', 1)->whereBetween('updated_at', [$today, $end])->count();
        $ngToday = avi_trace_torimetron::where('status', 0)->whereBetween('updated_at', [$today, $end])->count();
        $notNgMonth = avi_trace_torimetron::where('status', 1)->whereBetween('updated_at', [$startMonth, $endMonth])->count();
        $ngMonth = avi_trace_torimetron::where('status', 0)->whereBetween('updated_at', [$startMonth, $endMonth])->count();
        $solved = avi_andon_charts::whereNotNull('finish_at')
        ->whereBetween('error_at', [$start, Carbon::parse($end)->endOfDay()])
        ->count();
        $unsolved = avi_andon_charts::whereNull('finish_at')
        ->whereBetween('error_at', [$start, Carbon::parse($end)->endOfDay()])
        ->count();
        $prevSolved = avi_andon_charts::whereNotNull('finish_at')
        ->whereBetween('error_at', [$prevMonthStart, Carbon::parse($prevMonthEnd)->endOfDay()])
        ->count();
        $prevUnsolved = avi_andon_charts::whereNull('finish_at')
        ->whereBetween('error_at', [$prevMonthStart, Carbon::parse($prevMonthEnd)->endOfDay()])
        ->count();
        $type2 = avi_andon_charts::where('status', 2)
        ->whereBetween('error_at', [$start, Carbon::parse($end)->endOfDay()])
        ->count();
        $type3 = avi_andon_charts::where('status', 3)
        ->whereBetween('error_at', [$start, Carbon::parse($end)->endOfDay()])
        ->count();
        $type4 = avi_andon_charts::where('status', 4)
        ->whereBetween('error_at', [$start, Carbon::parse($end)->endOfDay()])
        ->count();
        $avgType2 = avi_andon_charts::where('status', 2)
        ->where(DB::raw('TIMEDIFF(finish_at, error_at)'), '>=', 5)
        ->whereNotNull('finish_at')
        ->whereBetween('error_at', [$start, Carbon::parse($end)->endOfDay()])
        ->avg(DB::raw('TIMEDIFF(finish_at, error_at)'));
        $avgType3 = avi_andon_charts::where('status', 3)
        ->where(DB::raw('TIMEDIFF(finish_at, error_at)'), '>=', 5)
        ->whereNotNull('finish_at')
        ->whereBetween('error_at', [$start, Carbon::parse($end)->endOfDay()])
        ->avg(DB::raw('TIMEDIFF(finish_at, error_at)'));
        $avgType4 = avi_andon_charts::where('status', 4)
        ->where(DB::raw('TIMEDIFF(finish_at, error_at)'), '>=', 5)
        ->whereNotNull('finish_at')
        ->whereBetween('error_at', [$start, Carbon::parse($end)->endOfDay()])
        ->avg(DB::raw('TIMEDIFF(finish_at, error_at)'));
        if ($avgType2 == null) {
            $avgType2 = 0;
        } else {
            $avgType2 = $avgType2;
        }
        if ($avgType3 == null) {
            $avgType3 = 0;
        } else {
            $avgType3 = $avgType3;
        }
        if ($avgType4 == null) {
            $avgType4 = 0;
        } else {
            $avgType4 = $avgType4;
        }
        $avgType2 = round($avgType2, 0);
        $avgType3 = round($avgType3, 0);
        $avgType4 = round($avgType4, 0);
        $labelStart = $start->format('d-m-Y');
        $labelEnd = $end->format('d-m-Y');  
        $total = $solved + $unsolved;
        if ($solved == 0 && $unsolved == 0) {
            $percentageSolved = 0;
            $percentageUnsolved = 0;
        } else {
            $percentageSolved = round(($solved / $total) * 100, 0);
            $percentageUnsolved = round(($unsolved / $total) * 100, 0);
        }
        $percentageSolved = round($percentageSolved, 1);
        $percentageUnsolved = round($percentageUnsolved, 1);
        $avgMin2 = gmdate("H:i:s", $avgType3);
        $avgMin3 = gmdate("H:i:s", $avgType3);
        $avgMin4 = gmdate("H:i:s", $avgType4);

        return view('adminlte::dashboard.direct.andon_charts', [
            'solved' => $solved,
            'unsolved' => $unsolved,
            'type2' => $type2,
            'type3' => $type3,
            'type4' => $type4,
            'avgType2' => $avgType2,
            'avgType3' => $avgType3,
            'avgType4' => $avgType4,
            'start' => $labelStart,
            'end' => $labelEnd,
            'prevSolved' => $prevSolved,
            'prevUnsolved' => $prevUnsolved,
            'notNgToday' => $notNgToday,
            'ngToday' => $ngToday,
            'notNgMonth' => $notNgMonth,
            'ngMonth' => $ngMonth,
            'avgMin2' => $avgMin2,
            'avgMin3' => $avgMin3,
            'avgMin4' => $avgMin4,
            'percentageSolved' => $percentageSolved,
            'percentageUnsolved' => $percentageUnsolved,
        ]);
    }

}
