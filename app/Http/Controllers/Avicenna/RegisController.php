<?php

namespace App\Http\Controllers\Avicenna;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Avicenna\avi_trace_kanban_master;
use App\Models\Avicenna\avi_trace_delivery;
use App\Models\Avicenna\avi_trace_kanban;
use Carbon\Carbon;
use Datatables;
use Auth;
use DB;

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
                        $master = avi_trace_kanban_master::where('back_nmr', $arr[9])->select('id')->first();
                        $valid = avi_trace_kanban::where('no_seri', $result)->where('master_id', $master->id)->first();

                        if ($valid == null) {
                        avi_trace_kanban::create([
                            'no_seri' => $result,
                            'jenis_kanban' => $request->tipe,
                            'master_id' => $master->id,
                         ]);
                        }else {

                            return [
                        "error" => true,
                        "messege" => "Registrasi ". $result . " Gagal!"
                    ];
                        }
                    }
                    elseif ($arr[9] == '0') {

                        $lenght = strlen($arr[11]);
                        $result = substr($arr[11], $lenght-4);
                        $master = avi_trace_kanban_master::where('back_nmr', $arr[9])->select('id')->first();
                        $valid = avi_trace_kanban::where('no_seri', $result)->where('master_id', $master->id)->first();

                        if ($valid == null) {
                        avi_trace_kanban::create([
                            'no_seri' => $result,
                            'jenis_kanban' => $request->tipe,
                            'master_id' => $master->id,
                         ]);
                        }else {

                            return [
                        "error" => true,
                        "messege" => "Registrasi ". $result . " Gagal!"
                    ];
                        }
                    }
                    else {

                        $lenght = strlen($arr[9]);
                        $result = substr($arr[9], $lenght-4);
                        $master = avi_trace_kanban_master::where('back_nmr', $arr[9])->select('id')->first();
                        $valid = avi_trace_kanban::where('no_seri', $result)->where('master_id', $master->id)->first();

                        if ($valid == null) {
                        avi_trace_kanban::create([
                            'no_seri' => $result,
                            'jenis_kanban' => $request->tipe,
                            'master_id' => $master->id,
                         ]);
                        }else {

                            return [
                        "error" => true,
                        "messege" => "Registrasi ". $result . " Gagal!"
                    ];
                        }
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
                        $master = avi_trace_kanban_master::where('back_nmr', $arr[9])->select('id')->first();
                        $valid = avi_trace_kanban::where('no_seri', $result)->where('master_id', $master->id)->first();

                        if ($valid == null) {
                        avi_trace_kanban::create([
                            'no_seri' => $result,
                            'jenis_kanban' => $request->tipe,
                            'master_id' => $master->id,
                         ]);
                        }else {

                            return [
                        "error" => true,
                        "messege" => "Registrasi ". $result . " Gagal!"
                    ];
                        }
                    }
                    elseif ($arr[9] == '0') {

                        $lenght = strlen($arr[11]);
                        $result = substr($arr[11], $lenght-4);
                        $master = avi_trace_kanban_master::where('back_nmr', $arr[9])->select('id')->first();
                        $valid = avi_trace_kanban::where('no_seri', $result)->where('master_id', $master->id)->first();

                        if ($valid == null) {
                        avi_trace_kanban::create([
                            'no_seri' => $result,
                            'jenis_kanban' => $request->tipe,
                            'master_id' => $master->id,
                         ]);
                        }else {

                            return [
                        "error" => true,
                        "messege" => "Registrasi ". $result . " Gagal!"
                    ];
                        }
                    }
                    else {

                        $lenght = strlen($arr[9]);
                        $result = substr($arr[9], $lenght-4);
                        $master = avi_trace_kanban_master::where('back_nmr', $arr[9])->select('id')->first();
                        $valid = avi_trace_kanban::where('no_seri', $result)->where('master_id', $master->id)->first();

                        if ($valid == null) {
                        avi_trace_kanban::create([
                            'no_seri' => $result,
                            'jenis_kanban' => $request->tipe,
                            'master_id' => $master->id,
                         ]);
                        }else {

                            return [
                        "error" => true,
                        "messege" => "Registrasi ". $result . " Gagal!"
                    ];
                        }
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function manualDeliveryView()
    {
        return view('tracebility.registrasi.manual-delivery');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function manualDelivery(Request $request)
    {
        $user = Auth::user();
        $npk = $user->npk;
        $kanban = $request->scan;
        $arr = preg_split('/ +/', $kanban);

        if ($arr[8] == '0') {

            $lenght = strlen($arr[10]);
            $seri = substr($arr[10], $lenght-4);
            $back = $arr[9];
        }
        elseif ($arr[9] == '0') {

            $lenght = strlen($arr[11]);
            $seri = substr($arr[11], $lenght-4);
            $back = $arr[10];
        }
        else {

            $lenght = strlen($arr[9]);
            $seri = substr($arr[9], $lenght-4);
            $back = $arr[8];
        }
        try{
            $cekMaster = avi_trace_kanban_master::select('id')->where('back_nmr', $back)->first();
            $cek    = avi_trace_kanban::where('no_seri', $seri)->where('master_id', $cekMaster->id)->whereNotNull('code_part')->first();
            if ($cek) {
                DB::beginTransaction();
                    $scan                       = new avi_trace_delivery;
                    $scan->code                 = $cek->code_part;
                    $scan->cycle                = $request->cycle;
                    $scan->customer             = $request->customer;
                    $scan->npk                  = $npk;
                    $scan->date                 = date('Y-m-d');
                    $scan->status               = 1;
                    $scan->save();
                    if ($cek->code_part_2) {
                        $scan2                       = new avi_trace_delivery;
                        $scan2->code                 = $cek->code_part_2;
                        $scan2->cycle                = $request->cycle;
                        $scan2->customer             = $request->customer;
                        $scan2->npk                  = $npk;
                        $scan2->date                 = date('Y-m-d');
                        $scan2->status               = 1;
                        $scan2->save();
                    }

                    $cek->code_part = null;
                    $cek->code_part_2 = null;
                    $cek->save();



                DB::commit();

                return [
                        "error" => false,
                        "messege" => "Delivery ". $seri . " Sukses!"
                    ];
            }else{
                return [
                        "error" => true,
                        "messege" => "Data ". $seri . " Not Found!"
                    ];
            }

        }catch(\Exception $e){

         DB::rollBack();
            return [
                        "error" => true,
                        "messege" => $e->getMessage()
                    ];
        }


    }

}