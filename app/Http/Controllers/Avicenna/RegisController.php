<?php

namespace App\Http\Controllers\Avicenna;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Avicenna\avi_trace_strainer;
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
        $this->validate($request,[
            'scan' => 'required',
            'tipe' => 'required'
            ]);

        $input = $request->scan;
        if ($input) {
            $data = avi_trace_kanban::create([
                'no_seri' => $request->scan,
                'jenis_kanban' => $request->tipe
            ]);

            return [
                        "error" => false,
                        "messege" =>  " Registrasi - (". $request->scan . ") Berhasil !"
                    ];
        }
        else 
        {
            return [
                        "error" => true,
                        "messege" => "Registrasi " . $request->scan . " Gagal !"
                    ];
        }
        

    } 
}