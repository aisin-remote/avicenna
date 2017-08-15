<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\m_customers;
use App\m_parts;
use App\inventory_mutations;
use Yajra\Datatables\Datatables;

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
        $customer = m_customers::all();
        return view('pis/index', compact('customer'));
    }


    public function getAjaxImage($image)
    {
        //
        $part = m_parts::where('part_number', $image)->get();

        return response()->json($part); 

    }

    public function getPisTransaction()
    {
         // $data = array();
        $data['data'] = [];

            $part=m_parts::get();
            $i = 1;
            foreach ($part as $value) {

                 $data['data'][] = [
                        //Hotfix-2.12 by Ferry on 20150812 no urut
                    // $value->budget_no,
                    'no' => str_pad($i, 2, '0', STR_PAD_LEFT),
                    'part_number' => $value->part_number,                   //Hotfix-2.12 by Ferry on 20150814 asset no
                ];
                $i++;
            }
        

        return $data;
           // return $part;
        // $users = m_parts::select(['id','part_number']);

        // return Datatables::of($users)->make();
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
