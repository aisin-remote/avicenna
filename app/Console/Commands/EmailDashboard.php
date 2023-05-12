<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Models\Avicenna\avi_andon_status;
use App\Models\Avicenna\avi_andon_status_history;
use App\User;
use DB;
use Carbon\Carbon;

// Declare disini jika butuh Class bawaan laravel dan plugin yang tidak auto-generated
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Cookie\CookieJar;

class EmailDashboard extends Command
{
    private $client;    // SMS Api Client

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'avicenna:emailDashboard';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Email status andon terhadap PIC';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->client = new Client([
            // Base URI is used with relative requests
            'base_uri' => env('SMS_GATEWAY_URL'),
            // You can set any number of default request options.
            'timeout'  => env('SMS_GATEWAY_TIMEOUT'),
        ]);
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $lines = avi_andon_status::select('*')
        ->get();
        foreach ($lines as $line ) {
            $now = Carbon::now();

              if ($line->error_at) {
                $error1 = Carbon::parse($line->error_at);
                $error2 = Carbon::parse($line->error_at);
                $error3 = Carbon::parse($line->error_at);
                $satu   = env('AVI_EMAIL_LINE_1', 300);
                $dua    = env('AVI_EMAIL_LINE_2', 600);
                $tiga   = env('AVI_EMAIL_LINE_3', 900);
                $a = $error1->addSeconds($satu);
                $b = $error2->addSeconds($dua);
                $c = $error3->addSeconds($tiga);

                if ($a < $now && $now < $b) {

                    $d = avi_andon_status::select('avi_andon_status.line','avi_andon_status.status', 'users.name as name', 'users.email as email','avi_andon_status.flag_spv as flag_spv','avi_andon_status.cc_spv as cc','avi_andon_status.error_at')->join('users','users.npk','avi_andon_status.pic_spv')->where('line', $line->line)->first();
                    if ($d->status == 2 || $d->status == 3 || $d->status == 4 ) {
                        if ($d->flag_spv == 0 ) {
                        $time = round($satu/60);
                        $flag1 = avi_andon_status::where('line', $line->line)->first();
                        $flag1->flag_spv = 1;
                        $flag1->save();

                        $finishAndonHistory = avi_andon_status_history::where('finish_at', NULL)->where('andon_id', $line->id)->first();
                        $this->email($finishAndonHistory->id, $d->email, $d->status, $d->line, $time, $d->cc, $d->error_at);

                        }
                    }

                }elseif ($b < $now && $now < $c) {
                    $d = avi_andon_status::select('avi_andon_status.line','avi_andon_status.status', 'users.name as name', 'users.email as email','avi_andon_status.flag_mgr as flag_mgr','avi_andon_status.cc_mgr as cc','avi_andon_status.error_at')->join('users','users.npk','avi_andon_status.pic_mgr')->where('line', $line->line)->first();
                    if ($d->status == 2 || $d->status == 3 || $d->status == 4 ) {
                        if ($d->flag_mgr == 0 ) {
                        $time = round($dua/60);
                        $flag1 = avi_andon_status::where('line', $line->line)->first();
                        $flag1->flag_mgr = 1;
                        $flag1->save();

                        $finishAndonHistory = avi_andon_status_history::where('finish_at', NULL)->where('andon_id', $line->id)->first();
                        $this->email($finishAndonHistory->id, $d->email, $d->status, $d->line, $time, $d->cc, $d->error_at);

                        }
                    }
                }elseif ($now > $c){
                    $d = avi_andon_status::select('avi_andon_status.line','avi_andon_status.status', 'users.name as name', 'users.email as email','avi_andon_status.flag_gm as flag_gm','avi_andon_status.cc_email as cc','avi_andon_status.error_at')->join('users','users.npk','avi_andon_status.pic_gm')->where('line', $line->line)->first();
                    if ($d->status == 2 || $d->status == 3 || $d->status == 4 ) {
                        if ($d->flag_gm == 0 ) {
                        $time = round($tiga/60);
                        $flag1 = avi_andon_status::where('line', $line->line)->first();
                        $flag1->flag_gm = 1;
                        $flag1->save();

                        $finishAndonHistory = avi_andon_status_history::where('finish_at', NULL)->where('andon_id', $line->id)->first();
                        $this->email($finishAndonHistory->id, $d->email, $d->status, $d->line, $time, $d->cc, $d->error_at);

                        }
                    }

                }else{
                    echo "line oke";
                }

            }

            if ($line->finish_at) {
                $andonFinished = avi_andon_status_history::where('finish_at', NULL)->where('andon_id', $line->id)->first();
                $rangeTime = strtotime($line->finish_at) - strtotime($line->error_at);

                $error1 = Carbon::parse($line->finish_at);
                $error2 = Carbon::parse($line->finish_at);
                $error3 = Carbon::parse($line->finish_at);
                $satu   = env('AVI_EMAIL_LINE_1', 300);
                $dua    = env('AVI_EMAIL_LINE_2', 600);
                $tiga   = env('AVI_EMAIL_LINE_3', 900);

                if ($satu < $rangeTime && $rangeTime < $dua) {

                    $satu = avi_andon_status::select('avi_andon_status.line','avi_andon_status.status', 'users.name as name', 'users.email as email','avi_andon_status.flag_spv as flag_spv','avi_andon_status.cc_spv as cc','avi_andon_status.error_at')->join('users','users.npk','avi_andon_status.pic_spv')->where('line', $line->line)->first();
                    if ($andonFinished->status == 2 || $andonFinished->status == 3 || $andonFinished->status == 4 ) {
                        $time = round($rangeTime/60);

                        $finishAndonHistory = avi_andon_status_history::where('finish_at', NULL)->where('andon_id', $line->id)->first();
                        $resetAndonStatus = avi_andon_status::where('line', $line->line)->first();

                        $finishAndonHistory->finish_at = $resetAndonStatus->finish_at;
                        $finishAndonHistory->save();

                        $resetAndonStatus->error_at = NULL;
                        $resetAndonStatus->finish_at = NULL;
                        $resetAndonStatus->save();

                        $this->emailfinish($finishAndonHistory->id, $satu->email, $andonFinished->status, $satu->line, $time, $satu->cc);
                    }

                }elseif ($dua < $rangeTime && $rangeTime < $tiga) {
                    $dua = avi_andon_status::select('avi_andon_status.line','avi_andon_status.status', 'users.name as name', 'users.email as email','avi_andon_status.flag_mgr as flag_mgr','avi_andon_status.pic_spv as pic_spv','avi_andon_status.cc_spv as cc_spv','avi_andon_status.cc_mgr as cc_mgr','avi_andon_status.error_at')->join('users','users.npk','avi_andon_status.pic_mgr')->where('line', $line->line)->first();

                    $cc = $dua->pic_spv . "," . $dua->cc_spv . "," . $dua->cc_mgr;
                    if ($andonFinished->status == 2 || $andonFinished->status == 3 || $andonFinished->status == 4 ) {
                        $time = round($rangeTime/60);

                        $finishAndonHistory = avi_andon_status_history::where('finish_at', NULL)->where('andon_id', $line->id)->first();
                        $resetAndonStatus = avi_andon_status::where('line', $line->line)->first();

                        $finishAndonHistory->finish_at = $resetAndonStatus->finish_at;
                        $finishAndonHistory->save();

                        $resetAndonStatus->error_at = NULL;
                        $resetAndonStatus->finish_at = NULL;
                        $resetAndonStatus->save();

                        $this->emailfinish($finishAndonHistory->id, $dua->email, $andonFinished->status, $dua->line, $time, $cc);
                    }
                }elseif ($rangeTime > $tiga){
                    $dua = avi_andon_status::select('avi_andon_status.line','avi_andon_status.status', 'users.name as name', 'users.email as email','avi_andon_status.flag_mgr as flag_mgr','avi_andon_status.pic_spv as pic_spv','avi_andon_status.cc_spv as cc_spv','avi_andon_status.cc_mgr as cc_mgr','avi_andon_status.cc_email as cc_gm','avi_andon_status.error_at')->join('users','users.npk','avi_andon_status.pic_gm')->where('line', $line->line)->first();
                    $cc = $dua->pic_spv . "," . $dua->cc_spv . $dua->pic_mgr . "," . $dua->cc_mgr . "," . $dua->cc_gm ;
                    if ($andonFinished->status == 2 || $andonFinished->status == 3 || $andonFinished->status == 4 ) {
                        $time = round($rangeTime/60);

                        $finishAndonHistory = avi_andon_status_history::where('finish_at', NULL)->where('andon_id', $line->id)->first();
                        $resetAndonStatus = avi_andon_status::where('line', $line->line)->first();

                        $finishAndonHistory->finish_at = $resetAndonStatus->finish_at;
                        $finishAndonHistory->save();

                        $resetAndonStatus->error_at = NULL;
                        $resetAndonStatus->finish_at = NULL;
                        $resetAndonStatus->save();

                        $this->emailfinish($finishAndonHistory->id, $dua->email, $andonFinished->status, $dua->line, $time, $cc);
                    }

                }else{
                    $finishAndonHistories = avi_andon_status_history::where('finish_at', NULL)->where('andon_id', $line->id)->get();
                    $resetAndonStatus = avi_andon_status::where('line', $line->line)->first();
                    // fix more than 1 problem in one mintes
                    foreach ($finishAndonHistories as $finishAndonHistory) {
                        $update = avi_andon_status_history::where('id', $finishAndonHistory->id)->update([
                            'finish_at' => $resetAndonStatus->finish_at]);
                    }

                    $resetAndonStatus->error_at = NULL;
                    $resetAndonStatus->finish_at = NULL;
                    $resetAndonStatus->save();
                }
            }

        }




    }
    function email($id, $email, $status, $line, $time, $cc="", $error)
    {
        if ($status == 2) {
           $textstatus = 'Problem Machine';
        }
        elseif ($status == 3) {
           $textstatus = 'Problem Quality';
        }
        elseif ($status == 4) {
           $textstatus = 'Problem Supply Part';
        }
        $penerima = [];

        if ($cc != '' || $cc != null ) {
            $penerima = [];
            $npks = (explode(",",$cc));
            foreach ($npks as $npk ) {
                $mail = User::where('npk', $npk)->first();
                $push = array_push($penerima, $mail->email);
            }
        }else{
            $penerima = [];
        }
        $value = array ('tanggal' => $error,
                        'status' => $textstatus,
                        'line' => $line,
                        'time' => $time,
                        );

        //Resume next
        // try {
        //     Mail::send('tracebility.email.linestatus', $value, function($message) use ($email,$line,$penerima)  {
        //     $message->to($email)
        //                 ->subject($line);
        //     $message->cc($penerima);
        //     $message->from('aisinbisa@aiia.co.id');
        //     });

        // } catch (Exception $e) {

        // }

        // email sudah selesai urusannya
        // dilanjutkan SMS blast

        // dev-1.1.0, Ferry, 20190408. SMS Api ke Elpia gateway
        $users = User::whereIn('npk', explode(",", $cc))
                        ->orWhere('email', $email)
                        ->get();

        $errordate = date('Y-m-d', strtotime($error));
        $errortime = date('H:i:s', strtotime($error));
        // WA message
        foreach ($users as $user) {

            $token = "v2n49drKeWNoRDN4jgqcdsR8a6bcochcmk6YphL6vLcCpRZdV1";
            $message = sprintf("```---- ``` *REAL TIME ALERT* ``` ----%cID          : ALERT-$id %cTGL       : $errordate %cJAM     : $errortime %cLINE     : ``` *$line* ``` %cSTATUS   : $textstatus %cDOWNTIME : $time Minutes %c-------------------------``` ", 10, 10, 10, 10, 10, 10, 10, 10);
            $curl = curl_init();
            curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://app.ruangwa.id/api/send_message',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => 'token='.$token.'&number='.$user->phone_number.'&message='.$message,
            ));
            $response = curl_exec($curl);
            curl_close($curl);
            echo $response;

        }

        // end
    }

    function emailfinish($id, $email, $status, $line, $time, $cc="")
    {
        $textstatus = 'Problem ``` *SOLVED* ```';
        $penerima = [];

        if ($cc != '' || $cc != null ) {
            $penerima = [];
            $npks = (explode(",",$cc));
            foreach ($npks as $npk ) {
                $mail = User::where('npk', $npk)->first();
                $push = array_push($penerima, $mail->email);
            }
        }else{
            $penerima = [];
        }


        $users = User::whereIn('npk', explode(",", $cc))
                        ->orWhere('email', $email)
                        ->get();

        // WA message
        foreach ($users as $user) {
            $param = 0;
            while ($param < 1) {
                $firstVal = DB::connection('mysql2')->table('tw_message')->first();

                if (!$firstVal) {
                    DB::connection('mysql2')->table('tw_message')->insert([
                        'nowa' => $user->phone_number,
                        'pesan' => sprintf("```---- ``` *REAL TIME ALERT* ``` ----%cID       : ALERT-$id %cLINE     : ``` *$line* ``` %cSTATUS   : $textstatus %cSOLVETIME: $time Minutes %c-------------------------``` ", 10, 10, 10, 10, 10)
                    ]);

                    $param++;
                }
            }
        }
    }



}
