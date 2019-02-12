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
        $warning_status = avi_andon_status::select('*')
        ->where('status','=', 1)
        ->get();

        // return $warning_status;
        return view('adminlte::dashboard.direct.line' , compact('lines','warning_status'));
    }
    // function popup_line(){
    //     $warning_status = avi_andon_status::select('*')->where('status','==',1);
    //     return view('adminlte::dashboard.direct.line' , compact('warning_status'));
    // }

}
