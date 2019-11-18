<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Models\Avicenna\avi_andon_status;
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
        $lines = avi_andon_status::select('line')
        ->get();
        foreach ($lines as $line ) {

            $error_at = avi_andon_status::select('error_at')
            ->where('line', $line->line)->first();
            $now     = Carbon::now();

            if ($error_at->error_at) {
            $error1 = Carbon::parse($error_at->error_at);
            $error2 = Carbon::parse($error_at->error_at);
            $error3 = Carbon::parse($error_at->error_at);
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
                        $time = $satu/60;
                        $flag1 = avi_andon_status::where('line', $line->line)->first();
                        $flag1->flag_spv = 1;
                        $flag1->save();
                        $this->email($d->email, $d->status, $d->line, $time, $d->cc, $d->error_at);

                        }
                    }
                }elseif ($b < $now && $now < $c) {
                    $d = avi_andon_status::select('avi_andon_status.line','avi_andon_status.status', 'users.name as name', 'users.email as email','avi_andon_status.flag_mgr as flag_mgr','avi_andon_status.cc_mgr as cc','avi_andon_status.error_at')->join('users','users.npk','avi_andon_status.pic_mgr')->where('line', $line->line)->first();
                    if ($d->status == 2 || $d->status == 3 || $d->status == 4 ) {
                        if ($d->flag_mgr == 0 ) {
                        $time = $dua/60;
                        $flag1 = avi_andon_status::where('line', $line->line)->first();
                        $flag1->flag_mgr = 1;
                        $flag1->save();
                        $this->email($d->email, $d->status, $d->line, $time, $d->cc, $d->error_at);

                        }
                    }
                }elseif ($now > $c){
                    $d = avi_andon_status::select('avi_andon_status.line','avi_andon_status.status', 'users.name as name', 'users.email as email','avi_andon_status.flag_gm as flag_gm','avi_andon_status.cc_email as cc','avi_andon_status.error_at')->join('users','users.npk','avi_andon_status.pic_gm')->where('line', $line->line)->first();
                    if ($d->status == 2 || $d->status == 3 || $d->status == 4 ) {
                        if ($d->flag_gm == 0 ) {
                        $time = $tiga/60;
                        $flag1 = avi_andon_status::where('line', $line->line)->first();
                        $flag1->flag_gm = 1;
                        $flag1->save();
                        $this->email($d->email, $d->status, $d->line, $time, $d->cc, $d->error_at);

                        }
                    }

                }else{
                    echo "oke";
                }

            }

        }




    }
    function email($email,$status,$line,$time,$cc="",$error)
            {
                if ($status == 2) {
                   $textstatus = 'Error Problem Machine';
                }
                elseif ($status == 3) {
                   $textstatus = 'Error Problem Quality';
                }
                elseif ($status == 4) {
                   $textstatus = 'Error Problem Supply Part';
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
                Mail::send('tracebility.email.linestatus', $value, function($message) use ($email,$line,$penerima)  {
                $message->to($email)
                            ->subject($line);
                $message->cc($penerima);
                $message->from('aisinbisa@aiia.co.id');
                });

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
                    $param = 0;
                    while ($param < 1) {
                        $firstVal = DB::connection('mysql2')->table('tw_message')->first();

                        if (!$firstVal) {
                            DB::connection('mysql2')->table('tw_message')->insert([
                                'nowa' => $user->phone_number,
                                'pesan' => sprintf("```----------------------------- %cREAL TIME ALERT %cTGL      : $errordate %cJAM      : $errortime %cLINE     : $line %cSTATUS   : $textstatus %cDOWNTIME : $time Minutes %c-----------------------------``` ", 13, 13, 13, 13, 13, 13,13)
                            ]);

                            $param++;
                        }
                    }
                }

                // SMS

                // foreach ($users as $user) {

                    // $response = $this->client->request('GET', 'plain', [
                    //     'query' => [
                    //         'user'      => env('SMS_GATEWAY_USER'),
                    //         'password'  => env('SMS_GATEWAY_PASSWORD'),
                    //         'SMSText'   => 'REAL TIME ALERT: '.$error.', LINE: '.$line.', STATUS: '.$textstatus. ', DOWNTIME: '.$time.' Minutes',
                    //         'GSM'       => $user->phone_number,
                    //     ],

                    // ]);
                // }

                // end
            }



}
