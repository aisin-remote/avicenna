<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// dev-1.0, 20170906, Ferry, Declare disini jika butuh Class bawaan laravel yang tidak auto-generated

// dev-1.0, 20170906, Ferry, Declare disini jika butuh Class customizing sendiri
use App\Models\Avicenna\avi_dashboard_genbas;
use App\Models\Avicenna\avi_andon_target;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

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

        return view('adminlte::dashboard.direct.andon2');
    }

}
