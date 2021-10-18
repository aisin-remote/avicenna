<?php

namespace App\Http\Controllers\Avicenna;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Avicenna\avi_trace_kanban;
use Carbon\Carbon;
use Datatables;

class RegisController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('tracebility.registrasi.registrasi');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function tambah()
    {
        return view('tracebility.registrasi.tambah');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function tambahAjax(Request $request)
    {
        // return "DATAAAA";

        // $request->validate([
        //     'scan' => 'required',
        //     'tipe' => 'required',
        //     ]);

        $data = $request->tipe;

        if ($data == 'reguler') {
            
            $kanban = $request->scan;
                $arr = preg_split('/ +/', $kanban);

                    if ($arr[8] == '0') {

                        $lenght = strlen($arr[10]);
                        $result = substr($arr[10], $lenght-4);

                        avi_trace_kanban::create([
                            'no_seri' => $result,
                            'jenis_kanban' => $request->tipe,
                         ]);
                    }
                    elseif ($arr[9] == '0') {
                        
                        $lenght = strlen($arr[11]);
                        $result = substr($arr[11], $lenght-4);

                        avi_trace_kanban::create([
                            'no_seri' => $result,
                            'jenis_kanban' => $request->tipe,
                         ]);
                    }
                    else {

                        $lenght = strlen($arr[9]);
                        $result = substr($arr[9], $lenght-4);

                        avi_trace_kanban::create([
                            'no_seri' => $result,
                            'jenis_kanban' => $request->tipe,
                         ]);
                    }
            
            return [
                        "error" => false,
                        "messege" => "Registrasi ". $result . " Sukses Disimpan !"
                    ];
        }
        elseif ($data == 'buffer') {
            
            $kanban = $request->scan;
                $arr = preg_split('/ +/', $kanban);

                    if ($arr[8] == '0') {

                        $lenght = strlen($arr[10]);
                        $result = substr($arr[10], $lenght-4);

                        avi_trace_kanban::create([
                            'no_seri' => $result,
                            'jenis_kanban' => $request->tipe,
                         ]);
                    }
                    elseif ($arr[9] == '0') {
                        
                        $lenght = strlen($arr[11]);
                        $result = substr($arr[11], $lenght-4);

                        avi_trace_kanban::create([
                            'no_seri' => $result,
                            'jenis_kanban' => $request->tipe,
                         ]);
                    }
                    else {

                        $lenght = strlen($arr[9]);
                        $result = substr($arr[9], $lenght-4);

                        avi_trace_kanban::create([
                            'no_seri' => $result,
                            'jenis_kanban' => $request->tipe,
                         ]);
                    }
            
            return [
                        "error" => false,
                        "messege" => "Registrasi ". $result . " Sukses Disimpan !"
                    ];
        }
        else {

            return [
                        "error" => true,
                        "messege" => "Registrasi ". $result . " Gagal!"
                    ];
        }
               
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getData()
    {
        $data = avi_trace_kanban::select('id', 'no_seri', 'jenis_kanban', 'created_at');
        return DataTables::eloquent($data)
            ->addColumn('actions', function($data) {
                if ($data->finish_at == NULL) {
                    return '<button class="btn btn-danger btn-action" onclick="delete_regis(' . $data->id . ')">
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete = avi_trace_kanban::find($id);
        $delete->delete();
        return redirect('/trace/regis-kanban')->with('success', 'Data berhasil dihapus');
    }

}