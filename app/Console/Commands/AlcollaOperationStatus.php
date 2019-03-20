<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use \DB;
use \Carbon\Carbon;

use App\Models\Avicenna\avi_andon_status;
use App\Models\Iot\TT_DATA_OPERATION_STATUS;

class AlcollaOperationStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'alcolla:operationStatus';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mengisi table Al Colla Operation Status';

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

       echo "Memproses Alcolla Operation Status ...";
       
       // dev-1.1.0, Ferry, 20190320
       $now = Carbon::now();

       // Mengambil nilai avi_andon_status untuk Line AS600 dan AS523
       $andons = avi_andon_status::select('line', 'status')->whereIn('line', ['AS523', 'AS600'])->get();

       foreach ($andons as $andon) {

            // fokus untuk insert alcolla TT_DATA_OPERATION_STATUS
            // cek untuk hari ini apakah empty row ? 
            // jika empty maka cek value avi_andon_status harus = 1 krn ada aktivitas dan insert ke Alcolla status 1

            // jika ada row data. Maka cek apakah status andon 0 = alcolla 0,2,3,4,5 maka do nothing.
            // jika andon 1 = alcolla 1 maka do nothing
            // jika andon 0,2,3,4,5 <> alcolla 1. maka update status ke alcolla status 0
            // jika andon 1 <> alcolla 0. maka insert status ke alcolla status 1

            $alcolla = TT_DATA_OPERATION_STATUS::where('DTM_TIM_OPERATION_START', 'LIKE', $now->format('Y-m-d').'%')
                            ->whereRaw("(CHR_COD_KOFU + CHR_COD_LINE) = '".$andon->line."'")
                            ->orderBy('DTM_TIM_OPERATION_START', 'DESC')
                            ->first();
            if ($alcolla) { // ada data hari ini
                if ( (($andon->status == 0) || ($andon->status == 2) || ($andon->status == 3) || 
                    ($andon->status == 4) || ($andon->status == 5)) && 
                    ($alcolla->INT_KUB_OPERATION_STATUS == 1) ) {
                    
                    // update status alcolla ke 0
                    $alcolla->INT_KUB_OPERATION_STATUS = 0;
                    $alcolla->DTM_TIM_OPERATION_END = $now->format('Y-m-d H:i:s.0000000');
                    $alcolla->CHR_INF_KOSIN_USER = 'AVICENNA';
                    $alcolla->CHR_NGP_KOSIN = $now->format('Ymd');
                    $alcolla->CHR_TIM_KOSIN = $now->format('His');
                    $alcolla->timestamps = false;
                    $alcolla->save();
                }
                elseif (($andon->status == 1) && ($alcolla->INT_KUB_OPERATION_STATUS == 0)) {
                    $this->insertDB($andon->line, 1);
                }

            }
            else {  // tidak ada data hari ini
                if ($andon->status == 1) {  // ada aktivitas
                    $this->insertDB($andon->line, 1);
                }
            }
       }

       echo "Proses Alcolla Operation Status Selesai !";
    }

    private function insertDB($line, $status) {

        $now = Carbon::now();
        $nowUTC = Carbon::now('UTC');

        $alcolla = new TT_DATA_OPERATION_STATUS;

        $alcolla->DTM_TIM_OPERATION_START = $now->format('Y-m-d H:i:s.0000000');
        $alcolla->CHR_COD_COMPANY = 'J922';
        $alcolla->CHR_COD_KJ = 'JE';
        $alcolla->CHR_COD_KOFU = 'AS';
        $alcolla->CHR_COD_LINE = substr($line, -3);
        $alcolla->INT_KUB_OPERATION_STATUS = $status;
        $alcolla->DTM_TIM_OPERATION_END = null;
        $alcolla->DTM_TIM_OPERATION_START_UTC = $nowUTC->format('Y-m-d H:i:s.0000000');
        $alcolla->DTM_TIM_SERVER_UTC = $nowUTC->format('Y-m-d H:i:s.0000000');
        $alcolla->INT_KEY_REFERENCE = 1;
        $alcolla->CHR_INF_SAKUSEI_USER = 'AVICENNA';
        $alcolla->CHR_NGP_SAKUSEI = $now->format('Ymd');
        $alcolla->CHR_TIM_SAKUSEI = $now->format('His');
        $alcolla->CHR_INF_KOSIN_USER = 'AVICENNA';
        $alcolla->CHR_NGP_KOSIN = $now->format('Ymd');
        $alcolla->CHR_TIM_KOSIN = $now->format('His');
        
        $alcolla->timestamps = false;
        $alcolla->save();
    }

}
