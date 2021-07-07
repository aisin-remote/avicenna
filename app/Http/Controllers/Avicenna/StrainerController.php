<?php

namespace App\Http\Controllers\Avicenna;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Avicenna\avi_trace_strainer;
use Carbon\Carbon;
use Datatables;

class StrainerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $strainers = avi_trace_strainer_master::select('*')->get();
        $lines     = avi_trace_line_master::select('*')->get();
        return view('tracebility.strainer.strainer', compact('strainers', 'lines'));
    }

    /**
     * Return a listing data resource in json.
     *
     * @return json
     */
    public function getDataStrainer()
    {
        $data = avi_trace_strainer::select('*')->with('strainer');
        return DataTables::eloquent($data)->make(true);
    }

    /**
     * Return a listing data resource in json.
     *
     * @return json
     */
    public function getStrainerMachining($line)
    {
        $now = Carbon::now();
        $data = avi_trace_strainer::select('*')
            ->where('line', $line)
            ->where('start_at', '<=', $now)
            ->where('end_at', '>=', $now)
            ->with('strainer')->first();
        if ($data == null) {
            return [
                'class' => null
            ];
        }
        $response = [
            'class' => $data->strainer->name,
            'customer' => $data->strainer->customer,
            'id' => $data->strainer->id
        ];

        return $response;
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
