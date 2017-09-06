<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// dev-1.0, 20170906, Ferry, Declare disini jika butuh Class bawaan laravel yang tidak auto-generated
use Auth;

// dev-1.0, 20170906, Ferry, Declare disini jika butuh Class customizing sendiri
use App\Models\Avicenna\avi_parts;
use App\Models\Avicenna\avi_opname;
use App\Models\Avicenna\avi_mutations;
use App\Models\Avicenna\avi_locations;

class CreateOpnameController extends Controller
{
	function Opname(){
		$locations=avi_locations::all();
		return view('adminlte::opname.CreateOpname',compact('locations'));
	}   

	function GetAjaxPart(){
		$term=\Request::all();
		if(!isset($term['q'])){
			return [];
		}
		$term=$term['q'];
		if(strlen($term) < 2){
			return [];
		}
		return avi_parts::where('part_number','like','%'.$term.'%')
			->get()->toArray();
	}

	function SaveOpname(){
		$input=\Request::all();
		$part_number=$input['part_number'];
		$opname_quantity=$input['opname_quantity'];
		$qty_avi_opname=0;
		$qty_avi_mutation=0;
		$qty_inserted=0;
		$date_start=date('Y-m-d',strtotime('2011-08-02'));
		$date_end=date('Y-m-d');
		$location_code=$input['location'];
		$opname_user_id=1;
		$npk=Auth::user()->npk;
		$flag=1;

		$opname=avi_opname::where('part_number','=',$part_number)
				->orderby('id','desc')
				->first();
		
		if($opname!=null){
			$qty_avi_opname=$opname['opname_quantity'];
			$date_start=date('Y-m-d',strtotime($opname['opname_date']));
		}

		$qty_avi_mutation=avi_mutations::where('part_number','=',$part_number)
				->where('mutation_date',">",$date_start)
				->where('mutation_date','<=',$date_end)
				->sum('quantity');
		
		$qty_total=$qty_avi_opname+$qty_avi_mutation;
		
		if($opname_quantity!=$qty_total){
			$qty_inserted=$opname_quantity-$qty_total;
		}else{
			$qty_inserted=$qty_total;
		}

		try {
			\DB::beginTransaction();
			$new_opname=new avi_opname();
			$new_opname->part_number=$part_number;
			$new_opname->opname_date=date('Y-m-d');
			$new_opname->opname_quantity=$opname_quantity;
			$new_opname->location_code=$location_code;
			$new_opname->opname_user_id=$opname_user_id;
			$new_opname->save();

			$new_mutation=new avi_mutations();
			$new_mutation->mutation_date=date('Y-m-d');
			$new_mutation->mutation_code=($qty_inserted > 0 ? config('avi_mutation.sto_fg_in') : config('avi_mutation.sto_fg_out'));
			$new_mutation->part_number=$part_number;
			$new_mutation->quantity=$qty_inserted;
			$new_mutation->store_location=$location_code;
			$new_mutation->flag_confirm=$flag;
			$new_mutation->npk=$npk;
			$new_mutation->save();

			\DB::commit();
			return \Redirect::Back();
			
		} catch (Exception $e) {
			\DB::rollback();
			return \Redirect::Back();
			
		}
		
	}
}
