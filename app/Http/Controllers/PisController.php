<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;   //pemecah error tokenmismatch
// dev-1.0, 20170906, Ferry, Declare disini jika butuh Class bawaan laravel yang tidak auto-generated
use DB;
use Auth;
use Storage;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Input;

// dev-1.0, 20170906, Ferry, Declare disini jika butuh Class customizing sendiri
use App\Models\Avicenna\avi_parts;
use App\Models\Avicenna\avi_part_pis;
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
    public function getAjaxImage($image, $type, $dock)
    {
        // dev-1.0, Ferry, 20170926, Normalisasi string barcode
        $image  = strlen($image) == 208 ? substr($image, 53, 16) : $image;  // dev-1.0, Ferry, 20170926, Cust SIM
        $image  = str_replace("-","", $image);
        $image  = strlen($image) == 14 ? substr($image, 0, 10) : $image;
        $image  = strlen($image) == 12 ? (substr($image, -2) == "00" ? substr($image, 0, 10) : $image) : $image;

        $path_suffix = '-'.$type.'-'.$dock.'.JPG';

        $part_pis   = avi_part_pis::whereRaw('REPLACE(part_number_customer, "-", "") LIKE "%'.$image.'%"')
                            ->where('part_kind', $type)
                            ->where('part_dock', $dock)
                            ->first(); // dev-1.0, Ferry, 20170908, set to first //dev-1.0, by yudo, 20170609, change part number customer
        try{    

            if(! $part_pis)
            {       
                // return response()->json($part);      // dev-1.0, Ferry, Commented ganti yg lebih bersih
                return array("part_number_customer" => "");
            }
            else{

                DB::beginTransaction();

                $user           = Auth::user();
                $part = $part_pis->hasPart;    // dev-1.0, Ferry, 20170927, Ambil info master avi_part nya

                // for($i = 0 ; $i <= 1 ; $i++){ //akitfkan jika prioritas 2 dijalankan
                $scan = new avi_mutations;
                $scan->mutation_code        = config('avi_mutation.gi_out_delivery');
                $scan->mutation_date        = date('Y-m-d');
                // $scan->quantity = $i == 0 ? '-'.$scan->quantity_box : $scan->quantity_box; //prioritas 2
                $scan->quantity             = $part_pis->qty_kanban * -1;
                $scan->part_number          = is_null($part_pis->part_number_agbond) ? $part_pis->part_number : $part_pis->part_number_agbond;
                $scan->part_number_customer = $part_pis->part_number_customer;
                $scan->part_kind            = $part_pis->part_kind;
                $scan->part_dock            = $part_pis->part_dock;
                $scan->part_name            = $part->part_name;
                $scan->customer             = $part_pis->customer_code;
                $scan->back_number          = $part_pis->back_number;
                // 'store_location = $i == 0 ? config('global.warehouse_body.finish_good') : config('global.warehouse_body.staging'), //prioritas 2
                $scan->store_location       = config('avi_location.fg_store');
                $scan->npk                  = $user->npk;
                $scan->flag_confirm         = 0;
                $scan->uom_code             = config('avi_uom.pcs');
                $scan->save();

                DB::commit();

                $counter = avi_mutations::where('mutation_date', date('Y-m-d'))
                                        ->where('mutation_code', config('avi_mutation.gi_out_delivery'))
                                        ->where('npk', $user->npk)
                                        ->count();

                // dev-1.0, Ferry, 20170926, ambil info last scan
                $last_scan = avi_mutations::selectRaw('back_number, part_kind, COUNT(id) AS total_kanban')
                                            ->where('mutation_code', config('avi_mutation.gi_out_delivery'))
                                            ->where('npk', $user->npk)
                                            ->groupBy('back_number', 'part_kind')
                                            ->orderBy('created_at', 'desc')
                                            ->take(5)
                                            ->get();

                // return response()->json($part);      // dev-1.0, Ferry, Commented ganti yg lebih bersih
                $arrJSON = array(
                                "img_path" => Storage::exists('/public/pis/'.$part_pis->part_number_customer.$path_suffix) ? 
                                                asset('storage/pis/'.$part_pis->part_number_customer.$path_suffix) :
                                                asset('storage/pis/default.JPG'),
                                "part_number_customer" => $part_pis->part_number_customer,
                                "counter"   => $counter,
                                "last_scan" => $last_scan
                        );

                return $arrJSON;
            }

        }
        catch(\Exception $e){

            DB::rollBack();
            return array( "part_number_customer" => "", "error" => $e->getMessage() );
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

    function PisMasterView(){
       //dev-1.0, ambil data pis dari avi_part_pis
        $avi_part_piss  = avi_part_pis::selectRaw("0 as validasi, id, part_number_customer, part_number, back_number, qty_kanban, part_kind, part_dock, CONCAT(part_number_customer,'-',part_kind,'-',part_dock,'.JPG') as img_path")
                                        ->get();    
                                        // return $avi_part_piss;
        foreach ($avi_part_piss as $avi_part_pis) {
                                        $avi_part_pis->validasi = Storage::exists('/public/pis/'.$avi_part_pis->img_path) ? 
                                                "Ada" :
                                                "Belum Ada"; 

                                        }                                
                                   // return $avi_part_piss;
        return view('pis.ViewMasterPis',compact('avi_part_piss'));
    }

    function UpdatePis($id){
       //dev-1.0, ambil data pis dari avi_part_pis untuk tampil di view update
        $avi_part_piss  = avi_part_pis::select("*",DB::raw("CONCAT(part_number_customer,'-',part_kind,'-',part_dock,'.JPG') as img_path"))
                                        ->where('id',$id)
                                        ->get();
                                        
        return view('pis.UpdatePis',compact('avi_part_piss'));
    }

    function UpdatePisProses(Request $request){
       
        $input=\Request::all();
        $id=$input['id'];
        $part_number=$input['part_number'];
        $back_no=$input['back_no']; 
        $dock=$input['part_dock'];
        $type=$input['type']; 
        $qty=$input['qty'];
        $img_path  = $input['part_picture'];
        $destinationPath = asset('storage/pis');

        try{
            \DB::beginTransaction();

            // simpan ke database
            $avp=avi_part_pis::find($id);
            $avp->part_number_customer=$part_number;
            $avp->back_number=$back_no;
            $avp->qty_kanban=$qty;
            $avp->part_dock=$dock;
            $avp->part_kind=$type;
            $avp->save(); 

            //upload gambar ke 
            $file = $request->file('part_picture');
            $filesName = $part_number.'-'.$type.'-'.$dock.'.JPG';
            $file->move(public_path('storage/pis/'),$filesName);
            \DB::commit();
            \Session::flash('flash_type', 'alert-success');
            \Session::flash('flash_message', 'Sukses simpan atur ulang data');
            
            return redirect('/pis/master');
        }catch(Exception $e){
            \DB::rollback();
            \Session::flash('flash_type', 'alert-danger');
            \Session::flash('flash_message', 'Gagal mengatur ulang data karena '.$e->getMessage());
            return \Redirect::Back();
        }
                                       
        return url('/pis/master');
    }

    function PisPreview($img){
       
       $arrJSONpict = array(
                        
        $img_path = Storage::exists('/public/pis/'.$img) ? 
                      asset('storage/pis/'.$img) :
                      asset('storage/pis/default.JPG')
                    );
       
       return view('pis.PisPreview',compact('img_path'));
    }

    function PisSearch(){
        $input=\Request::all();
       
        $oem=$input['oem'];

        $gnp=$input['gnp'];
        $dock_4N=$input['dock_4N']; 
        $dock_4L=$input['dock_4L'];

            if(isset($input['oem']) or isset($input['gnp'])){ 
                $avi_part_piss  = avi_part_pis::select("*",DB::raw("CONCAT(part_number_customer,'-',part_kind,'-',part_dock,'.JPG') as img_path"))
                                        ->whereIn('part_kind',[$oem,$gnp])
                                        ->orWhereIn('part_dock',[$dock_4L,$dock_4N])
                                        ->get();
                
            }else{

            }

            if(isset($input['dock_4N']) or isset($input['dock_4L'])){ //oem dan gnp
                $avi_part_piss  = avi_part_pis::select("*",DB::raw("CONCAT(part_number_customer,'-',part_kind,'-',part_dock,'.JPG') as img_path"))
                                        ->whereIn('part_kind',[$oem,$gnp])
                                        ->orWhereIn('part_dock',[$dock_4L,$dock_4N])
                                        ->get();
            }else{

            }

        // $avi_part_piss  = avi_part_pis::select("*",DB::raw("CONCAT(part_number,'-',part_kind,'-',part_dock,'.JPG') as img_path"))
        //                                 ->whereIn('part_kind',[$oem,$gnp])
        //                                 ->orWhereIn('part_dock',[$dock_4L,$dock_4N])
        //                                 ->get();
                                        // return $avi_part_piss;       
        return view('pis.ViewMasterPis',compact('avi_part_piss'));
    }
    public function AddNewPis()
     {
         
            $input = Input::all();
            $avi_part_pis                        = new avi_part_pis;
            $avi_part_pis->part_number           =$input['part_number'];
            $avi_part_pis->part_number_customer  =$input['part_number_customer'];
            $avi_part_pis->customer_code_ag      =$input['customer_code_ag'];
            $avi_part_pis->part_kind             =$input['part_kind'];
            $avi_part_pis->part_dock             =$input['part_dock'];
            $avi_part_pis->back_number           =$input['back_number'];
            $avi_part_pis->qty_kanban            =$input['qty_kanban'];

            $avi_part_pis->save();
        
            \Session::flash('flash_type','alert-success');
            \Session::flash('flash_message','New part was successfully created');
            return redirect('/part/master');

        
     }

    function GetAjaxPart(){
        $term=\Request::all();
        if(!isset($term['q'])){
            return [];
        }
        $term=$term['q'];
        if(strlen($term) < 2){
            return [];
        }
        return avi_parts::where('part_number','like','%'.$term.'%')
            ->get()->toArray();
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
