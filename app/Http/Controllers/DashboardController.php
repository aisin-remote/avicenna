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
use Carbon\Carbon;



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
    function viewDashboardGenba(){

        return view('adminlte::dashboard.genba');
    }

    function getAjaxGenba(){ 

        $arr_result = avi_dashboard_genbas::all();
        return $arr_result;
    } 

    function viewDashboardModel(){

        return view('adminlte::dashboard.model');
    } 

    function getAjaxModel(){ 

        $arr_result = avi_dashboard_models::all();
        return $arr_result;
    }

    function andon(){
        $andons = avi_andon_target::with('actual', 'running')->get();

        return view('adminlte::dashboard.andon', compact('andons'));
    }

    function direct_andon(){
        $andons = avi_andon_target::with('actual', 'running')->get();

        return view('adminlte::dashboard.direct.andon', compact('andons'));
    }

    function direct_andon2(){

        // $andons = avi_andon::select('*')->get();

        $andons = avi_andon::select('*', 'avi_andon_details.line as lin','avi_andon_details.back_no as back')
        ->join('avi_andon_details','avi_andons.word', '=', 'avi_andon_details.word')->get();

        return view('adminlte::dashboard.direct.andon2' , compact('andons'));
    }
    function direct_line(){
        $lines = avi_andon_status::select('*')->get();
        $a = array();
        $warning_status = avi_andon_status::select('line')
        ->where('status','=', 2)
        ->get();

        foreach ($warning_status as $warning ) {

            $update_at = avi_andon_status::select('updated_at')
            ->where('line', $warning->line)->first();
            $now     = Carbon::now();

            if($update_at->updated_at <= $now && $now <= $update_at->updated_at->addSeconds(300)){
                $d = avi_andon_status::select('*', 'avi_andon_status.pic_ldr as pic')->where('line', $warning->line)->first();
            }elseif ($update_at->updated_at->addSeconds(300) <= $now && $now <= $update_at->updated_at->addSeconds(600)) {
                $d = avi_andon_status::select('*', 'avi_andon_status.pic_spv as pic')->where('line', $warning->line)->first();
            }elseif ($update_at->updated_at->addSeconds(600) <= $now && $now <= $update_at->updated_at->addSeconds(900)) {
                $d = avi_andon_status::select('*', 'avi_andon_status.pic_mgr as pic')->where('line', $warning->line)->first();
            }else{
                $d = avi_andon_status::select('*', 'avi_andon_status.pic_gm as pic')->where('line', $warning->line)->first();
            }
            array_push($a, $d);
        }
        return view('adminlte::dashboard.direct.line' , compact('lines','a'));
    }

    function direct_line_index(){
        $lines = avi_andon_status::select('line','status')->get();
        return $lines;
    }

}
