<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Avicenna\avi_part_production;
use App\Models\Avicenna\avi_running_model;
use App\Models\Avicenna\avi_andon_dandori;
use App\Models\Avicenna\avi_mutations;
use Carbon\Carbon;

class CreateDandoriController extends Controller
{    
	function viewpage($line_number){
		if ($line_number!=''){
			$running_model=avi_running_model::where('line_number',$line_number)->first();
			$models=avi_part_production::where('line_number',$line_number)->get();
			// return $running_model;
			return view('adminlte::dandori.MakeDandori',compact(['models','running_model','line_number']));
		}else{
			return "error page";
		}
		
	}

	function GetQuantityRunningModel(){
		$line_number=\Request::all()['line_number'];
		// $line_number='AS600';
		$model=avi_running_model::where('line_number',$line_number)->first();
		return $model->quantity;
	}

	function Create(){
		$is_start=\Request::all()['is_start'];
		$back_number=\Request::all()['back_number'];
		$line_number=\Request::all()['line_number'];
		
		$mutation_date=Carbon::now();
		if($mutation_date->hour <= 6){
			$mutation_date=Carbon::yesterday();
		}

		try{
			\DB::beginTransaction();
			$model=avi_part_production::where('back_number',$back_number)->first();
			$mutasi=new avi_mutations();
			$mutasi->mutation_date=$mutation_date;
			$mutasi->mutation_code='141';
			$mutasi->part_number=$model->part_number;
			$mutasi->back_number=$model->back_number;
			$mutasi->store_location='FG01';
			$mutasi->quantity=0;
			$mutasi->uom_code='PCS';
			$mutasi->npk=$line_number;
			$mutasi->save();

			$running_model=avi_running_model::where('line_number',$line_number)->first();	
			//Update
			if($is_start=='true'){
				$running_model->buffer=15;
			}else{
				$qty_before=$running_model->quantity;
				$buffer_before=$running_model->buffer;
				$running_model->buffer=$qty_before+$buffer_before;
			}
			$running_model->quantity=0;
			$running_model->id_handled=$mutasi->id;
			$running_model->part_number=$model->part_number;
			$running_model->back_number=$model->back_number;
			$running_model->dandori_date=$mutation_date;	
			$running_model->save();
			\DB::commit();
		}catch(Exception $e){
			\DB::rollback();
			return "failed because: ".$e->getMessage();
		}
	}


}
