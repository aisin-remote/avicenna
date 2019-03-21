<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class EmailDashboard extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Email:AndonStatus';

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
                $d = avi_andon_status::select('avi_andon_status.line','avi_andon_status.status', 'users.name as name', 'users.email as email')->join('users','users.npk','avi_andon_status.pic_spv')->where('line', $warning->line)->first();  
            }elseif ($update_at->updated_at->addSeconds(600) <= $now && $now <= $update_at->updated_at->addSeconds(900)) {
                $d = avi_andon_status::select('avi_andon_status.line','avi_andon_status.status', 'users.name as name', 'users.email as email')->join('users','users.npk','avi_andon_status.pic_mgr')->where('line', $warning->line)->first();
            }else{
                $d = avi_andon_status::select('avi_andon_status.line','avi_andon_status.status', 'users.name as name', 'users.email as email')->join('users','users.npk','avi_andon_status.pic_gm')->where('line', $warning->line)->first();
                if ($d->flag_email == 0 ) {
                    email($d->email, $status);
                }
            }

        }
    }

    public function email($email,$status)
    {

        $value = array('tanggal' => $yesterday);
        $penerima = array('audi.r@aiia.co.id');

        Mail::send('tracebility.email.index', $value, function($message) use ($penerima)  {
        $message->to('handika@aiia.co.id')
                    ->subject('Traceability')
                    ->attach(storage_path('traceability/print_part_tmiin.csv'));
        $message->cc($penerima);
        $message->from('aisinbisa@aiia.co.id');
        });
    }


}
