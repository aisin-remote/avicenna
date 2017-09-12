<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// dev-1.0, 20170906, Ferry, Declare disini jika butuh Class bawaan laravel yang tidak auto-generated
use DB;
use Auth;
use Storage;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Input;

// dev-1.0, 20170906, Ferry, Declare disini jika butuh Class customizing sendiri
use App\Models\Avicenna\avi_parts;
use App\Models\Avicenna\avi_mutations;
use App\Models\Avicenna\avi_customers;


class PisController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $customer = avi_customers::all();
        return view('pis/index', compact('customer'));
    }

    //dev-1.0, 20170824, by  yudo, getajax image sekaligus insert ke table mutation
    public function getAjaxImage($image)
    {       
        $image  = str_replace("-","", $image);
        
        $part   = avi_parts::whereRaw('CONCAT(REPLACE(part_number_customer, "-", ""), "000") LIKE "%'.$image.'%"')
                            ->first(); // dev-1.0, Ferry, 20170908, set to first //dev-1.0, by yudo, 20170609, change part number customer
        
        // $qty    = avi_parts::getQuantity($image);
        
        try{    

            if(! $part)
            {       
                // return response()->json($part);      // dev-1.0, Ferry, Commented ganti yg lebih bersih
                return array("part_number_customer" => "");
            }
            else{

                DB::beginTransaction();

                $user           = Auth::user();

                // for($i = 0 ; $i <= 1 ; $i++){ //akitfkan jika prioritas 2 dijalankan
                $scan = new avi_mutations;
                $scan->mutation_code        = config('avi_mutation.gi_out_delivery');
                $scan->mutation_date        = date('Y-m-d');
                // $scan->quantity = $i == 0 ? '-'.$scan->quantity_box : $scan->quantity_box; //prioritas 2
                $scan->quantity             = $part->quantity_box * -1;
                $scan->part_number          = $part->part_number;
                $scan->part_number_customer = $part->part_number_customer;
                $scan->part_name            = $part->part_name;
                $scan->customer             = $part->customer_id;
                // 'store_location = $i == 0 ? config('global.warehouse_body.finish_good') : config('global.warehouse_body.staging'), //prioritas 2
                $scan->store_location       = config('avi_location.fg_store');
                $scan->npk                  = $user->npk;
                $scan->flag_confirm         = 0;
                $scan->uom_code             = config('avi_uom.pcs');
                $scan->save();

                DB::commit();

                // return response()->json($part);      // dev-1.0, Ferry, Commented ganti yg lebih bersih
                $arrJSON = array(
                                "img_path" => Storage::exists('/public/pis/'.$part->part_number_customer.'.JPG') ? 
                                                asset('storage/pis/'.$part->part_number_customer.'.JPG') :
                                                asset('storage/pis/default.JPG'),
                                "part_number_customer" => $part->part_number_customer
                        );
                return $arrJSON;
            }

        }
        catch(\Exception $e){

            return $e;
            DB::rollBack();

        }
        

    }
    

    function viewDashboardMutation(){

        return view('adminlte::dashboard.mutation');
    } 


    function getAjaxMutation(){ 

        $arr_result = avi_mutations::selectRaw('SUM(quantity) AS new_qty, part_number')
                                                    ->where('store_location', config('global.warehouse_body.finish_good'))
                                                    ->groupBy('part_number')
                                                    ->get();
        return $arr_result;
    } 

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
