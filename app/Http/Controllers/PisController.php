<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\avi_customers;
use App\avi_parts;
use App\avi_mutations;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Input;
use DB;


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
        $part = avi_parts::where('part_number', $image)->get();
        $qty  = avi_parts::getQuantity($image);
        try{    

            if($part->isEmpty())
            {       
                return response()->json($part); 
            }
            else{

                DB::beginTransaction();

                $user           = \Auth::user()->id;

                for($i = 0 ; $i <= 1 ; $i++){

                    avi_mutations::insert(
                        ['mutation_date' => date('Y-m-d'), 
                         'quantity' => $i == 0 ? '-'.$qty->quantity : $qty->quantity, 
                         'part_number' => $image, 
                         'store_location' => $i == 0 ? config('global.warehouse_body.finish_good') : config('global.warehouse_body.staging'),
                         'npk' => $user, 
                         'flag_confirm' => 0]
                    );
                }

                DB::commit();

                return response()->json($part); 
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
