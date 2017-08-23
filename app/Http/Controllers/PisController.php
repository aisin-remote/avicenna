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


    public function getAjaxImage($image)
    {
        //
        $part = avi_parts::where('part_number', $image)->get();
        return response()->json($part); 

    }

    public function getPisTransaction()
    {
         // $data = array();
        $data['data'] = [];

            $part=avi_mutations::where('flag_confirm', 0)
                    ->orderBy('id', 'desc')
                    ->get();
            $i = 1;
            foreach ($part as $value) {

                 $data['data'][] = [
                    'no' => str_pad($i, 2, '0', STR_PAD_LEFT),
                    'part_number' => $value->part_number,                   
                ];
                $i++;
            }

        return $data;
    }

    public function insertMutation( Request $request )
    {
        try{

            DB::beginTransaction();

            $user           = \Auth::user()->id;
            $loading_list   = $request->get('loading_list');
            $part_number    = $request->get('part_number');
            $quantity       = avi_parts::getQuantity($part_number);

            avi_mutations::insert(
                ['mutation_date' => date('Y-m-d'), 'loading_list' => $loading_list, 
                 'quantity' => $quantity->quantity , 'part_number' => $part_number, 
                 'npk' => $user, 'flag_confirm' => 0]
            );

            DB::commit();
            return $detail_no;

        }
        catch(\Exception $e){

            return $e;
            DB::rollBack();

        }
        
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
