<?php

namespace App\Http\Controllers\Avicenna;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Avicenna\avi_machining;

class UnitDashboardController extends Controller
{
    function viewpage(){
    	return view('adminlte::dashboard.direct.unittools');
    }

    function getAjaxData(){
    	$data=avi_machining::all();
    	return $data;
    }
}
