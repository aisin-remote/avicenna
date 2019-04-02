<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Models\Avicenna\avi_andon_status;
use Carbon\Carbon;

class EmailDashboard extends Command
{
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
                $satu   = env('AVI_EMAIL_LINE', 300);
                $dua    = env('AVI_EMAIL_LINE', 300) + env('AVI_EMAIL_LINE', 300);
                $tiga   = env('AVI_EMAIL_LINE', 300) + env('AVI_EMAIL_LINE', 300) + env('AVI_EMAIL_LINE', 300);
                    $a = $error1->addSeconds($satu);
                    $b = $error2->addSeconds($dua);
                    $c = $error3->addSeconds($tiga);

            if ($a < $now && $now < $b) {
                $d = avi_andon_status::select('avi_andon_status.line','avi_andon_status.status', 'users.name as name', 'users.email as email','avi_andon_status.flag_spv as flag_spv')->join('users','users.npk','avi_andon_status.pic_spv')->where('line', $line->line)->first(); 
                if ($d->status == 2 || $d->status == 3 || $d->status == 4 ) {
                    if ($d->flag_spv == 0 ) {
                    $time = $satu/60;
                    $this->email($d->email, $d->status, $d->line, $time);
                    $flag1 = avi_andon_status::where('line', $line->line)->first();
                    $flag1->flag_spv = 1;
                    $flag1->save();
                    }
                }
            }elseif ($b < $now && $now < $c) {
                $d = avi_andon_status::select('avi_andon_status.line','avi_andon_status.status', 'users.name as name', 'users.email as email','avi_andon_status.flag_mgr as flag_mgr')->join('users','users.npk','avi_andon_status.pic_mgr')->where('line', $line->line)->first();
                if ($d->status == 2 || $d->status == 3 || $d->status == 4 ) {
                    if ($d->flag_mgr == 0 ) {
                    $time = $dua/60;
                    $this->email($d->email, $d->status, $d->line, $time);
                    $flag1 = avi_andon_status::where('line', $line->line)->first();
                    $flag1->flag_mgr = 1;
                    $flag1->save();
                    }
                }
            }elseif ($now > $c){
                $d = avi_andon_status::select('avi_andon_status.line','avi_andon_status.status', 'users.name as name', 'users.email as email','avi_andon_status.flag_gm as flag_gm')->join('users','users.npk','avi_andon_status.pic_gm')->where('line', $line->line)->first();
                if ($d->status == 2 || $d->status == 3 || $d->status == 4 ) {
                    if ($d->flag_gm == 0 ) {
                    $time = $tiga/60;
                    $this->email($d->email, $d->status, $d->line, $time);
                    $flag1 = avi_andon_status::where('line', $line->line)->first();
                    $flag1->flag_gm = 1;
                    $flag1->save();
                    }
                }
                
            }else{
                echo "oke";
            }


        }
            

            

        }



        
    }
    function email($email,$status,$line,$time)
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
                $now = Carbon::now()->format('Y-m-d');

                $value = array ('tanggal' => $now,
                                'status' => $textstatus,
                                'line' => $line,
                                'time' => $time,
                                );

                // $penerima = array('audi.r@aiia.co.id');

                Mail::send('tracebility.email.linestatus', $value, function($message) use ($email,$line)  {
                $message->to($email)
                            ->subject($line);
                // $message->cc($penerima);
                $message->from('aisinbisa@aiia.co.id');
                });
            }
  


}
