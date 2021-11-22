<?php

namespace App\Http\Controllers\Avicenna;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Avicenna\avi_trace_kanban_master;
use App\Models\Avicenna\avi_trace_delivery;
use App\Models\Avicenna\avi_trace_kanban;
use App\Models\Avicenna\avi_trace_machining;
use App\Models\Avicenna\avi_trace_assembling;
use Carbon\Carbon;
use Datatables;
use Auth;
use DB;
    
class ResetController extends Controller
{
    /**
     * Reset Kanban Part NG view
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function resetngViewMA()
    {
        return view('tracebility.reset.resetkanbanpartng');
    }
    /**
     * Reset Kanban Part NG view
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function resetngViewAS()
    {
        return view('tracebility.reset.resetkanbanpartngAS');
    }

    /**
     * Reset Kanban Part NG
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function resetngMA(Request $request)
    {
        $user = Auth::user();
        $npk = $user->npk;
        $kanban = $request->scan;
        $line = $request->input_line;
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
            $update = avi_trace_machining::select('status')->where('code', $cek->code_part)->first();

            if ($cek) {
                 
                DB::beginTransaction();
                $update->status = 0;
                $cek->code_part = null;
                $cek->code_part_2 = null;
                $cek->save();

                DB::commit();

                return [
                        "error" => false,
                        "messege" => "Kanban ". $seri . $back . " Telah Tereset"
                    ];
            } else {

                return [
                        "error" => true,
                        "messege" => "Kanban ". $seri . $back . " Gagal Tereset"
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

    /**
     * Reset Kanban Part NG
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function resetngAS(Request $request)
    {
        $user = Auth::user();
        $npk = $user->npk;
        $kanban = $request->scan;
        $line = $request->input_line;
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
            $update = avi_trace_assembling::select('status')->where('code', $cek->code_part)->first();

            if ($cek) {
                 
                DB::beginTransaction();
                $update->status = 0;
                $cek->code_part = null;
                $cek->code_part_2 = null;
                $cek->save();

                DB::commit();

                return [
                        "error" => false,
                        "messege" => "Kanban ". $seri . $back . " Telah Tereset"
                    ];
            } else {

                return [
                        "error" => true,
                        "messege" => "Kanban ". $seri . $back . " Gagal Tereset"
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