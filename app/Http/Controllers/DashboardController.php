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

        $andons = avi_andon::join('avi_andon_details','avi_andons.back_number', '=', 'avi_andon_details.back_no')->get();

        // return $andons;
        return view('adminlte::dashboard.direct.andon2' , compact('andons'));
    }
    function direct_line(){
        return view('adminlte::dashboard.direct.line' );
    }

    function mobileline(){
        return view('adminlte::dashboard.direct.mobileline' );
    }

    function direct_line_index(){
        $lines = array();
        $warning_status = avi_andon_status::select('line')
        ->get();
        foreach ($warning_status as $warning ) {
            $error_at = avi_andon_status::select('error_at')
            ->where('line', $warning->line)->first();

            $now     = Carbon::now();
            $error1 = Carbon::parse($error_at->error_at);
            $error2 = Carbon::parse($error_at->error_at);
            $error3 = Carbon::parse($error_at->error_at);
                $satu   = env('AVI_EMAIL_LINE_1', 300);
                $dua    = env('AVI_EMAIL_LINE_2', 600);
                $tiga   = env('AVI_EMAIL_LINE_3', 900);
                    $a = $error1->addSeconds($satu);
                    $b = $error2->addSeconds($dua);
                    $c = $error3->addSeconds($tiga);
                    

            if($error_at->error_at && $error1 < $now && $now < $a){
                $d = avi_andon_status::select('avi_andon_status.line','avi_andon_status.status', 'users.name as name', 'users.email as email', 'users.phone_number as phone', 'avi_andon_status.plant', 'avi_andon_status.error_at')->join('users','users.npk','avi_andon_status.pic_ldr')->where('line', $warning->line)->first();
            }elseif ($error_at->error_at && $a < $now && $now < $b) {
                $d = avi_andon_status::select('avi_andon_status.line','avi_andon_status.status', 'users.name as name', 'users.email as email', 'users.phone_number as phone', 'avi_andon_status.plant', 'avi_andon_status.error_at')->join('users','users.npk','avi_andon_status.pic_spv')->where('line', $warning->line)->first();

            }elseif ($error_at->error_at && $b < $now && $now < $c) {
                $d = avi_andon_status::select('avi_andon_status.line','avi_andon_status.status', 'users.name as name', 'users.email as email', 'users.phone_number as phone', 'avi_andon_status.plant', 'avi_andon_status.error_at')->join('users','users.npk','avi_andon_status.pic_mgr')->where('line', $warning->line)->first();
            }elseif ($error_at->error_at && $now > $c){
                $d = avi_andon_status::select('avi_andon_status.line','avi_andon_status.status', 'users.name as name', 'users.email as email', 'users.phone_number as phone', 'avi_andon_status.plant', 'avi_andon_status.error_at')->join('users','users.npk','avi_andon_status.pic_gm')->where('line', $warning->line)->first();
                
            }else{
                $d = avi_andon_status::select('avi_andon_status.line','avi_andon_status.status', 'users.name as name', 'users.email as email', 'users.phone_number as phone', 'avi_andon_status.plant', 'avi_andon_status.error_at')->join('users','users.npk','avi_andon_status.pic_ldr')->where('line', $warning->line)->first();

            }
            if($d){
                if(!$d->error_at) $d->error_at = Carbon::now()->format('Y-m-d H:i');
            }
            array_push($lines, $d );
            
            $flag = avi_andon_status::where('line', $warning->line)->first();
            if ($flag->status == 1 ) {
                    $flag->flag_spv = 0;
                    $flag->flag_mgr = 0;
                    $flag->flag_gm = 0;
                    $flag->error_at = NULL;
                    $flag->save();
            }
        }

        return $lines;
    }

}
