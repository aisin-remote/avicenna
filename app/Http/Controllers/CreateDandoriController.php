<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Avicenna\avi_part_production;
use App\Models\Avicenna\avi_running_model;
use App\Models\Avicenna\avi_andon_dandori;

class CreateDandoriController extends Controller
{
    //Display Index
	function index(){
		$running_models = avi_running_model::all();
		return view('adminlte::dandori.CreateDandori',compact('running_models'));
	}

    //Search Part Number By Ajax
	function GetAjaxPart(){
		$term=\Request::all();
		if(!isset($term['q'])){
			return [];
		}
		$term=$term['q'];
		if(strlen($term) < 2){
			return [];
		}
		return avi_part_production::select('part_number','back_number')->where('back_number','like','%'.$term.'%')
		->get()->toArray();
		//return avi_part_production::all();
	}

	//function get Running Model Information
	function GetAjaxModel(){
		$id_running_model=\Request::all()['id'];
		$model = avi_running_model::find($id_running_model);
		return $model;
	}

	//Fungsi Update
	function Update(){
		$back_number = \Request::all()['new_back_number'];
		$running_model = \Request::all()['old_running_model'];
		//Select Data berdasarkan New Model yg dipilih dari avi_running_model
		$model=avi_running_model::find($running_model);
		// return $model;
		if($model != null){
			//Update AVI ANDON DADNDORI
			$dandori = avi_andon_dandori::where('ip_address','=',$model->ip_address)->first();
			$dandori->timestamps = false;
			$dandori->back_no = $back_number;
			$dandori->line=$model->line_name;
			$dandori->is_dandori=TRUE;
			$dandori->save();
			\Session::flash('flash_type', 'alert-success');
			\Session::flash('flash_message', __('avicenna/dandori.success_msg'));
		}

		return \Redirect::Back();
		
	}
}
