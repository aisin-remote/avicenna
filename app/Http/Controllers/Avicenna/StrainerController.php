<?php

namespace App\Http\Controllers\Avicenna;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Avicenna\avi_trace_strainer;
use App\Models\Avicenna\avi_trace_strainer_master;
use App\Models\Avicenna\avi_trace_line_master;
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
        return DataTables::eloquent($data)
            ->addColumn('actions', function($data) {
                if ($data->finish_at == NULL) {
                    return '<button class="btn btn-danger btn-action" onclick="delete_strainer(' . $data->id . ')">
                        <i class="fa fa-trash"></i>
                        </button>';
                } else {
                    return '<span>
                    Confirmed
                </span>';
                }
            })
            ->rawColumns(['actions'])
            ->make(true);
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
    public function create(Request $request)
    {

        $start_date = $request->start_at.' 06-00-00';
        $end_date = Carbon::createFromTimestamp(strtotime($request->end_at . '06:00:00'));
        $strainer = new avi_trace_strainer;
        $strainer->strainer_id = $request->strainer;
        $strainer->line = $request->line;
        $strainer->start_at = $start_date;
        $strainer->end_at = $end_date->addDays(1);
        $strainer->save();


        return redirect('/trace/view/strainer')->with('success', 'Data berhasil ditambahkan');
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
        $delete = avi_trace_strainer::find($id);
        $delete->delete();
        return redirect('/trace/view/strainer')->with('success', 'Data berhasil dihapus');
    }
}
