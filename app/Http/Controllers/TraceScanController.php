<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use Datatables;
use Carbon\Carbon;
use GuzzleHttp\Client;
use App\Jobs\SendDataDowa;
use Illuminate\Http\Request;
use App\Models\Avicenna\avi_trace_ng;
use Illuminate\Support\Facades\Cache;
use App\Models\Avicenna\avi_trace_cycle;
use App\Models\Avicenna\avi_dowa_process;
use App\Models\Avicenna\avi_trace_kanban;
use App\Models\Avicenna\avi_trace_casting;
use App\Models\Avicenna\avi_trace_printer;
use App\Models\Avicenna\avi_trace_delivery;
use App\Models\Avicenna\avi_trace_strainer;
use App\Models\Avicenna\avi_trace_machining;
use App\Models\Avicenna\avi_trace_ng_master;
use App\Models\Avicenna\avi_trace_assembling;
use App\Models\Avicenna\avi_trace_kanban_master;
use App\Models\Avicenna\avi_trace_program_number;
use App\Models\Avicenna\avi_trace_ng_casting_temp;

class TraceScanController extends Controller
{

    // MODUL CASTING
    //=======================================================================================================================================================

    public function scancasting()
    {
        return view('tracebility/casting/scan');
    }

    // update part d98e by fabian 01232023
    public function scancastingd98e()
    {
        return view('tracebility.casting.d98e');
    }

    public function getAjaxcasting($number, $line)
    {
        // dev-1.0, Ferry, 20170926, Normalisasi string barcode
        try {

            $cek        = avi_trace_casting::where('code', $number)->first();

            if (is_null($cek)) {

                DB::beginTransaction();
                $user                       = Auth::user();
                $scan                         = new avi_trace_casting;
                $scan->code                 = $number;
                $scan->date                 = date('Y-m-d');
                $scan->line                 = $line;
                $scan->npk                     = $user->npk;
                $scan->status               = 1;
                $a                          = substr($number, 0, 2);
                $product                    = avi_trace_program_number::where('code', $a)->first();
                if (is_null($product)) {
                    // $product                = new avi_trace_program_number();
                    return "Not OPN 889F Model";
                }

                $scan->save();

                DB::commit();

                // hit api rts
                // parse line
                $area = substr($line, 0, 2);

                // get back number
                $fgPart = avi_trace_program_number::select('back_number')->where('code', $a)->first();
                $backNum = $fgPart->back_number;
                $qty = 1;

                $ch = curl_init(env('API_RTS') . '/' . $area . '/' . $backNum . '/' . $qty . '/' . $number . '/');

                // Mengabaikan verifikasi SSL
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

                // Eksekusi permintaan
                curl_exec($ch);

                $key = 'casting_' . $user->npk;
                if (Cache::has($key)) {
                    $cache = Cache::get($key);

                    if (!isset($cache[date('Y-m-d')])) {
                        $cache = [];
                        $cache = [
                            date('Y-m-d') => [
                                'counter' => 1,
                                'items' => [
                                    $number
                                ]
                            ]
                        ];
                    } else {
                        $cache[date('Y-m-d')]['counter'] += 1;
                        if (count($cache[date('Y-m-d')]['items']) >= 10) {
                            unset($cache[date('Y-m-d')]['items'][0]);
                        }
                        $cache[date('Y-m-d')]['items'][] = $number;
                        $cache[date('Y-m-d')]['items'] = array_values($cache[date('Y-m-d')]['items']);
                    }
                } else {
                    $cache = [
                        date('Y-m-d') => [
                            'counter' => 1,
                            'items' => [
                                $number
                            ]
                        ]
                    ];
                }

                Cache::forever($key, $cache);
                $arrJSON = array(
                    "code"        => $number,
                    "counter"   => $cache[date('Y-m-d')]['counter']
                );

                // Fitur maps inject


                // End Fitur

                return $arrJSON;
            } else {
                // return response()->json($part);      // dev-1.0, Ferry, Commented ganti yg lebih bersih
                return array("code" => "");
            }
        } catch (\Exception $e) {

            DB::rollBack();
            return array("code" => "", "error" => $e->getMessage());
        }
    }

    // update by fabian 01232023 || MODUL Casting part d98e
    public function cekPartD98e(Request $request)
    {

        $codePart = $request->get('code');

        $cek = avi_trace_casting::where('code', $codePart)->first();

        if ($cek) {
            return array(
                "code" => "false",
            );
        } else {
            return array(
                "code" => $codePart,
            );
        }
    }

    public function getAjaxCastingD98e(Request $request)
    {
        $user = Auth::user()->npk;
        $kbn_int = $request->kbn_int;
        $line = isset($request->line) ? $request->line : '';
        $number1 = isset($request->code1) ? $request->code1 : '';
        $number2 = isset($request->code2) ? $request->code2 : '';
        $numcek = substr($number1, 0, 2);

        if ($number1 == $number2) {
            return ["code" => "partdouble"];
        }

        if ($kbn_int) {
            $arr = preg_split('/ +/', $kbn_int);
            if ($arr[8] == '0') {
                $length = strlen($arr[10]);
                $seri = substr($arr[10], $length - 4);
                $back_number = $arr[9];
            } elseif ($arr[7] == '0') {
                $length = strlen($arr[9]);
                $seri = substr($arr[9], $length - 4);
                $back_number = $arr[8];
            } elseif ($arr[9] == '0') {

                $length = strlen($arr[11]);
                $seri = substr($arr[11], $length - 4);
                $back_number = $arr[10];
            } else {

                $length = strlen($arr[9]);
                $seri = substr($arr[9], $length - 4);
                $back_number = $arr[8];
            }

            // Check back number data in kanban master table
            $cekMaster = avi_trace_kanban_master::select('id', 'back_nmr')->where('back_nmr', $back_number)->first();
            if (!$cekMaster) {
                return ["code" => "notregistered"];
            }

            // check back number data in program number table based on first digit of code
            $cekProgNums = avi_trace_program_number::select('back_number')->where('code',  $numcek)->get();
            $isReturn = 0;

            foreach ($cekProgNums as $cekProgNum) {
                // match the data from kanban master table and program number table
                if ($cekMaster->back_nmr == $cekProgNum->back_number) {
                    $isReturn = 1;
                }
            }

            if ($isReturn == 0) {
                return ["code" => "notmatch"];
            }

            // check code part in kanban table based on serial number (kanban scan) and master_id (id of back_nummber)
            $cek = avi_trace_kanban::select('code_part')->where('no_seri', $seri)->where('master_id', $cekMaster->id)->first();

            // check existing code part in casting
            $cekPartCasting = avi_trace_casting::where('code', $number1)->first();

            if ($cekPartCasting) {
                return ["code" => "partExist"];
            }

            if ($cek == null) {
                return ["code" => "notregistered"];
            }

            if ($cek->code_part == null) {
                $key = 'casting_' . $line;
                if (Cache::has($key)) {
                    $cache = Cache::get($key);
                    if (!isset($cache[date('Y-m-d')])) {
                        $cache = [];
                        $cache = [
                            date('Y-m-d') => [
                                'counter' => 1
                            ]
                        ];
                    } else {
                        $cache[date('Y-m-d')]['counter'] += 1;
                    }
                } else {
                    $cache = [
                        date('Y-m-d') => [
                            'counter' => 1
                        ]
                    ];
                }



                Cache::forever($key, $cache);
                try {
                    DB::beginTransaction();
                    $update = avi_trace_kanban::where('no_seri', $seri)->where('master_id', $cekMaster->id)->update(['code_part' => $number1, 'code_part_2' => $number2]);
                    $casting = avi_trace_casting::create([
                        'date' => date('Y-m-d'),
                        'line' => $line,
                        'npk' => $user,
                        'status' => "1",
                        'code' => $number1,
                    ]);
                    $casting = avi_trace_casting::create([
                        'date' => date('Y-m-d'),
                        'line' => $line,
                        'npk' => $user,
                        'status' => "1",
                        'code' => $number2,
                    ]);

                    // hit api rts
                    $area = substr($line, 0, 2);
                    $backNum = avi_trace_program_number::select('back_number')->where('code',  $numcek)->first();
                    $qty = 2;
                    $numbers = [$number1, $number2];

                    // foreach ($numbers as $number) {
                    $ch = curl_init(env('API_RTS') . '/' . $area . '/' . $backNum->back_number . '/' . $qty . '/');

                    // Ignore SSL verification
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

                    // Execute the request
                    $response = curl_exec($ch);
                    // }

                    DB::commit();
                } catch (\Throwable $th) {
                    DB::rollBack();
                    return [
                        "status" => "error",
                        "messege" => "Data Not Saved, Please Rescan Part & Kanban"
                    ];
                }

                return [
                    "status" => "success",
                    "counter"   => $cache[date('Y-m-d')]['counter'],
                    "code" => $number1 . " & " . $number2,
                    "kbn_int" => $seri,
                ];
            } else {
                return ["code" => "Kanbannotreset"];
            }
        } else {
            return ["code" => "notregistered"];
        }
    }

    public function castingng()
    {
        return view('tracebility/casting/ng');
    }


    public function castingng2()
    {
        return view('tracebility/casting/ng2');
    }

    /**
     * Fungsi get data part
     *
     */
    public function getPartCastingNg($part)
    {
        $aviCasting = avi_trace_casting::where('code', $part)->first();
        if ($aviCasting) {
            $aviCasting->status = 0;
            $aviCasting->save();
        }

        $aviNg = avi_trace_ng::with('ngdetail')->where('code', $part)->get();
        if ($aviNg) {
            return $aviNg;
        }
        return $part;
    }

    /**
     * Fungsi input data part
     *
     */
    public function inputPartCastingNg($part, $ng)
    {
        $user = Auth::user();
        $cekNg = avi_trace_ng_master::where('id', $ng)->first();
        if (!$cekNg) {
            return [
                "status" => "error",
                "messege" => "DATA ID NG TIDAK DITEMUKAN"
            ];
        }

        $b                 = substr($part, 5, 1);
        $line             = "DCAA0" . $b . "";
        if ($b == "A") {
            $line             = "DCAA10";
        }

        $partNg = avi_trace_ng::where('code', $part)->where('id_ng', $ng)->first();
        if ($partNg) {
            $partNg->delete();
            $type = 'delete';
        } else {
            $inputNg = avi_trace_ng::create([
                'code' => $part,
                'date' => date('Y-m-d'),
                'id_ng' => $ng,
                'line' => $line,
                'pic' => $user->npk
            ]);
            $type = 'input';
        }
        $aviNg = avi_trace_ng::with('ngdetail')->where('code', $part)->get();
        return [
            "type" => $type,
            "data" => $aviNg
        ];
    }

    public function getLineCasting($part)
    {
        $today = date('Y-m-d');
        $tomorrow = date('Y-m-d', strtotime('+1 days'));
        $yesterday = date('Y-m-d', strtotime('-1 days'));
        $b = substr($part, 5, 1);
        $line = "DCAA0" . $b . "";
        if ($b == "A") {
            $line             = "DCAA10";
        }
        $counter = [];
        $lineName = [];
        $totalPart = [];

        if (date('H:i') >= '06:00' && date('H:i') <= '13:59') {
            if ($line == 'DCAA01' || $line == 'DCAA02' || $line == 'DCAA03') {
                $counter[0] =  DB::table('avi_trace_ngs as a')
                    ->select('b.name', DB::raw('count(a.id) as counter'))
                    ->join('avi_trace_ng_masters as b', 'a.id_ng', '=', 'b.id')
                    ->where('a.line', 'DCAA01')
                    ->whereBetween('a.created_at', [$today . ' 06:00:00', $today . ' 14:00:00'])
                    ->groupBy('a.id_ng')
                    ->get();
                $counter[1] =  DB::table('avi_trace_ngs as a')
                    ->select('b.name', DB::raw('count(a.id) as counter'))
                    ->join('avi_trace_ng_masters as b', 'a.id_ng', '=', 'b.id')
                    ->where('a.line', 'DCAA02')
                    ->whereBetween('a.created_at', [$today . ' 06:00:00', $today . ' 14:00:00'])
                    ->groupBy('a.id_ng')
                    ->get();
                $counter[2] =  DB::table('avi_trace_ngs as a')
                    ->select('b.name', DB::raw('count(a.id) as counter'))
                    ->join('avi_trace_ng_masters as b', 'a.id_ng', '=', 'b.id')
                    ->where('a.line', 'DCAA03')
                    ->whereBetween('a.created_at', [$today . ' 06:00:00', $today . ' 14:00:00'])
                    ->groupBy('a.id_ng')
                    ->get();
                $lineName[0] = 'DCAA01';
                $lineName[1] = 'DCAA02';
                $lineName[2] = 'DCAA03';
                $totalPart[0] = DB::table('avi_trace_ngs')
                    ->where('line', 'DCAA01')
                    ->whereBetween('created_at', [$today . ' 06:00:00', $today . ' 14:00:00'])
                    ->count(DB::raw('DISTINCT code'));
                $totalPart[1] = DB::table('avi_trace_ngs')
                    ->where('line', 'DCAA02')
                    ->whereBetween('created_at', [$today . ' 06:00:00', $today . ' 14:00:00'])
                    ->count(DB::raw('DISTINCT code'));
                $totalPart[2] = DB::table('avi_trace_ngs')
                    ->where('line', 'DCAA03')
                    ->whereBetween('created_at', [$today . ' 06:00:00', $today . ' 14:00:00'])
                    ->count(DB::raw('DISTINCT code'));
            }
            if ($line == 'DCAA04' || $line == 'DCAA05') {
                $counter[0] =  DB::table('avi_trace_ngs as a')
                    ->select('b.name', DB::raw('count(a.id) as counter'))
                    ->join('avi_trace_ng_masters as b', 'a.id_ng', '=', 'b.id')
                    ->where('a.line', 'DCAA04')
                    ->whereBetween('a.created_at', [$today . ' 06:00:00', $today . ' 14:00:00'])
                    ->groupBy('a.id_ng')
                    ->get();
                $counter[1] =  DB::table('avi_trace_ngs as a')
                    ->select('b.name', DB::raw('count(a.id) as counter'))
                    ->join('avi_trace_ng_masters as b', 'a.id_ng', '=', 'b.id')
                    ->where('a.line', 'DCAA05')
                    ->whereBetween('a.created_at', [$today . ' 06:00:00', $today . ' 14:00:00'])
                    ->groupBy('a.id_ng')
                    ->get();
                $lineName[0] = 'DCAA04';
                $lineName[1] = 'DCAA05';
                $totalPart[0] = DB::table('avi_trace_ngs')
                    ->where('line', 'DCAA04')
                    ->whereBetween('created_at', [$today . ' 06:00:00', $today . ' 14:00:00'])
                    ->count(DB::raw('DISTINCT code'));
                $totalPart[1] = DB::table('avi_trace_ngs')
                    ->where('line', 'DCAA05')
                    ->whereBetween('created_at', [$today . ' 06:00:00', $today . ' 14:00:00'])
                    ->count(DB::raw('DISTINCT code'));
            }
            if ($line == 'DCAA06' || $line == 'DCAA07' || $line == 'DCAA08') {
                $counter[0] =  DB::table('avi_trace_ngs as a')
                    ->select('b.name', DB::raw('count(a.id) as counter'))
                    ->join('avi_trace_ng_masters as b', 'a.id_ng', '=', 'b.id')
                    ->where('a.line', 'DCAA06')
                    ->whereBetween('a.created_at', [$today . ' 06:00:00', $today . ' 14:00:00'])
                    ->groupBy('a.id_ng')
                    ->get();
                $counter[1] =  DB::table('avi_trace_ngs as a')
                    ->select('b.name', DB::raw('count(a.id) as counter'))
                    ->join('avi_trace_ng_masters as b', 'a.id_ng', '=', 'b.id')
                    ->where('a.line', 'DCAA07')
                    ->whereBetween('a.created_at', [$today . ' 06:00:00', $today . ' 14:00:00'])
                    ->groupBy('a.id_ng')
                    ->get();
                $counter[2] =  DB::table('avi_trace_ngs as a')
                    ->select('b.name', DB::raw('count(a.id) as counter'))
                    ->join('avi_trace_ng_masters as b', 'a.id_ng', '=', 'b.id')
                    ->where('a.line', 'DCAA08')
                    ->whereBetween('a.created_at', [$today . ' 06:00:00', $today . ' 14:00:00'])
                    ->groupBy('a.id_ng')
                    ->get();
                $lineName[0] = 'DCAA06';
                $lineName[1] = 'DCAA07';
                $lineName[2] = 'DCAA08';
                $totalPart[0] = DB::table('avi_trace_ngs')
                    ->where('line', 'DCAA06')
                    ->whereBetween('created_at', [$today . ' 06:00:00', $today . ' 14:00:00'])
                    ->count(DB::raw('DISTINCT code'));
                $totalPart[1] = DB::table('avi_trace_ngs')
                    ->where('line', 'DCAA07')
                    ->whereBetween('created_at', [$today . ' 06:00:00', $today . ' 14:00:00'])
                    ->count(DB::raw('DISTINCT code'));
                $totalPart[2] = DB::table('avi_trace_ngs')
                    ->where('line', 'DCAA08')
                    ->whereBetween('created_at', [$today . ' 06:00:00', $today . ' 14:00:00'])
                    ->count(DB::raw('DISTINCT code'));
            }
        } elseif (date('H:i') >= '14:00' && date('H:i') <= '21:59') {
            if ($line == 'DCAA01' || $line == 'DCAA02' || $line == 'DCAA03') {
                $counter[0] =  DB::table('avi_trace_ngs as a')
                    ->select('b.name', DB::raw('count(a.id) as counter'))
                    ->join('avi_trace_ng_masters as b', 'a.id_ng', '=', 'b.id')
                    ->where('a.line', 'DCAA01')
                    ->whereBetween('a.created_at', [$today . ' 14:00:00', $today . ' 22:00:00'])
                    ->groupBy('a.id_ng')
                    ->get();
                $counter[1] =  DB::table('avi_trace_ngs as a')
                    ->select('b.name', DB::raw('count(a.id) as counter'))
                    ->join('avi_trace_ng_masters as b', 'a.id_ng', '=', 'b.id')
                    ->where('a.line', 'DCAA02')
                    ->whereBetween('a.created_at', [$today . ' 14:00:00', $today . ' 22:00:00'])
                    ->groupBy('a.id_ng')
                    ->get();
                $counter[2] =  DB::table('avi_trace_ngs as a')
                    ->select('b.name', DB::raw('count(a.id) as counter'))
                    ->join('avi_trace_ng_masters as b', 'a.id_ng', '=', 'b.id')
                    ->where('a.line', 'DCAA03')
                    ->whereBetween('a.created_at', [$today . ' 14:00:00', $today . ' 22:00:00'])
                    ->groupBy('a.id_ng')
                    ->get();
                $lineName[0] = 'DCAA01';
                $lineName[1] = 'DCAA02';
                $lineName[2] = 'DCAA03';
                $totalPart[0] = DB::table('avi_trace_ngs')
                    ->where('line', 'DCAA01')
                    ->whereBetween('created_at', [$today . ' 14:00:00', $today . ' 22:00:00'])
                    ->count(DB::raw('DISTINCT code'));
                $totalPart[1] = DB::table('avi_trace_ngs')
                    ->where('line', 'DCAA02')
                    ->whereBetween('created_at', [$today . ' 14:00:00', $today . ' 22:00:00'])
                    ->count(DB::raw('DISTINCT code'));
                $totalPart[2] = DB::table('avi_trace_ngs')
                    ->where('line', 'DCAA03')
                    ->whereBetween('created_at', [$today . ' 14:00:00', $today . ' 22:00:00'])
                    ->count(DB::raw('DISTINCT code'));
            }
            if ($line == 'DCAA04' || $line == 'DCAA05') {
                $counter[0] =  DB::table('avi_trace_ngs as a')
                    ->select('b.name', DB::raw('count(a.id) as counter'))
                    ->join('avi_trace_ng_masters as b', 'a.id_ng', '=', 'b.id')
                    ->where('a.line', 'DCAA04')
                    ->whereBetween('a.created_at', [$today . ' 14:00:00', $today . ' 22:00:00'])
                    ->groupBy('a.id_ng')
                    ->get();
                $counter[1] =  DB::table('avi_trace_ngs as a')
                    ->select('b.name', DB::raw('count(a.id) as counter'))
                    ->join('avi_trace_ng_masters as b', 'a.id_ng', '=', 'b.id')
                    ->where('a.line', 'DCAA05')
                    ->whereBetween('a.created_at', [$today . ' 14:00:00', $today . ' 22:00:00'])
                    ->groupBy('a.id_ng')
                    ->get();
                $lineName[0] = 'DCAA04';
                $lineName[1] = 'DCAA05';
                $totalPart[0] = DB::table('avi_trace_ngs')
                    ->where('line', 'DCAA04')
                    ->whereBetween('created_at', [$today . ' 14:00:00', $today . ' 22:00:00'])
                    ->count(DB::raw('DISTINCT code'));
                $totalPart[1] = DB::table('avi_trace_ngs')
                    ->where('line', 'DCAA05')
                    ->whereBetween('created_at', [$today . ' 14:00:00', $today . ' 22:00:00'])
                    ->count(DB::raw('DISTINCT code'));
            }
            if ($line == 'DCAA06' || $line == 'DCAA07' || $line == 'DCAA08') {
                $counter[0] =  DB::table('avi_trace_ngs as a')
                    ->select('b.name', DB::raw('count(a.id) as counter'))
                    ->join('avi_trace_ng_masters as b', 'a.id_ng', '=', 'b.id')
                    ->where('a.line', 'DCAA06')
                    ->whereBetween('a.created_at', [$today . ' 14:00:00', $today . ' 22:00:00'])
                    ->groupBy('a.id_ng')
                    ->get();
                $counter[1] =  DB::table('avi_trace_ngs as a')
                    ->select('b.name', DB::raw('count(a.id) as counter'))
                    ->join('avi_trace_ng_masters as b', 'a.id_ng', '=', 'b.id')
                    ->where('a.line', 'DCAA07')
                    ->whereBetween('a.created_at', [$today . ' 14:00:00', $today . ' 22:00:00'])
                    ->groupBy('a.id_ng')
                    ->get();
                $counter[2] =  DB::table('avi_trace_ngs as a')
                    ->select('b.name', DB::raw('count(a.id) as counter'))
                    ->join('avi_trace_ng_masters as b', 'a.id_ng', '=', 'b.id')
                    ->where('a.line', 'DCAA08')
                    ->whereBetween('a.created_at', [$today . ' 14:00:00', $today . ' 22:00:00'])
                    ->groupBy('a.id_ng')
                    ->get();
                $lineName[0] = 'DCAA06';
                $lineName[1] = 'DCAA07';
                $lineName[2] = 'DCAA08';
                $totalPart[0] = DB::table('avi_trace_ngs')
                    ->where('line', 'DCAA06')
                    ->whereBetween('created_at', [$today . ' 14:00:00', $today . ' 22:00:00'])
                    ->count(DB::raw('DISTINCT code'));
                $totalPart[1] = DB::table('avi_trace_ngs')
                    ->where('line', 'DCAA07')
                    ->whereBetween('created_at', [$today . ' 14:00:00', $today . ' 22:00:00'])
                    ->count(DB::raw('DISTINCT code'));
                $totalPart[2] = DB::table('avi_trace_ngs')
                    ->where('line', 'DCAA08')
                    ->whereBetween('created_at', [$today . ' 14:00:00', $today . ' 22:00:00'])
                    ->count(DB::raw('DISTINCT code'));
            }
        } elseif (date('H:i') >= '22:00' && date('H:i') <= '23:59') {
            if ($line == 'DCAA01' || $line == 'DCAA02' || $line == 'DCAA03') {
                $counter[0] =  DB::table('avi_trace_ngs as a')
                    ->select('b.name', DB::raw('count(a.id) as counter'))
                    ->join('avi_trace_ng_masters as b', 'a.id_ng', '=', 'b.id')
                    ->where('a.line', 'DCAA01')
                    ->whereBetween('a.created_at', [$today . ' 22:00:00', $tomorrow . ' 05:59:00'])
                    ->groupBy('a.id_ng')
                    ->get();
                $counter[1] =  DB::table('avi_trace_ngs as a')
                    ->select('b.name', DB::raw('count(a.id) as counter'))
                    ->join('avi_trace_ng_masters as b', 'a.id_ng', '=', 'b.id')
                    ->where('a.line', 'DCAA02')
                    ->whereBetween('a.created_at', [$today . ' 22:00:00', $tomorrow . ' 05:59:00'])
                    ->groupBy('a.id_ng')
                    ->get();
                $counter[2] =  DB::table('avi_trace_ngs as a')
                    ->select('b.name', DB::raw('count(a.id) as counter'))
                    ->join('avi_trace_ng_masters as b', 'a.id_ng', '=', 'b.id')
                    ->where('a.line', 'DCAA03')
                    ->whereBetween('a.created_at', [$today . ' 22:00:00', $tomorrow . ' 05:59:00'])
                    ->groupBy('a.id_ng')
                    ->get();
                $lineName[0] = 'DCAA01';
                $lineName[1] = 'DCAA02';
                $lineName[2] = 'DCAA03';
                $totalPart[0] = DB::table('avi_trace_ngs')
                    ->where('line', 'DCAA01')
                    ->whereBetween('created_at', [$today . ' 22:00:00', $tomorrow . ' 05:59:00'])
                    ->count(DB::raw('DISTINCT code'));
                $totalPart[1] = DB::table('avi_trace_ngs')
                    ->where('line', 'DCAA02')
                    ->whereBetween('created_at', [$today . ' 22:00:00', $tomorrow . ' 05:59:00'])
                    ->count(DB::raw('DISTINCT code'));
                $totalPart[2] = DB::table('avi_trace_ngs')
                    ->where('line', 'DCAA03')
                    ->whereBetween('created_at', [$today . ' 22:00:00', $tomorrow . ' 05:59:00'])
                    ->count(DB::raw('DISTINCT code'));
            }
            if ($line == 'DCAA04' || $line == 'DCAA05') {
                $counter[0] =  DB::table('avi_trace_ngs as a')
                    ->select('b.name', DB::raw('count(a.id) as counter'))
                    ->join('avi_trace_ng_masters as b', 'a.id_ng', '=', 'b.id')
                    ->where('a.line', 'DCAA04')
                    ->whereBetween('a.created_at', [$today . ' 22:00:00', $tomorrow . ' 05:59:00'])
                    ->groupBy('a.id_ng')
                    ->get();
                $counter[1] =  DB::table('avi_trace_ngs as a')
                    ->select('b.name', DB::raw('count(a.id) as counter'))
                    ->join('avi_trace_ng_masters as b', 'a.id_ng', '=', 'b.id')
                    ->where('a.line', 'DCAA05')
                    ->whereBetween('a.created_at', [$today . ' 22:00:00', $tomorrow . ' 05:59:00'])
                    ->groupBy('a.id_ng')
                    ->get();
                $lineName[0] = 'DCAA04';
                $lineName[1] = 'DCAA05';
                $totalPart[0] = DB::table('avi_trace_ngs')
                    ->where('line', 'DCAA04')
                    ->whereBetween('created_at', [$today . ' 22:00:00', $tomorrow . ' 05:59:00'])
                    ->count(DB::raw('DISTINCT code'));
                $totalPart[1] = DB::table('avi_trace_ngs')
                    ->where('line', 'DCAA05')
                    ->whereBetween('created_at', [$today . ' 22:00:00', $tomorrow . ' 05:59:00'])
                    ->count(DB::raw('DISTINCT code'));
            }
            if ($line == 'DCAA06' || $line == 'DCAA07' || $line == 'DCAA08') {
                $counter[0] =  DB::table('avi_trace_ngs as a')
                    ->select('b.name', DB::raw('count(a.id) as counter'))
                    ->join('avi_trace_ng_masters as b', 'a.id_ng', '=', 'b.id')
                    ->where('a.line', 'DCAA06')
                    ->whereBetween('a.created_at', [$today . ' 22:00:00', $tomorrow . ' 05:59:00'])
                    ->groupBy('a.id_ng')
                    ->get();
                $counter[1] =  DB::table('avi_trace_ngs as a')
                    ->select('b.name', DB::raw('count(a.id) as counter'))
                    ->join('avi_trace_ng_masters as b', 'a.id_ng', '=', 'b.id')
                    ->where('a.line', 'DCAA07')
                    ->whereBetween('a.created_at', [$today . ' 22:00:00', $tomorrow . ' 05:59:00'])
                    ->groupBy('a.id_ng')
                    ->get();
                $counter[2] =  DB::table('avi_trace_ngs as a')
                    ->select('b.name', DB::raw('count(a.id) as counter'))
                    ->join('avi_trace_ng_masters as b', 'a.id_ng', '=', 'b.id')
                    ->where('a.line', 'DCAA08')
                    ->whereBetween('a.created_at', [$today . ' 22:00:00', $tomorrow . ' 05:59:00'])
                    ->groupBy('a.id_ng')
                    ->get();
                $lineName[0] = 'DCAA06';
                $lineName[1] = 'DCAA07';
                $lineName[2] = 'DCAA08';
                $totalPart[0] = DB::table('avi_trace_ngs')
                    ->where('line', 'DCAA06')
                    ->whereBetween('created_at', [$today . ' 22:00:00', $tomorrow . ' 05:59:00'])
                    ->count(DB::raw('DISTINCT code'));
                $totalPart[1] = DB::table('avi_trace_ngs')
                    ->where('line', 'DCAA07')
                    ->whereBetween('created_at', [$today . ' 22:00:00', $tomorrow . ' 05:59:00'])
                    ->count(DB::raw('DISTINCT code'));
                $totalPart[2] = DB::table('avi_trace_ngs')
                    ->where('line', 'DCAA08')
                    ->whereBetween('created_at', [$today . ' 22:00:00', $tomorrow . ' 05:59:00'])
                    ->count(DB::raw('DISTINCT code'));
            }
        } elseif (date('H:i') >= '00:00' && date('H:i') <= '05:59') {
            $today = date('Y-m-d', strtotime('-1 days'));
            $tomorrow = date('Y-m-d');
            if ($line == 'DCAA01' || $line == 'DCAA02' || $line == 'DCAA03') {
                $counter[0] =  DB::table('avi_trace_ngs as a')
                    ->select('b.name', DB::raw('count(a.id) as counter'))
                    ->join('avi_trace_ng_masters as b', 'a.id_ng', '=', 'b.id')
                    ->where('a.line', 'DCAA01')
                    ->whereBetween('a.created_at', [$yesterday . ' 22:00:00', $today . ' 05:59:00'])
                    ->groupBy('a.id_ng')
                    ->get();
                $counter[1] =  DB::table('avi_trace_ngs as a')
                    ->select('b.name', DB::raw('count(a.id) as counter'))
                    ->join('avi_trace_ng_masters as b', 'a.id_ng', '=', 'b.id')
                    ->where('a.line', 'DCAA02')
                    ->whereBetween('a.created_at', [$yesterday . ' 22:00:00', $today . ' 05:59:00'])
                    ->groupBy('a.id_ng')
                    ->get();
                $counter[2] =  DB::table('avi_trace_ngs as a')
                    ->select('b.name', DB::raw('count(a.id) as counter'))
                    ->join('avi_trace_ng_masters as b', 'a.id_ng', '=', 'b.id')
                    ->where('a.line', 'DCAA03')
                    ->whereBetween('a.created_at', [$yesterday . ' 22:00:00', $today . ' 05:59:00'])
                    ->groupBy('a.id_ng')
                    ->get();
                $lineName[0] = 'DCAA01';
                $lineName[1] = 'DCAA02';
                $lineName[2] = 'DCAA03';
                $totalPart[0] = DB::table('avi_trace_ngs')
                    ->where('line', 'DCAA01')
                    ->whereBetween('created_at', [$yesterday . ' 22:00:00', $today . ' 05:59:00'])
                    ->count(DB::raw('DISTINCT code'));
                $totalPart[1] = DB::table('avi_trace_ngs')
                    ->where('line', 'DCAA02')
                    ->whereBetween('created_at', [$yesterday . ' 22:00:00', $today . ' 05:59:00'])
                    ->count(DB::raw('DISTINCT code'));
                $totalPart[2] = DB::table('avi_trace_ngs')
                    ->where('line', 'DCAA03')
                    ->whereBetween('created_at', [$yesterday . ' 22:00:00', $today . ' 05:59:00'])
                    ->count(DB::raw('DISTINCT code'));
            }
            if ($line == 'DCAA04' || $line == 'DCAA05') {
                $counter[0] =  DB::table('avi_trace_ngs as a')
                    ->select('b.name', DB::raw('count(a.id) as counter'))
                    ->join('avi_trace_ng_masters as b', 'a.id_ng', '=', 'b.id')
                    ->where('a.line', 'DCAA04')
                    ->whereBetween('a.created_at', [$yesterday . ' 22:00:00', $today . ' 05:59:00'])
                    ->groupBy('a.id_ng')
                    ->get();
                $counter[1] =  DB::table('avi_trace_ngs as a')
                    ->select('b.name', DB::raw('count(a.id) as counter'))
                    ->join('avi_trace_ng_masters as b', 'a.id_ng', '=', 'b.id')
                    ->where('a.line', 'DCAA05')
                    ->whereBetween('a.created_at', [$yesterday . ' 22:00:00', $today . ' 05:59:00'])
                    ->groupBy('a.id_ng')
                    ->get();
                $lineName[0] = 'DCAA04';
                $lineName[1] = 'DCAA05';
                $totalPart[0] = DB::table('avi_trace_ngs')
                    ->where('line', 'DCAA04')
                    ->whereBetween('created_at', [$yesterday . ' 22:00:00', $today . ' 05:59:00'])
                    ->count(DB::raw('DISTINCT code'));
                $totalPart[1] = DB::table('avi_trace_ngs')
                    ->where('line', 'DCAA05')
                    ->whereBetween('created_at', [$yesterday . ' 22:00:00', $today . ' 05:59:00'])
                    ->count(DB::raw('DISTINCT code'));
            }
            if ($line == 'DCAA06' || $line == 'DCAA07' || $line == 'DCAA08') {
                $counter[0] =  DB::table('avi_trace_ngs as a')
                    ->select('b.name', DB::raw('count(a.id) as counter'))
                    ->join('avi_trace_ng_masters as b', 'a.id_ng', '=', 'b.id')
                    ->where('a.line', 'DCAA06')
                    ->whereBetween('a.created_at', [$yesterday . ' 22:00:00', $today . ' 05:59:00'])
                    ->groupBy('a.id_ng')
                    ->get();
                $counter[1] =  DB::table('avi_trace_ngs as a')
                    ->select('b.name', DB::raw('count(a.id) as counter'))
                    ->join('avi_trace_ng_masters as b', 'a.id_ng', '=', 'b.id')
                    ->where('a.line', 'DCAA07')
                    ->whereBetween('a.created_at', [$yesterday . ' 22:00:00', $today . ' 05:59:00'])
                    ->groupBy('a.id_ng')
                    ->get();
                $counter[2] =  DB::table('avi_trace_ngs as a')
                    ->select('b.name', DB::raw('count(a.id) as counter'))
                    ->join('avi_trace_ng_masters as b', 'a.id_ng', '=', 'b.id')
                    ->where('a.line', 'DCAA08')
                    ->whereBetween('a.created_at', [$yesterday . ' 22:00:00', $today . ' 05:59:00'])
                    ->groupBy('a.id_ng')
                    ->get();
                $lineName[0] = 'DCAA06';
                $lineName[1] = 'DCAA07';
                $lineName[2] = 'DCAA08';
                $totalPart[0] = DB::table('avi_trace_ngs')
                    ->where('line', 'DCAA06')
                    ->whereBetween('created_at', [$yesterday . ' 22:00:00', $today . ' 05:59:00'])
                    ->count(DB::raw('DISTINCT code'));
                $totalPart[1] = DB::table('avi_trace_ngs')
                    ->where('line', 'DCAA07')
                    ->whereBetween('created_at', [$yesterday . ' 22:00:00', $today . ' 05:59:00'])
                    ->count(DB::raw('DISTINCT code'));
                $totalPart[2] = DB::table('avi_trace_ngs')
                    ->where('line', 'DCAA08')
                    ->whereBetween('created_at', [$yesterday . ' 22:00:00', $today . ' 05:59:00'])
                    ->count(DB::raw('DISTINCT code'));
            }
        }

        return [
            'data' => $counter,
            'lineName' => $lineName,
            'totalPart' => $totalPart
        ];
    }

    public function getAjaxcastingng($number, $date, $line)
    {
        try {
            \DB::beginTransaction();
            $user = Auth::user();
            $npk  = $user->npk;
            $temp               = new avi_trace_ng_casting_temp;
            $temp->code         = $number;
            $temp->npk          = $npk;
            $temp->line         = $line;
            $temp->date         = $date;
            $temp->save();

            \DB::commit();
            $arrJSON = array(
                "code"      => $number,
            );
            return $arrJSON;
        } catch (\Exception $e) {

            DB::rollBack();
            return array("code" => "", "error" => $e->getMessage());
        }
    }
    public function getDatacastingng()
    {
        $npk        =   Auth::user()->npk;
        // $data       =   avi_trace_ng_casting_temp::select('id','code','npk','date')
        //                 ->where('npk', $npk)->get();
        $data = avi_trace_ng_casting_temp::all();
        return Datatables::of($data)
            ->make();
    }
    public function getAjaxcastingtable()
    {
        $create = new avi_trace_casting();
        $create->code = 'No Data';
        $create->npk = 'No Data';
        $create->date = 'No Data';
        $arrayku = array($create);
        return Datatables::of($arrayku)
            ->addColumn('product', function ($create) {
                return 'No Data';
            })
            ->addColumn('model', function ($create) {

                return 'No Data';
            })
            ->addIndexColumn()
            ->make(true);
    }
    public function getAjaxcastingupdate()
    {
        $user                       = Auth::user();
        $create = avi_trace_casting::select('code', 'npk', 'date')
            ->where('npk', $user->npk)
            ->where('date', date('Y-m-d'))
            ->orderBy('id', 'DESC')
            ->take(5);
        return Datatables::of($create)
            ->addColumn('product', function ($create) {

                $codes  = $create->code;
                $code   = substr($create->code, 0, 2);
                $models = avi_trace_program_number::select('product')->where('code', $code)->first();
                return $models ? $models->product : '--No Product--';
            })
            ->addColumn('model', function ($create) {

                $codes  = $create->code;
                $code   = substr($create->code, 0, 2);
                $models = avi_trace_program_number::select('back_number')->where('code', $code)->first();
                return $models ? $models->back_number : '--No Back Number--';
            })
            ->addIndexColumn()
            ->make(true);
    }

    // MODUL CASTING DOWA
    //=======================================================================================================================================================
    public function scanCastingDowa()
    {
        return view('tracebility/casting/scan-dowa');
    }

    public function checkCodeCastingDowa(Request $request)
    {
        $codes = $request->all();
        $type = $codes['type'];
        $code = $codes['code'];
        if ($type == 'kbnint') {
            $codesubstr = substr($code, 123, 4);
            $data = avi_dowa_process::select('kbn_int_casting', 'kbn_supply')->where('kbn_int_casting', $codesubstr)->first();
            if ($data == null) {
                return array(
                    "type" => $type,
                    "code" => $code,
                    "codesubstr" => $codesubstr
                );
            } else if ($data->kbn_int_casting != null && $data->kbn_supply != null) {
                return array(
                    "type" => $type,
                    "code" => $code,
                    "codesubstr" => $codesubstr
                );
            } else if ($data->kbn_int_casting != null && $data->kbn_supply == null) {
                return array(
                    "type" => $type,
                    "code" => "false",
                    "codesubstr" => $codesubstr
                );
            }
        } elseif ($type == 'code') {
            $substr                     = substr($code, 0, 2);
            $product                    = avi_trace_program_number::where('code', $substr)->first();
            if (is_null($product)) {
                return array(
                    "type" => $type,
                    "code" => "unregistered",
                    "codesubstr" => $code
                );
            }
            $dataDowa = avi_dowa_process::select('code')->where('code', $code)->first();
            $dataCasting = avi_trace_casting::select('code')->where('code', $code)->first();
            if ($dataDowa || $dataCasting) {
                return array(
                    "type" => $type,
                    "code" => "false",
                    "codesubstr" => $code
                );
            } else {
                return array(
                    "type" => $type,
                    "code" => $code,
                    "codesubstr" => $code
                );
            }
        } else {
            return "salah";
        }
    }

    public function inputCodeCastingDowa(Request $request)
    {
        $user = Auth::user()->npk;
        $code = $request->all();
        $partcodes = $code['code'];
        $line = $code['line'];
        $kbn_int = $code['kbn_int'];

        $data = avi_dowa_process::select('kbn_int_casting', 'kbn_supply')->where('kbn_int_casting', $kbn_int)->where('kbn_supply', null)->first();
        // if ($data->kbn_int_casting != null && $data->kbn_supply == null) {
        //     return array(
        //         "status" => "exist"
        //     );
        // }
        if (is_null($data)) {
            foreach ($partcodes as $key => $value) {
                $dataCasting = array(
                    'code' => $value,
                    'npk' => $user,
                    'line' => $line,
                    'status' => "1",
                    'date' => date('Y-m-d')
                );
                $dataCastingDowa = array(
                    'code' => $value,
                    'kbn_int_casting' => $kbn_int
                );
                $key = 'casting_dowa' . $line;
                if (Cache::has($key)) {
                    $cache = Cache::get($key);
                    if (!isset($cache[date('Y-m-d')])) {
                        $cache = [];
                        $cache = [
                            date('Y-m-d') => [
                                'counter' => 1
                            ]
                        ];
                    } else {
                        $cache[date('Y-m-d')]['counter'] += 1;
                    }
                } else {
                    $cache = [
                        date('Y-m-d') => [
                            'counter' => 1
                        ]
                    ];
                }

                Cache::forever($key, $cache);
                try {
                    DB::beginTransaction();
                    $casting = avi_trace_casting::create($dataCasting);
                    $dowaProcess = avi_dowa_process::create($dataCastingDowa);

                    // hit api rts
                    $area = substr($line, 0, 2);
                    $partCode = substr(array_first($partcodes), 0, 2);
                    $backNum = avi_trace_program_number::select('back_number')->where('code',  $partCode)->first();
                    $qty = 3;

                    // create new instance
                    //$client = new Client([
                    //'verify' => false, // Temporarily disabling SSL verification
                    //]);
                    // $response = $client->get('http://rts/api/stock-control/'. $area .'/'. $backNum);
                    //foreach ($partcodes as $key => $value){
                    //$response = $client->get(env('API_RTS') .'/'. $area .'/'. $backNum->back_number .'/1/'. $value);
                    // }

                    // foreach ($partcodes as $key => $value){
                    $ch = curl_init(env('API_RTS') . '/' . $area . '/' . $backNum->back_number . '/1/' . $value);

                    // Mengabaikan verifikasi SSL
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    // }

                    // Eksekusi permintaan
                    $response = curl_exec($ch);

                    DB::commit();
                } catch (\Throwable $th) {
                    DB::rollBack();
                    return [
                        "status" => "error",
                        "messege" => "Data Not Saved, Please Rescan Part & Kanban"
                    ];
                }
            };
            return [
                "status" => "success",
                "counter"   => $cache[date('Y-m-d')]['counter']
            ];
        } else {
            return array(
                "status" => "exist"
            );
        }
    }

    //MODUL DELIVERY D98
    //==================================================================================================================================================
    public function scanDeliveryD98()
    {
        return view('tracebility/delivery/scan-d98');
    }

    // update by fabian 01272023 || part d98e (delivery)
    public function checkCodeDeliveryD98(Request $request)
    {
        try {
            $kbn_int = $request->kbnint;

            if ($kbn_int) {
                $arr = preg_split('/ +/', $kbn_int);
                // new kanban
                if ($arr[8] == '0') {
                    $seri_length = strlen($arr[10]);
                    $part_number = $arr[4];
                    $seri = substr($arr[10], $seri_length - 4);
                    $back_number = $arr[9];
                }
                // old kanban
                elseif ($arr[7] == '0') {
                    $seri_length = strlen($arr[9]);
                    $part_number = $arr[4];
                    $seri = substr($arr[9], $seri_length - 4);
                    $back_number = $arr[8];
                }
            }

            // cek master back number
            $cek_master = avi_trace_kanban_master::select('id')
                ->where('back_nmr', $back_number)
                ->first();

            // Cek apakah ada part pada kanban
            $cek_kanban = avi_trace_kanban::select('code_part')
                ->where('no_seri', $seri)
                ->where('master_id', $cek_master->id)->first();

            if ($cek_kanban == null) {
                return array(
                    "code" => 'notRegistered',
                    "codesubstr" => $kbn_int
                );
            }

            if ($cek_kanban->code_part == null) {
                return array(
                    "code" => 'false',
                    "codesubstr" => $kbn_int
                );
            }
            return array(
                "code" => $kbn_int,
                "seri" => $seri,
                "backnum" => $back_number,
                "partnum" => $part_number
            );
        } catch (\Throwable $th) {
            //throw $th;
            return array(
                "code" => "error",
                "codesubstr" => $th->getMessage()
            );
        }
    }

    //MODUL DELIVERY DOWA
    //==================================================================================================================================================
    public function scanDeliveryDowa()
    {
        return view('tracebility/delivery/scan-dowa');
    }

    public function checkCodeDeliveryDowa(Request $request)
    {
        try {
            $code = $request->all();
            $kbn_int = $code['kbnint'];
            $data = avi_dowa_process::select('id')
                ->where('kbn_int_casting', $kbn_int)
                ->where('kbn_supply', NULL)
                ->first();

            if ($data != null) {
                return array(
                    "code" => $kbn_int,
                    "codesubstr" => $kbn_int
                );
            }
            return array(
                "code" => "false",
                "codesubstr" => $kbn_int
            );
        } catch (\Throwable $th) {
            //throw $th;
            return array(
                "code" => "error",
                "codesubstr" => $th->getMessage()
            );
        }
    }

    // update by fabian 01272023 || part d98e (delivery)
    public function inputCodeDeliveryD98(Request $request)
    {
        try {
            // kanban internal
            $back_number = $request->kbn_int;
            $seri = $request->seri;
            $customer   = $request->customer;
            $cycle = $request->cycle;

            // kanban customer
            $kbn_cust = $request->kbn_cust;
            $arr_cust = explode('-', $kbn_cust);
            $seri_cust = $arr_cust[7];

            $user = Auth::user()->npk;
            $deliveryAt = date('Y-m-d H:i:s');

            // cek master back number
            $cek_master = avi_trace_kanban_master::select('id')
                ->where('back_nmr', $back_number)
                ->first();

            // get part 
            $part = avi_trace_kanban::select('id', 'code_part', 'code_part_2')
                ->where('no_seri', $seri)
                ->where('master_id', $cek_master->id)
                ->first();

            $data = [
                [
                    'code' => $part->code_part,
                    'npk' => $user,
                    'date' => $deliveryAt,
                    'cycle' => $cycle,
                    'customer' => $customer,
                    'status' => 1,
                    'created_at' => $deliveryAt,
                ],
                [
                    'code' => $part->code_part_2,
                    'npk' => $user,
                    'date' => $deliveryAt,
                    'cycle' => $cycle,
                    'customer' => $customer,
                    'status' => 1,
                    'created_at' => $deliveryAt,
                ],
            ];

            // check if the part code exist in avi trace delivery
            $part_delivery = avi_trace_delivery::whereIn('code', [$part->code_part, $part->code_part_2])->first();

            if ($part_delivery != null) {
                return [
                    "status" => "partExist"
                ];
            }

            // insert 
            DB::table('avi_trace_delivery')->insert($data);

            // reset kanban
            $part->update(['code_part' => null, 'code_part_2' => null]);

            return [
                "status" => "success"
            ];
        } catch (\Throwable $e) {
            return [
                "status" => "error",
                "messege" => $e->getMessage()
            ];
        }
    }

    public function inputCodeDeliveryDowa(Request $request)
    {
        try {
            $user = Auth::user()->npk;
            $kbn_int = $request->kbn_int;
            $kbn_sup = $request->kbn_sup;
            $deliveryAt = date('Y-m-d H:i:s');
            $partcodes = avi_dowa_process::select('code', 'kbn_int_casting')
                ->where('kbn_int_casting', $kbn_int)
                ->where('kbn_supply', NULL)
                ->limit(3);

            $dataSends = $partcodes->get();

            $partcodes->update([
                'kbn_supply' => $kbn_sup,
                'scan_delivery_dowa_at' => $deliveryAt,
                'npk_delivery_dowa' => $user
            ]);

            $sendJson = [];
            foreach ($dataSends as $value) {
                $sendJson[] = [
                    'code' => $value->code,
                    'delivery_aiia_at' => $deliveryAt,
                    'kanban' => $kbn_sup
                ];
            };

            // hit API rts
            $area = 'PULL';

            // Make sure $backNum is defined before this foreach if it's used here
            $ch = curl_init(env('API_RTS') . '/PULL/DI02/3/');

            // Mengabaikan verifikasi SSL
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

            // Eksekusi permintaan
            $response = curl_exec($ch);

            //SendDataDowa::dispatch($sendJson, Cache::get('dowa_token'));

            return [
                "status" => "success"
            ];
        } catch (\Throwable $e) {
            return [
                "status" => "error",
                "messege" => $e->getMessage()
            ];
        }
    }
    // MODUL DELIVERY
    //=======================================================================================================================================================

    public function scandelivery()
    {
        return view('tracebility/delivery/scan');
    }

    public function getAjaxdelivery($number, $wimcycle, $customer)
    {
        try {
            $user                       = Auth::user();
            if (strlen($number) > 25) {
                if (!$codes = avi_dowa_process::where('kbn_fg', substr($number, 123, 4))->where('is_delivered', NULL)->first()) {
                    return [
                        "code" => "not found"
                    ];
                }
                $codes = avi_dowa_process::where('kbn_fg', substr($number, 123, 4))->where('is_delivered', NULL)->get();

                foreach ($codes as $code) {

                    if ($code->code != null) {
                        DB::beginTransaction();
                        $scan                       = new avi_trace_delivery;
                        $scan->code                 = $code->code;
                        $scan->cycle                = $wimcycle;
                        $scan->customer             = $customer;
                        $scan->npk                  = $user->npk;
                        $scan->date                 = date('Y-m-d');
                        $scan->status               = 1;
                        $scan->save();

                        DB::table('avi_dowa_process')->where('code', $code->code)->update(['is_delivered' => '1']);

                        DB::commit();
                    } else {
                        return [
                            "code" => "not found"
                        ];
                    }
                }
                $counter = avi_trace_delivery::where('date', date('Y-m-d'))
                    ->where('cycle', $wimcycle)
                    ->count();
                $arrJSON = array(
                    "code"      => $number,
                    "counter"   => $counter
                );
                return $arrJSON;
            }
            $cek    = avi_trace_delivery::where('code', $number)->first();
            if (is_null($cek)) {

                DB::beginTransaction();
                $scan                       = new avi_trace_delivery;
                $scan->code                 = $number;
                $scan->cycle                = $wimcycle;
                $scan->customer             = $customer;
                $scan->npk                  = $user->npk;
                $scan->date                 = date('Y-m-d');
                $scan->status               = 1;
                $scan->save();
                DB::commit();
                $counter = avi_trace_delivery::where('date', date('Y-m-d'))
                    ->where('cycle', $wimcycle)
                    ->count();
                $arrJSON = array(
                    "code"      => $number,
                    "counter"   => $counter
                );
                return $arrJSON;
            } else {
                // return response()->json($part);      // dev-1.0, Ferry, Commented ganti yg lebih bersih
                return array("code" => "");
            }
        } catch (\Exception $e) {

            DB::rollBack();
            return array("code" => "", "error" => $e->getMessage());
        }
    }

    public function getAjaxdeliveryApi($seri, $back_number, $wimcycle, $customer, $npk)
    {
        $qty = 0;
        try {
            $cekMaster = avi_trace_kanban_master::select('id', 'back_nmr')->where('back_nmr', $back_number)->first();
            $cek    = avi_trace_kanban::where('no_seri', $seri)->where('master_id', $cekMaster->id)->first();

            if ($back_number == 'AI25' || $back_number == 'BI21' || $back_number == 'BI22') {
                $scan                       = new avi_trace_delivery;
                $scan->code                 = '' . date('Y-m-d H:i:s') . '-' . $seri;
                $scan->cycle                = $wimcycle;
                $scan->customer             = $customer;
                $scan->npk                  = $npk;
                $scan->seri                 = $seri;
                $scan->date                 = date('Y-m-d');
                $scan->status               = 1;
                $scan->save();

                $arrJSON = array(
                    "code"      => $seri
                );

                return $arrJSON;
            }

            if ($cek->code_part) {
                DB::beginTransaction();
                $scan                       = new avi_trace_delivery;
                $scan->code                 = $cek->code_part;
                $scan->cycle                = $wimcycle;
                $scan->customer             = $customer;
                $scan->npk                  = $npk;
                $scan->seri                 = $seri;
                $scan->date                 = date('Y-m-d');
                $scan->status               = 1;
                $scan->save();
                $qty++;
                if ($cek->code_part_2) {
                    $scan2                       = new avi_trace_delivery;
                    $scan2->code                 = $cek->code_part_2;
                    $scan2->cycle                = $wimcycle;
                    $scan2->customer             = $customer;
                    $scan2->npk                  = $npk;
                    $scan2->seri                 = $seri;
                    $scan2->date                 = date('Y-m-d');
                    $scan2->status               = 1;
                    $scan2->save();
                    $qty++;
                }

                $code = substr($cek->code_part, 0, 2);

                $cek->code_part = null;
                $cek->code_part_2 = null;
                $cek->save();
                $backNum = avi_trace_program_number::select('back_number')->where('code',  $code)->first();

                // hit api rts
                $area = 'PULL';
                $ch = curl_init(env('API_RTS') . '/' . $area . '/' . $backNum->back_number . '/' . $qty . '/');

                // Mengabaikan verifikasi SSL
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

                // Eksekusi permintaan
                $response = curl_exec($ch);

                // Close the cURL session
                curl_close($ch);

                DB::commit();

                $arrJSON = array(
                    "code"      => $seri
                );

                return $arrJSON;
            } else {
                $today = Carbon::now();
                $subminutes = Carbon::now()->subMinutes(20);
                if ($cek->updated_at <= $today && $cek->updated_at >= $subminutes) {
                    $arrJSON = array(
                        "code"      => $seri
                    );

                    return $arrJSON;
                } else {
                    return array("code" => "0", "seri" => $seri);
                }
            }
        } catch (\Exception $e) {

            DB::rollBack();
            return array("code" => "error", "error" => $e->getMessage());
        }
    }

    public function getAjaxcycle($code)
    {
        // dev-1.0.0, Handika, 20180724, cycle

        $code = avi_trace_cycle::where('code', $code)->first();

        return array("cycle" => $code->name);
    }


    // MODUL NG DELIVERY

    public function scandeliveryng()
    {
        return view('tracebility/delivery/ng');
    }

    public function getAjaxdeliveryng($number)
    {
        try {

            $cek    = avi_trace_delivery::where('code', $number)->first();

            if ($cek) {

                DB::beginTransaction();
                $user                       = Auth::user();
                $scan                       = avi_trace_delivery::where('code', $number)->first();
                $scan->date_ng              = date('Y-m-d');
                $scan->status               = 0;
                $scan->npk_ng               = $user->npk;
                $scan->save();
                DB::commit();

                // dev-1.0.0, Handika, 20180724, counter
                $counter = avi_trace_delivery::where('date_ng', date('Y-m-d'))
                    ->where('npk_ng', $user->npk)
                    ->count();

                $arrJSON = array(
                    "code"      => $number,
                    "counter"    => $counter,
                );

                return $arrJSON;
            } else {
                // return response()->json($part);      // dev-1.0, Ferry, Commented ganti yg lebih bersih
                return array("code" => "");
            }
        } catch (\Exception $e) {

            DB::rollBack();
            return array("code" => "", "error" => $e->getMessage());
        }
    }
    public function getAjaxdeliveryngtable()
    {
        $create = new avi_trace_delivery();
        $create->code = 'No Data';
        $create->npk_ng = 'No Data';
        $create->date_ng = 'No Data';
        $arrayku = array($create);
        return Datatables::of($arrayku)
            ->addIndexColumn()
            ->make(true);
    }
    public function getAjaxdeliveryngupdate()
    {
        $user                       = Auth::user();
        $create = avi_trace_delivery::select('code', 'npk_ng', 'date_ng')
            ->where('npk_ng', $user->npk)
            ->where('date_ng', date('Y-m-d'))
            ->get();
        return Datatables::of($create)
            ->addIndexColumn()
            ->make(true);
    }


    // MODULE MACHINING
    //=======================================================================================================================================================

    public function scanmachining()
    {
        return view('tracebility/machining/scan');
    }

    public function machiningfg()
    {
        return view('tracebility/machining/fg');
    }

    public function machiningfgtmmin()
    {
        return view('tracebility/machining/fg-tmmin');
    }

    public function checkmachiningfg($line)
    {
        $cek = avi_trace_printer::where('line', $line)->first();
        if ($cek) {
            return [
                'line' => $line
            ];
        } else {
            return [
                'line' => null
            ];
        }
    }
    public function cekCodePart(Request $request)
    {

        $inputs = $request->all();
        $cpart = $inputs['code'];

        $cek = avi_trace_machining::where('code', $cpart)->first();

        if ($cek) {
            return ["code" => ""];
        } else {

            return array(
                "code" => $cpart,
            );
        }
    }


    public function getAjaxmachiningfg(Request $request)
    {

        $input = $request->all();
        $user = Auth::user()->npk;
        $kbn_int = $input['kbn_int'];
        $line = isset($input['line']) ? $input['line'] : '';
        $strainer = isset($input['strainer']) ? $input['strainer'] : '';
        $number = isset($input['code']) ? $input['code'] : '';
        $cekPart = avi_trace_machining::where('code', $number)->first();
        $numcek = substr($number, 0, 2);
        if ($cekPart) {

            return ["code" => ""];
        }


        if ($kbn_int) {

            if (strlen($kbn_int) == 37) {
                $lenght = strlen($kbn_int);
                $seri = substr($kbn_int, -4);
                $back_number = substr($kbn_int, 24, 4);

                $cekMaster = avi_trace_kanban_master::select('id', 'back_nmr')->where('back_nmr', $back_number)->first();
                $pro = avi_trace_program_number::select('back_number')->where('rfid_tmmin',  $cekMaster->back_nmr)->first();
                $cekMaster->back_nmr = $pro->back_number;
                $cekProgNums = avi_trace_program_number::select('back_number')->where('code',  $numcek)->get();
            } else {

                $arr = preg_split('/ +/', $kbn_int);

                if ($arr[8] == '0') {

                    $lenght = strlen($arr[10]);
                    $seri = substr($arr[10], $lenght - 4);
                    $back_number = $arr[9];
                } elseif ($arr[9] == '0') {

                    $lenght = strlen($arr[11]);
                    $seri = substr($arr[11], $lenght - 4);
                    $back_number = $arr[10];
                } else {

                    $lenght = strlen($arr[9]);
                    $seri = substr($arr[9], $lenght - 4);
                    $back_number = $arr[8];
                }

                $cekMaster = avi_trace_kanban_master::select('id', 'back_nmr')->where('back_nmr', $back_number)->first();

                $cekProgNums = avi_trace_program_number::select('back_number')->where('code',  $numcek)->get();
            }
            $isReturn = 0;

            foreach ($cekProgNums as $cekProgNum) {
                if ($cekMaster->back_nmr == $cekProgNum->back_number) {
                    $isReturn = 1;
                }
            }

            if ($isReturn == 0) {
                return ["code" => "notmatch"];
            }
            $cek = avi_trace_kanban::select('code_part')->where('no_seri', $seri)->where('master_id', $cekMaster->id)->first();
            if ($cek == null) {
                return ["code" => "notregistered"];
            }

            if ($cek->code_part == null) {

                $key = 'machining_' . $line;
                if (Cache::has($key)) {
                    $cache = Cache::get($key);
                    if (!isset($cache[date('Y-m-d')])) {
                        $cache = [];
                        $cache = [
                            date('Y-m-d') => [
                                'counter' => 1
                            ]
                        ];
                    } else {
                        $cache[date('Y-m-d')]['counter'] += 1;
                    }
                } else {
                    $cache = [
                        date('Y-m-d') => [
                            'counter' => 1
                        ]
                    ];
                }

                Cache::forever($key, $cache);
                try {
                    DB::beginTransaction();
                    $update = avi_trace_kanban::where('no_seri', $seri)->where('master_id', $cekMaster->id)->update(['code_part' => $number]);
                    $machining = avi_trace_machining::create([
                        'date' => date('Y-m-d'),
                        'line' => $line,
                        'npk' => $user,
                        'status' => "1",
                        'strainer_id' => $strainer,
                        'code' => $number,
                    ]);

                    // hit api rts
                    $area = substr($line, 0, 2);
                    $backNum = avi_trace_program_number::select('back_number')->where('code',  $numcek)->first();
                    $qty = 1;

                    $ch = curl_init(env('API_RTS') . '/' . $area . '/' . $backNum->back_number . '/' . $qty . '/' . $number . '/');

                    // Mengabaikan verifikasi SSL
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

                    // Eksekusi permintaan
                    $response = curl_exec($ch);

                    DB::commit();
                } catch (\Throwable $th) {
                    DB::rollBack();
                    return [
                        "status" => "error",
                        "messege" => "Data Not Saved, Please Rescan Part & Kanban"
                    ];
                }

                return [

                    "counter"   => $cache[date('Y-m-d')]['counter'],
                    "code" => $number,
                    "kbn_int" => $seri,
                ];
            } else {
                return ["code" => "Kanbannotreset"];
            }
        } else {
            return ["code" => "notregistered"];
        }
    }

    public function machiningng()
    {
        $code = 0;
        $ngName = avi_trace_ng_master::select('name', 'id')->where('category', 'ma')->get();
        // dd($ngName);
        return view('tracebility/machining/ng', compact('ngName'));
    }

    public function machiningng2($code)
    {
        $ngName = avi_trace_ng_master::select('name', 'id')->get();
        return view('tracebility/machining/ng', compact('ngName'));
    }

    /**
     * Fungsi get data part
     *
     */
    public function getPartMachiningNg($part)
    {

        $aviNg = avi_trace_ng::with('ngdetail')->where('code', $part)->get();
        if ($aviNg) {
            return $aviNg;
        }
        return $part;
    }

    /**
     * Fungsi input data part
     *
     */
    public function inputPartMachiningNg($part, $ng, $line)
    {

        $user = Auth::user();
        $cekNg = avi_trace_ng_master::where('id', $ng)->first();
        if (!$cekNg) {
            return [
                "status" => "error",
                "messege" => "DATA ID NG TIDAK DITEMUKAN"
            ];
        }

        // DO: cek di avi kanban dan reset kanban
        $aviMachining = avi_trace_kanban::where('code_part', $part)->orWhere('code_part_2', $part)->first();
        if ($aviMachining) {

            $deletePartSatu = avi_trace_machining::where('code', $aviMachining->code_part)->first();
            if ($deletePartSatu) {
                $deletePartSatu->delete();
            }

            $deletePartDua = avi_trace_machining::where('code', $aviMachining->code_part_2)->first();
            if ($deletePartDua) {
                $deletePartDua->delete();
            }

            $aviMachining->code_part = NULL;
            $aviMachining->code_part_2 = NULL;
            $aviMachining->save();
        }

        $partNg = avi_trace_ng::where('code', $part)->where('id_ng', $ng)->first();
        if ($partNg) {
            $partNg->delete();
            $type = 'delete';
        } else {
            $inputNg = avi_trace_ng::create([
                'code' => $part,
                'date' => date('Y-m-d'),
                'id_ng' => $ng,
                'line' => $line,
                'pic' => $user->npk
            ]);
            $type = 'input';
        }
        $aviNg = avi_trace_ng::with('ngdetail')->where('code', $part)->get();
        return [
            "type" => $type,
            "data" => $aviNg
        ];
    }


    public function machiningfgngAjax(Request $request)
    {
        $user = Auth::user();
        $npk = $user->npk;
        $kanban = $request->scan;

        if ($request->ispart == 0) {
            $arr = preg_split('/ +/', $kanban);

            if ($arr[8] == '0') {

                $lenght = strlen($arr[10]);
                $seri = substr($arr[10], $lenght - 4);
                $back = $arr[9];
            } elseif ($arr[9] == '0') {

                $lenght = strlen($arr[11]);
                $seri = substr($arr[11], $lenght - 4);
                $back = $arr[10];
            } else {

                $lenght = strlen($arr[9]);
                $seri = substr($arr[9], $lenght - 4);
                $back = $arr[8];
            }
            try {
                $cekMaster = avi_trace_kanban_master::select('id')->where('back_nmr', $back)->first();
                $cek    = avi_trace_kanban::where('no_seri', $seri)->where('master_id', $cekMaster->id)->whereNotNull('code_part')->first();
                if ($cek) {
                    DB::beginTransaction();

                    $machining = avi_trace_machining::where('code', $cek->code_part)->first();
                    $machining->status = 0;
                    $machining->save();
                    if ($cek->code_part_2) {
                        $machining2 = avi_trace_machining::where('code', $cek->code_part)->first();
                        $machining2->status = 0;
                        $machining2->save();
                    }

                    $cek->code_part = null;
                    $cek->code_part_2 = null;
                    $cek->save();

                    DB::commit();

                    return [
                        "error" => false,
                        "messege" => "Kanban " . $seri . " berhasil dinyatakan NG!"
                    ];
                } else {
                    return [
                        "error" => true,
                        "messege" => "kanban " . $seri . " Kosong!"
                    ];
                }
            } catch (\Exception $e) {

                DB::rollBack();
                return [
                    "error" => true,
                    "messege" => $e->getMessage()
                ];
            }
        } else {
            $machining3 = avi_trace_machining::where('code', $kanban)->first();
            if ($machining3) {
                $machining3->status = 0;
                $machining3->save();

                return [
                    "error" => false,
                    "messege" => "Part " . $kanban . " berhasil dinyatakan NG!"
                ];
            } else {
                return [
                    "error" => true,
                    "messege" => "part " . $kanban . " tidak ditemukan!"
                ];
            }
        }
    }

    public function getAjaxmachiningng()
    {
        $user                       = Auth::user();
        $create = avi_trace_machining::select('code', 'npk', 'date')
            ->where('npk', $user->npk)
            ->where('date', date('Y-m-d'))
            ->where('status', 0)
            ->orderBy('id', 'DESC')
            ->take(5);
        return Datatables::of($create)
            ->addColumn('product', function ($create) {

                $codes  = $create->code;
                $code   = substr($create->code, 0, 2);
                $models = avi_trace_program_number::select('product')->where('code', $code)->first();
                return $models ? $models->product : '--No Product--';
            })
            ->addColumn('model', function ($create) {

                $codes  = $create->code;
                $code   = substr($create->code, 0, 2);
                $models = avi_trace_program_number::select('back_number')->where('code', $code)->first();
                return $models ? $models->back_number : '--No Back Number--';
            })
            ->addIndexColumn()
            ->make(true);
    }



    public function getAjaxmachining($number, $line, $strainer)
    {
        try {
            $a = substr($number, 0, 2);
            $model_strainer = 1;
            if ($a != "14") {
                $strainer = 0;
                $model_strainer = 0;
            }

            $cek    = avi_trace_machining::where('code', $number)->first();
            if (is_null($cek)) {
                DB::beginTransaction();
                $user                       = Auth::user();
                $scan                       = new avi_trace_machining;
                $scan->code                 = $number;
                $scan->date                 = date('Y-m-d');
                $scan->line                 = $line;
                $scan->strainer_id          = $strainer;
                $scan->status               = 1;
                $scan->npk                  = $user->npk;

                $a                          = substr($number, 0, 2);
                $product                    = avi_trace_program_number::where('code', $a)->first();
                if (is_null($product)) {
                    return "Model Not Found";
                }

                $scan->save();

                // hit api rts
                $area = substr($line, 0, 2);

                // get back number
                $fgPart = avi_trace_program_number::select('back_number')->where('code', $a)->first();
                $backNum = $fgPart->back_number;
                $qty = 1;

                $ch = curl_init(env('API_RTS') . '/' . $area . '/' . $backNum . '/' . $qty . '/' . $number . '/');

                // Mengabaikan verifikasi SSL
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

                // Eksekusi permintaan
                $response = curl_exec($ch);

                $key = 'machining_' . $user->npk;
                if (Cache::has($key)) {
                    $cache = Cache::get($key);

                    if (!isset($cache[date('Y-m-d')])) {
                        $cache = [];
                        $cache = [
                            date('Y-m-d') => [
                                'counter' => 1,
                                'items' => [
                                    $number
                                ]
                            ]
                        ];
                    } else {
                        $cache[date('Y-m-d')]['counter'] += 1;
                        if (count($cache[date('Y-m-d')]['items']) >= 10) {
                            unset($cache[date('Y-m-d')]['items'][0]);
                        }
                        $cache[date('Y-m-d')]['items'][] = $number;
                        $cache[date('Y-m-d')]['items'] = array_values($cache[date('Y-m-d')]['items']);
                    }
                } else {
                    $cache = [
                        date('Y-m-d') => [
                            'counter' => 1,
                            'items' => [
                                $number
                            ]
                        ]
                    ];
                }

                Cache::forever($key, $cache);

                $arrJSON = array(
                    "code"      => $number,
                    "counter"   => $cache[date('Y-m-d')]['counter'],
                    "model_strainer" => $model_strainer
                );

                $a                          = substr($number, 0, 2);
                $product                    = avi_trace_program_number::select('*')->where('code', $a)->first();
                // $printer                    = avi_trace_printer::where('line', $line)->first();

                // // dev-1.1.0, Ali, Handle untuk data yang tidak di print di line yg sedang jalan
                // if ($printer) {
                //     $printer->part_code         = $number;
                //     $printer->part_number       = $product ? $product->part_number : "No Data";
                //     $printer->back_number       = $product ? $product->back_number : "No Data";
                //     $printer->part_name         = $product ? $product->part_name : "No Data";
                //     $printer->back_number_adm   = $product->back_number_adm;

                //     if ($product->is_assy == 0) {
                //         $printer->flag              = 0;
                //     }else{
                //         $printer->flag              = 1;
                //     }
                //     $printer->save();
                // }
                DB::commit();

                return $arrJSON;
            } else {
                return array("code" => "");
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return array("code" => "", "error" => $e->getMessage());
        }
    }

    public function getAjaxmachiningtable()
    {
        $create = new avi_trace_machining();
        $create->code = 'No Data';
        $create->npk = 'No Data';
        $create->date = 'No Data';
        $arrayku = array($create);
        return Datatables::of($arrayku)
            ->addColumn('product', function ($create) {
                return 'No Data';
            })
            ->addColumn('model', function ($create) {

                return 'No Data';
            })
            ->addIndexColumn()
            ->make(true);
    }

    public function getAjaxmachiningupdate()
    {
        $user                       = Auth::user();
        $create = avi_trace_machining::select('code', 'npk', 'date')
            ->where('npk', $user->npk)
            ->where('date', date('Y-m-d'))
            ->orderBy('id', 'DESC')
            ->take(5);
        return Datatables::of($create)
            ->addColumn('product', function ($create) {

                $codes  = $create->code;
                $code   = substr($create->code, 0, 2);
                $models = avi_trace_program_number::select('product')->where('code', $code)->first();
                return $models ? $models->product : '--No Product--';
            })
            ->addColumn('model', function ($create) {

                $codes  = $create->code;
                $code   = substr($create->code, 0, 2);
                $models = avi_trace_program_number::select('back_number')->where('code', $code)->first();
                return $models ? $models->back_number : '--No Back Number--';
            })
            ->addIndexColumn()
            ->make(true);
    }

    // MODULE ASSEMBLING
    //=======================================================================================================================================================

    public function scanassembling()
    {
        return view('tracebility/assembling/scan');
    }

    public function assemblingfg()
    {
        return view('tracebility/assembling/fg');
    }

    public function assemblingfgtmmin()
    {
        return view('tracebility/assembling/fg-tmmin');
    }

    public function assemblingfgdouble()
    {
        return view('tracebility/assembling/fg-double');
    }

    public function checkassemblingfg($line)
    {
        $cek = avi_trace_printer::where('line', $line)->first();
        if ($cek) {
            return [
                'line' => $line
            ];
        } else {
            return [
                'line' => null
            ];
        }
    }
    public function cekCodePart2(Request $request)
    {

        $inputs = $request->all();
        $cpart = $inputs['code'];

        $cek = avi_trace_assembling::where('code', $cpart)->first();

        if ($cek) {
            return "part sudah ada";
        } else {

            return array(
                "code" => $cpart,
            );
        }
    }


    public function getAjaxassemblingfg(Request $request)
    {
        $input = $request->all();
        $user = Auth::user()->npk;
        $kbn_int = $input['kbn_int'];
        $line = isset($input['line']) ? $input['line'] : '';
        // $strainer = isset($input['strainer']) ? $input['strainer'] : '';
        $number = isset($input['code']) ? $input['code'] : '';
        $cekPart = avi_trace_assembling::where('code', $number)->first();
        $numcek = substr($number, 0, 2);
        if ($cekPart) {

            return ["code" => ""];
        }


        if ($kbn_int) {
            if (strlen($kbn_int) == 37) {
                $lenght = strlen($kbn_int);
                $seri = substr($kbn_int, -4);
                $back_number = substr($kbn_int, 24, 4);

                $cekMaster = avi_trace_kanban_master::select('id', 'back_nmr')->where('back_nmr', $back_number)->first();
                $pro = avi_trace_program_number::select('back_number')->where('rfid_tmmin',  $cekMaster->back_nmr)->first();
                $cekMaster->back_nmr = $pro->back_number;
                $cekProgNums = avi_trace_program_number::select('back_number')->where('code',  $numcek)->get();
            } else {
                $arr = preg_split('/ +/', $kbn_int);

                if ($arr[8] == '0') {

                    $lenght = strlen($arr[10]);
                    $seri = substr($arr[10], $lenght - 4);
                    $back_number = $arr[9];
                } elseif ($arr[9] == '0') {

                    $lenght = strlen($arr[11]);
                    $seri = substr($arr[11], $lenght - 4);
                    $back_number = $arr[10];
                } else {

                    $lenght = strlen($arr[9]);
                    $seri = substr($arr[9], $lenght - 4);
                    $back_number = $arr[8];
                }

                $cekMaster = avi_trace_kanban_master::select('id', 'back_nmr')->where('back_nmr', $back_number)->first();

                $cekProgNums = avi_trace_program_number::select('back_number')->where('code',  $numcek)->get();
            }

            $isReturn = 0;

            foreach ($cekProgNums as $cekProgNum) {
                if ($cekMaster->back_nmr == $cekProgNum->back_number) {
                    $isReturn = 1;
                }
            }


            if ($isReturn == 0) {
                return ["code" => "notmatch"];
            }

            $cek = avi_trace_kanban::select('code_part')->where('no_seri', $seri)->where('master_id', $cekMaster->id)->first();
            if ($cek == null) {

                return ["code" => "notregistered"];
            }

            if ($cek->code_part == null) {

                $key = 'assembling_' . $line;
                if (Cache::has($key)) {
                    $cache = Cache::get($key);
                    if (!isset($cache[date('Y-m-d')])) {
                        $cache = [];
                        $cache = [
                            date('Y-m-d') => [
                                'counter' => 1
                            ]
                        ];
                    } else {
                        $cache[date('Y-m-d')]['counter'] += 1;
                    }
                } else {
                    $cache = [
                        date('Y-m-d') => [
                            'counter' => 1
                        ]
                    ];
                }

                Cache::forever($key, $cache);
                try {
                    DB::beginTransaction();
                    $update = avi_trace_kanban::where('no_seri', $seri)->where('master_id', $cekMaster->id)->update(['code_part' => $number]);
                    $machining = avi_trace_assembling::create([
                        'date' => date('Y-m-d'),
                        'line' => $line,
                        'npk' => $user,
                        'status' => "1",
                        // 'strainer_id' => $strainer,
                        'code' => $number,
                    ]);

                    // hit api rts
                    $area = substr($line, 0, 2);
                    $backNum = avi_trace_program_number::select('back_number')->where('code',  $numcek)->first();
                    $qty = 1;

                    $ch = curl_init(env('API_RTS') . '/' . $area . '/' . $backNum->back_number . '/' . $qty . '/' . $number . '/');

                    // Mengabaikan verifikasi SSL
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

                    // Eksekusi permintaan
                    $response = curl_exec($ch);

                    DB::commit();
                } catch (\Throwable $th) {
                    DB::rollBack();
                    return [
                        "status" => "error",
                        "messege" => "Data Not Saved, Please Rescan Part & Kanban"
                    ];
                }

                return [

                    "counter"   => $cache[date('Y-m-d')]['counter'],
                    "code" => $number,
                    "kbn_int" => $seri,
                ];
            } else {
                return ["code" => "Kanbannotreset"];
            }
        } else {
            return ["code" => "notregistered"];
        }
    }

    public function cekCodePartDouble(Request $request)
    {

        $inputs = $request->all();
        $cpart = $inputs['code'];

        $cek = avi_trace_assembling::where('code', $cpart)->first();

        if ($cek) {
            return array(
                "code" => "false",
            );
        } else {
            return array(
                "code" => $cpart,
            );
        }
    }
    public function getAjaxassemblingfgDouble(Request $request)
    {
        $input = $request->all();
        $user = Auth::user()->npk;
        $kbn_int = $input['kbn_int'];
        $line = isset($input['line']) ? $input['line'] : '';
        $number1 = isset($input['code1']) ? $input['code1'] : '';
        $number2 = isset($input['code2']) ? $input['code2'] : '';
        $numcek = substr($number1, 0, 2);

        if ($number1 == $number2) {
            return ["code" => "partdouble"];
        }

        if ($kbn_int) {
            $arr = preg_split('/ +/', $kbn_int);

            if ($arr[8] == '0') {

                $lenght = strlen($arr[10]);
                $seri = substr($arr[10], $lenght - 4);
                $back_number = $arr[9];
            } elseif ($arr[9] == '0') {

                $lenght = strlen($arr[11]);
                $seri = substr($arr[11], $lenght - 4);
                $back_number = $arr[10];
            } else {

                $lenght = strlen($arr[9]);
                $seri = substr($arr[9], $lenght - 4);
                $back_number = $arr[8];
            }

            $cekMaster = avi_trace_kanban_master::select('id', 'back_nmr')->where('back_nmr', $back_number)->first();
            if (!$cekMaster) {
                return ["code" => "notregistered"];
            }
            $cekProgNums = avi_trace_program_number::select('back_number')->where('code',  $numcek)->get();
            $isReturn = 0;

            foreach ($cekProgNums as $cekProgNum) {
                if ($cekMaster->back_nmr == $cekProgNum->back_number) {
                    $isReturn = 1;
                }
            }



            if ($isReturn == 0) {
                return ["code" => "notmatch"];
            }

            $cek = avi_trace_kanban::select('code_part')->where('no_seri', $seri)->where('master_id', $cekMaster->id)->first();
            if ($cek == null) {
                return ["code" => "notregistered"];
            }

            if ($cek->code_part == null) {
                $key = 'assembling_' . $line;
                if (Cache::has($key)) {
                    $cache = Cache::get($key);
                    if (!isset($cache[date('Y-m-d')])) {
                        $cache = [];
                        $cache = [
                            date('Y-m-d') => [
                                'counter' => 1
                            ]
                        ];
                    } else {
                        $cache[date('Y-m-d')]['counter'] += 1;
                    }
                } else {
                    $cache = [
                        date('Y-m-d') => [
                            'counter' => 1
                        ]
                    ];
                }

                Cache::forever($key, $cache);
                try {
                    DB::beginTransaction();
                    $update = avi_trace_kanban::where('no_seri', $seri)->where('master_id', $cekMaster->id)->update(['code_part' => $number1, 'code_part_2' => $number2]);
                    $machining = avi_trace_assembling::create([
                        'date' => date('Y-m-d'),
                        'line' => $line,
                        'npk' => $user,
                        'status' => "1",
                        'code' => $number1,
                    ]);
                    $machining = avi_trace_assembling::create([
                        'date' => date('Y-m-d'),
                        'line' => $line,
                        'npk' => $user,
                        'status' => "1",
                        'code' => $number2,
                    ]);

                    // hit api rts
                    $area = substr($line, 0, 2);
                    $backNum = avi_trace_program_number::select('back_number')->where('code',  $numcek)->first();
                    $qty = 2;
                    $numbers = [$number1, $number2];

                    // foreach ($numbers as $number) {
                    $ch = curl_init(env('API_RTS') . '/' . $area . '/' . $backNum->back_number . '/' . $qty . '/');

                    // Ignore SSL verification
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

                    // Execute the request
                    $response = curl_exec($ch);
                    // }

                    DB::commit();
                } catch (\Throwable $th) {
                    DB::rollBack();
                    return [
                        "status" => "error",
                        "messege" => "Data Not Saved, Please Rescan Part & Kanban"
                    ];
                }

                return [
                    "status" => "success",
                    "counter"   => $cache[date('Y-m-d')]['counter'],
                    "code" => $number1 . " & " . $number2,
                    "kbn_int" => $seri,
                ];
            } else {
                return ["code" => "Kanbannotreset"];
            }
        } else {
            return ["code" => "notregistered"];
        }
    }

    public function getAjaxassembling($number, $line)
    {
        try {

            $cek    = avi_trace_assembling::where('code', $number)->first();
            if (is_null($cek)) {
                DB::beginTransaction();
                $user                       = Auth::user();
                $scan                       = new avi_trace_assembling;
                $scan->code                 = $number;
                $scan->date                 = date('Y-m-d');
                $scan->line                 = $line;
                $scan->status               = 1;
                $scan->npk                  = $user->npk;

                $a                          = substr($number, 0, 2);
                $product                    = avi_trace_program_number::where('code', $a)->first();
                if (is_null($product)) {
                    return "Not OPN 889F Model";
                }
                $scan->save();

                // dev-1.0.0, Handika, 20180724, counter
                $key = 'assembling_' . $user->npk;
                if (Cache::has($key)) {
                    $cache = Cache::get($key);

                    if (!isset($cache[date('Y-m-d')])) {
                        $cache = [];
                        $cache = [
                            date('Y-m-d') => [
                                'counter' => 1,
                                'items' => [
                                    $number
                                ]
                            ]
                        ];
                    } else {
                        $cache[date('Y-m-d')]['counter'] += 1;
                        if (count($cache[date('Y-m-d')]['items']) >= 10) {
                            unset($cache[date('Y-m-d')]['items'][0]);
                        }
                        $cache[date('Y-m-d')]['items'][] = $number;
                        $cache[date('Y-m-d')]['items'] = array_values($cache[date('Y-m-d')]['items']);
                    }
                } else {
                    $cache = [
                        date('Y-m-d') => [
                            'counter' => 1,
                            'items' => [
                                $number
                            ]
                        ]
                    ];
                };

                Cache::forever($key, $cache);
                $arrJSON = array(
                    "code"      => $number,
                    "counter"   => $cache[date('Y-m-d')]['counter']
                );

                $a                          = substr($number, 0, 2);
                $product                    = avi_trace_program_number::select('*')->where('code', $a)->first();
                $printer                    = avi_trace_printer::where('line', $line)->first();

                if ($printer) {
                    $printer->part_code         = $number;
                    $printer->part_number       = $product ? $product->part_number : "No Data";
                    $printer->back_number       = $product ? $product->back_number : "No Data";
                    $printer->part_name         = $product ? $product->part_name : "No Data";
                    $printer->back_number_adm   = $product->back_number_adm;
                    $printer->flag              = 0;
                    $printer->save();
                }

                DB::commit();

                return $arrJSON;
            } else {
                // return response()->json($part);      // dev-1.0, Ferry, Commented ganti yg lebih bersih
                return array("code" => "");
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return array("code" => "", "error" => $e->getMessage());
        }
    }
    public function getAjaxassemblingtable()
    {
        $create = new avi_trace_assembling();
        $create->code = 'No Data';
        $create->npk = 'No Data';
        $create->date = 'No Data';
        $arrayku = array($create);
        return Datatables::of($arrayku)
            ->addColumn('product', function ($create) {
                return 'No Data';
            })
            ->addColumn('model', function ($create) {

                return 'No Data';
            })
            ->addIndexColumn()
            ->make(true);
    }
    public function getAjaxassemblingupdate()
    {
        $user                       = Auth::user();
        $create = avi_trace_assembling::select('code', 'npk', 'date')
            ->where('npk', $user->npk)
            ->where('date', date('Y-m-d'))
            ->orderBy('id', 'DESC')
            ->take(5);
        return Datatables::of($create)
            ->addColumn('product', function ($create) {

                $codes  = $create->code;
                $code   = substr($create->code, 0, 2);
                $models = avi_trace_program_number::select('product')->where('code', $code)->first();
                return $models ? $models->product : '--No Product--';
            })
            ->addColumn('model', function ($create) {

                $codes  = $create->code;
                $code   = substr($create->code, 0, 2);
                $models = avi_trace_program_number::select('back_number')->where('code', $code)->first();
                return $models ? $models->back_number : '--No Back Number--';
            })
            ->addIndexColumn()
            ->make(true);
    }

    public function assemblingng()
    {
        return view('tracebility/assembling/ng');
    }
    public function assemblingng2($code)
    {
        $ngName = avi_trace_ng_master::select('name')->where('id', $code)->first();

        return view('tracebility/assembling/ng', compact('code', 'ngName'));
    }

    /**
     * Fungsi get data part
     *
     */
    public function getPartAssemblingNg($part)
    {

        $aviNg = avi_trace_ng::with('ngdetail')->where('code', $part)->get();
        if ($aviNg) {
            return $aviNg;
        }
        return $part;
    }

    /**
     * Fungsi input data part
     *
     */
    public function inputPartAssemblingNg($part, $ng, $line)
    {

        $user = Auth::user();
        $cekNg = avi_trace_ng_master::where('id', $ng)->first();
        if (!$cekNg) {
            return [
                "status" => "error",
                "messege" => "DATA ID NG TIDAK DITEMUKAN"
            ];
        }

        // DO: cek di avi kanban dan reset kanban
        $aviAssembling = avi_trace_kanban::where('code_part', $part)->orWhere('code_part_2', $part)->first();
        if ($aviAssembling) {

            $deletePartSatu = avi_trace_assembling::where('code', $aviAssembling->code_part)->first();
            if ($deletePartSatu) {
                $deletePartSatu->delete();
            }

            $deletePartDua = avi_trace_assembling::where('code', $aviAssembling->code_part_2)->first();
            if ($deletePartDua) {
                $deletePartDua->delete();
            }

            $aviAssembling->code_part = NULL;
            $aviAssembling->code_part_2 = NULL;
            $aviAssembling->save();
        }

        $partNg = avi_trace_ng::where('code', $part)->where('id_ng', $ng)->first();
        if ($partNg) {
            $partNg->delete();
            $type = 'delete';
        } else {
            $inputNg = avi_trace_ng::create([
                'code' => $part,
                'date' => date('Y-m-d'),
                'id_ng' => $ng,
                'line' => $line,
                'pic' => $user->npk
            ]);
            $type = 'input';
        }
        $aviNg = avi_trace_ng::with('ngdetail')->where('code', $part)->get();
        return [
            "type" => $type,
            "data" => $aviNg
        ];
    }

    public function assemblingfgngAjax(Request $request)
    {
        $user = Auth::user();
        $npk = $user->npk;
        $kanban = $request->scan;
        if ($request->isPart == 0) {
            $arr = preg_split('/ +/', $kanban);

            if ($arr[8] == '0') {

                $lenght = strlen($arr[10]);
                $seri = substr($arr[10], $lenght - 4);
                $back = $arr[9];
            } elseif ($arr[9] == '0') {

                $lenght = strlen($arr[11]);
                $seri = substr($arr[11], $lenght - 4);
                $back = $arr[10];
            } else {

                $lenght = strlen($arr[9]);
                $seri = substr($arr[9], $lenght - 4);
                $back = $arr[8];
            }
            try {
                $cekMaster = avi_trace_kanban_master::select('id')->where('back_nmr', $back)->first();
                $cek    = avi_trace_kanban::where('no_seri', $seri)->where('master_id', $cekMaster->id)->whereNotNull('code_part')->first();
                if ($cek) {
                    DB::beginTransaction();

                    $assembling = avi_trace_assembling::where('code', $cek->code_part)->first();
                    $assembling->status = 0;
                    $assembling->save();
                    if ($cek->code_part_2) {
                        $assembling2 = avi_trace_assembling::where('code', $cek->code_part)->first();
                        $assembling2->status = 0;
                        $assembling2->save();
                    }

                    $cek->code_part = null;
                    $cek->code_part_2 = null;
                    $cek->save();

                    DB::commit();

                    return [
                        "error" => false,
                        "messege" => "Kanban " . $seri . " berhasil dinyatakan NG!"
                    ];
                } else {
                    return [
                        "error" => true,
                        "messege" => "kanban " . $seri . " Kosong!"
                    ];
                }
            } catch (\Exception $e) {

                DB::rollBack();
                return [
                    "error" => true,
                    "messege" => $e->getMessage()
                ];
            }
        } else {
            $assembling3 = avi_trace_assembling::where('code', $kanban)->first();
            if ($assembling3) {
                $assembling3->status = 0;
                $assembling3->save();

                return [
                    "error" => false,
                    "messege" => "Part " . $kanban . " berhasil dinyatakan NG!"
                ];
            } else {
                return [
                    "error" => true,
                    "messege" => "part " . $kanban . " tidak ditemukan!"
                ];
            }
        }
    }

    public function getAjaxassemblingng()
    {
        $user                       = Auth::user();
        $create = avi_trace_assembling::select('code', 'npk', 'date')
            ->where('npk', $user->npk)
            ->where('date', date('Y-m-d'))
            ->where('status', 0)
            ->orderBy('id', 'DESC')
            ->take(5);
        return Datatables::of($create)
            ->addColumn('product', function ($create) {

                $codes  = $create->code;
                $code   = substr($create->code, 0, 2);
                $models = avi_trace_program_number::select('product')->where('code', $code)->first();
                return $models ? $models->product : '--No Product--';
            })
            ->addColumn('model', function ($create) {

                $codes  = $create->code;
                $code   = substr($create->code, 0, 2);
                $models = avi_trace_program_number::select('back_number')->where('code', $code)->first();
                return $models ? $models->back_number : '--No Back Number--';
            })
            ->addIndexColumn()
            ->make(true);
    }

    //MODUL TORIMETRON DOWA
    //==================================================================================================================================================
    public function scanTorimetron()
    {
        return view('tracebility/torimetron/scan-dowa');
    }

    public function checkCodeTorimetron(Request $request)
    {
        $user = Auth::user()->npk;
        $today = date("Y-m-d H:i:s");
        $codes = $request->all();
        $type = $codes['type'];
        $code = $codes['code'];
        if ($type == 'kbnfg') {
            // $codesubstr = substr($code,123,4);
            $codesubstr = $code;

            $data = avi_dowa_process::select('kbn_fg', 'is_delivered')->where('kbn_fg', $codesubstr)->first();
            if ($data == null) {
                return array(
                    "type" => $type,
                    "code" => $code,
                    "codesubstr" => $codesubstr
                );
            } else if ($data->kbn_fg == null) {
                return array(
                    "type" => $type,
                    "code" => $code,
                    "codesubstr" => $codesubstr
                );
            } else if ($data->kbn_fg != null && $data->is_delivered == '1') {
                return array(
                    "type" => $type,
                    "code" => $code,
                    "codesubstr" => $codesubstr
                );
            } else {
                return array(
                    "type" => $type,
                    "code" => "false",
                    "codesubstr" => $codesubstr
                );
            }
        } elseif ($type == 'code') {
            $substr                     = substr($code, 0, 2);
            $product                    = avi_trace_program_number::where('code', $substr)->first();
            if (is_null($product)) {
                return array(
                    "type" => $type,
                    "code" => "unregistered",
                    "codesubstr" => $code
                );
            };
            $data = avi_dowa_process::select('*')->where('code', $code)->first();
            if ($data != null && $data->code != null && $data->kbn_fg == null) {
                if ($codes['isNg'] == 1) {
                    if ($data->status == '0') {
                        return array(
                            "type" => $type,
                            "code" => "false",
                            "codesubstr" => $code
                        );
                    }
                    $array = [
                        'scan_torimetron_at' => $today,
                        'npk_torimetron' => $user,
                        'status' => 0
                    ];
                    $update  = avi_dowa_process::select('code', 'scan_torimetron_at', 'npk_torimetron', 'status')->where('code', $code)->update($array);
                    return array(
                        "type" => $type,
                        "code" => "ng",
                        "codesubstr" => $code
                    );
                }
                return array(
                    "type" => $type,
                    "code" => $code,
                    "codesubstr" => $code
                );
            } else if ($data != null && $data->code != null && $data->kbn_fg !=  null) {
                return array(
                    "type" => $type,
                    "code" => "false",
                    "codesubstr" => $code
                );
            } else {
                return array(
                    "type" => $type,
                    "code" => "ngnotfound",
                    "codesubstr" => $code
                );
            }
        } else {
            return "salah";
        }
    }

    public function inputCodeTorimetron(Request $request)
    {
        $user = Auth::user()->npk;
        $code = $request->all();
        $partcodes = $code['code'];
        $now = date('Y-m-d H:i:s');
        $kbn_fg = $code['kbn_fg'];
        foreach ($partcodes as $key => $value) {
            $dataTorimetron = array(
                'kbn_fg' => $kbn_fg,
                'scan_torimetron_at' => $now,
                'npk_torimetron' => $user,
                'status' => 1
            );
            $dowaProcess = avi_dowa_process::select('kbn_fg', 'scan_torimetron_at', 'npk_torimetron', 'status')->where('code', $value)->update($dataTorimetron);
        };
        return [
            "status" => "success"
        ];
    }


    public function getNgData($line)
    {
        $today = date('Y-m-d');
        $tomorrow = date('Y-m-d', strtotime('+1 days'));
        $yesterday = date('Y-m-d', strtotime('-1 days'));
        $lineName = $line;

        if (date('H:i') >= '06:00' && date('H:i') <= '13:59') {
            $counter = DB::table('avi_trace_ngs as a')
                ->select('b.name', DB::raw('count(a.id) as counter'))
                ->join('avi_trace_ng_masters as b', 'a.id_ng', '=', 'b.id')
                ->where('a.line', $line)
                ->whereBetween('a.created_at', [$today . ' 06:00:00', $today . ' 14:00:00'])
                ->groupBy('a.id_ng')
                ->get();
            $totalPart = DB::table('avi_trace_ngs')
                ->where('line', $line)
                ->whereBetween('created_at', [$today . ' 06:00:00', $today . ' 13:59:00'])
                ->count(DB::raw('DISTINCT code'));
        } elseif (date('H:i') >= '14:00' && date('H:i') <= '21:59') {
            $counter = DB::table('avi_trace_ngs as a')
                ->select('b.name', DB::raw('count(a.id) as counter'))
                ->join('avi_trace_ng_masters as b', 'a.id_ng', '=', 'b.id')
                ->where('a.line', $line)
                ->whereBetween('a.created_at', [$today . ' 14:00:00', $today . ' 22:00:00'])
                ->groupBy('a.id_ng')
                ->get();
            $totalPart = DB::table('avi_trace_ngs')
                ->where('line', $line)
                ->whereBetween('created_at', [$today . ' 14:00:00', $today . ' 21:59:00'])
                ->count(DB::raw('DISTINCT code'));
        } elseif (date('H:i') >= '22:00' && date('H:i') <= '23:59') {
            $counter = DB::table('avi_trace_ngs as a')
                ->select('b.name', DB::raw('count(a.id) as counter'))
                ->join('avi_trace_ng_masters as b', 'a.id_ng', '=', 'b.id')
                ->where('a.line', $line)
                ->whereBetween('a.created_at', [$today . ' 22:00:00', $tomorrow . ' 06:00:00'])
                ->groupBy('a.id_ng')
                ->get();
            $totalPart = DB::table('avi_trace_ngs')
                ->where('line', $line)
                ->whereBetween('created_at', [$today . ' 22:00:00', $tomorrow . ' 05:59:00'])
                ->count(DB::raw('DISTINCT code'));
        } elseif (date('H:i') >= '00:00' && date('H:i') <= '05:59') {
            $counter = DB::table('avi_trace_ngs as a')
                ->select('b.name', DB::raw('count(a.id) as counter'))
                ->join('avi_trace_ng_masters as b', 'a.id_ng', '=', 'b.id')
                ->where('a.line', $line)
                ->whereBetween('a.created_at', [$yesterday . ' 22:00:00', $today . ' 06:00:00'])
                ->groupBy('a.id_ng')
                ->get();
            $totalPart = DB::table('avi_trace_ngs')
                ->where('line', $line)
                ->whereBetween('created_at', [$yesterday . ' 22:00:00', $today . ' 05:59:00'])
                ->count(DB::raw('DISTINCT code'));
        }

        return [
            "counter" => $counter,
            "line" => $lineName,
            "totalPart" => $totalPart
        ];
    }
}
