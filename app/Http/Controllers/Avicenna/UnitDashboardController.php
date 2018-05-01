<?php

namespace App\Http\Controllers\Avicenna;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Avicenna\avi_machining;
use App\Models\Avicenna\avi_machining_master;

class UnitDashboardController extends Controller
{
    function viewpage(){
    	$mesins=avi_machining::all();
    	return view('adminlte::dashboard.direct.unittools2',compact('mesins'));
    }

    function getAjaxData(){
    	$data=avi_machining::all();
    	return $data;
    }

    function getAjaxMesin($id_mesin){
    	$allmesin=avi_machining::where('machine_no',$id_mesin)->get();
        $mesin_data=avi_machining_master::find($id_mesin);
        $data= array($allmesin,$mesin_data);
    	return $data;
    }
}
