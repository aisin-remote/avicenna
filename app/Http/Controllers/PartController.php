<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;   //pemecah error tokenmismatch
// dev-1.0, 20170906, Ferry, Declare disini jika butuh Class bawaan laravel yang tidak auto-generated
use DB;
use Auth;
use Storage;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Input;

// dev-1.0, 20170906, Ferry, Declare disini jika butuh Class customizing sendiri
use App\Models\Avicenna\avi_parts;
use App\Models\Avicenna\avi_part_pis;
use App\Models\Avicenna\avi_mutations;
use App\Models\Avicenna\avi_customers;

class PartController extends Controller
{
    //
    public function index()
    {
        
        $avi_part_piss  = avi_parts::All();
        
        return view('part.index',compact('avi_part_piss'));
    }

    public function AddNewParts()
	 {
	 	 
		 	$input = Input::all();
			$avi_part                        = new avi_parts;
			$avi_part->part_number           =$input['part_number'];
			$avi_part->part_number_nostrip   =$input['part_number_nostrip'];
			$avi_part->part_number_ag        =$input['part_number_ag'];
			$avi_part->part_name             =$input['part_name'];
			$avi_part->product_group         =$input['product_group'];
			$avi_part->min_stock             =$input['min_stock'];
			$avi_part->max_stock             =$input['max_stock'];
            
			$avi_part->save();
		
			\Session::flash('flash_type','alert-success');
	        \Session::flash('flash_message','New part was successfully created');
		 	return redirect('/part/master');

	 	
	 }

    function UpdateParts($id){
       //dev-1.0, ambil data pis dari avi_part_pis untuk tampil di view update
        $avi_part  = avi_parts::select("*")
                                        ->where('id',$id)
                                        ->get();
                                        
        return view('part.UpdatePart',compact('avi_part'));
    }

    function UpdatePartProses(Request $request){
       
        $input=\Request::all();
        $id=$input['id'];
        $part_number=$input['part_number'];
        $part_number_nostrip=$input['part_number_nostrip']; 
        $part_number_ag=$input['part_number_ag'];
        $part_name=$input['part_name']; 
        $product_group=$input['product_group'];
        $product_line  = $input['product_line'];
        $min_stock = $input['min_stock'];
        $max_stock = $input['max_stock'];
        try{
            \DB::beginTransaction();

            // simpan ke database
            $avp=avi_parts::find($id);
            $avp->part_number=$part_number;
            $avp->part_number_nostrip=$part_number_nostrip;
            $avp->part_number_ag=$part_number_ag;
            $avp->part_name=$part_name;
            $avp->product_group=$product_group;
            $avp->product_line=$product_line;
            $avp->min_stock=$min_stock;
            $avp->max_stock=$max_stock;
            $avp->save(); 

            
            \DB::commit();
            \Session::flash('flash_type', 'alert-success');
            \Session::flash('flash_message', 'Sukses simpan atur ulang data');
            
            return redirect('/part/master');
        }catch(Exception $e){
            \DB::rollback();
            \Session::flash('flash_type', 'alert-danger');
            \Session::flash('flash_message', 'Gagal mengatur ulang data karena '.$e->getMessage());
            return \Redirect::Back();
        }
                                       
        return url('/part/master');
    } 
} //tutup function
