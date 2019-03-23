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

            $update_at = avi_andon_status::select('updated_at')
            ->where('line', $line->line)->first();
            $now     = Carbon::now();

            if ($update_at->updated_at->addSeconds(300) <= $now && $now <= $update_at->updated_at->addSeconds(600)) {
                $d = avi_andon_status::select('avi_andon_status.line','avi_andon_status.status', 'users.name as name', 'users.email as email')->join('users','users.npk','avi_andon_status.pic_spv')->where('line', $line->line)->first(); 
                if ($d->status == 2 || $d->status == 3 || $d->status == 4 ) {
                    if ($d->flag_spv == 0 ) {
                    $this->email($d->email, $d->status, $d->line, '5 Menit');
                    $flag1 = avi_andon_status::where('line', $line->line)->first();
                    $flag1->flag_spv = 1;
                    $flag1->save();
                    }
                }
            }elseif ($update_at->updated_at->addSeconds(600) <= $now && $now <= $update_at->updated_at->addSeconds(900)) {
                $d = avi_andon_status::select('avi_andon_status.line','avi_andon_status.status', 'users.name as name', 'users.email as email')->join('users','users.npk','avi_andon_status.pic_mgr')->where('line', $line->line)->first();
                if ($d->status == 2 || $d->status == 3 || $d->status == 4 ) {
                    if ($d->flag_mgr == 0 ) {
                    $this->email($d->email, $d->status, $d->line, '10 Menit');
                    $flag1 = avi_andon_status::where('line', $line->line)->first();
                    $flag1->flag_mgr = 1;
                    $flag1->save();
                    }
                }
            }else{
                $d = avi_andon_status::select('avi_andon_status.line','avi_andon_status.status', 'users.name as name', 'users.email as email')->join('users','users.npk','avi_andon_status.pic_gm')->where('line', $line->line)->first();
                if ($d->status == 2 || $d->status == 3 || $d->status == 4 ) {
                    if ($d->flag_gm == 0 ) {
                    $this->email($d->email, $d->status, $d->line, '15 Menit');
                    $flag1 = avi_andon_status::where('line', $line->line)->first();
                    $flag1->flag_gm = 1;
                    $flag1->save();
                    }
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

                $penerima = array('audi.r@aiia.co.id');

                Mail::send('tracebility.email.linestatus', $value, function($message) use ($penerima,$email,$line)  {
                $message->to($email)
                            ->subject($line);
                $message->cc($penerima);
                $message->from('aisinbisa@aiia.co.id');
                });
            }
  


}
