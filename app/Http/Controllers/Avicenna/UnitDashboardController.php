<?php

namespace App\Http\Controllers\Avicenna;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Avicenna\avi_machining;
use App\Models\Avicenna\avi_machining_master;

class UnitDashboardController extends Controller
{
    function viewpage(){
    	$mesins=avi_machining_master::all();
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

    function getAjaxMesin2($id_mesin){
        $allmesin=avi_machining::where('machine_no',$id_mesin)->get();
        $mesin_data=avi_machining_master::find($id_mesin);
        $normal=\DB::table('avi_machining')
                            ->where('machine_no',$id_mesin)
                            ->where('std_life_time','>','actual_life_time+100')
                            ->count();
        $warning=\DB::table('avi_machining')
                            ->where('machine_no',$id_mesin)
                            ->where('std_life_time','>=','actual_life_time')
                            ->where('std_life_time','<','actual+100')
                            ->count();
        $over=\DB::table('avi_machining')
                            ->where('machine_no',$id_mesin)
                            ->where('std_life_time','<','actual_life_time')
                            ->count();
        $data= array($allmesin,$mesin_data,$normal,$warning,$over);
        return $data;
    }
}
