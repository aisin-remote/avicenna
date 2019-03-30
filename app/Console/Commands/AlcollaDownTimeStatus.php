<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use \Carbon\Carbon;
use \DB;
use App\Models\Avicenna\avi_andon_status;
use App\Models\Iot\TT_DATA_DOWN_RESULT;


class AlcollaDownTimeStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'alcolla:downtimeStatus';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mengisi table Al Colla Downtime Status';

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
        $line_status=avi_andon_status::select('id','line','status','status_before')
                                ->whereIn('line',['AS600','AS523'])
                                ->get();
        
        foreach ($line_status as $my_status) {
            if($my_status->status!= 0){
                if($my_status->status != $my_status->status_before){
                    if($my_status->status!=1){

                        try {
                            DB::beginTransaction();

                            // Insert ke SQL SERVER
                            $dataDown=new TT_DATA_DOWN_RESULT();
                            $dataDown->DTM_TIM_DOWN_OCCURRENCE = Carbon::now()->format('Y-m-d H:i:s.0000000');
                            $dataDown->CHR_COD_COMPANY = 'J922';
                            $dataDown->CHR_COD_KJ = 'JE';
                            $dataDown->CHR_COD_KOFU = 'AS';
                            $dataDown->CHR_COD_LINE = substr($my_status->line,2,3);
                            if($my_status->status==2){
                                $dataDown->CHR_COD_STOP_P='001';
                            }elseif($my_status->status==3){
                                $dataDown->CHR_COD_STOP_P='005';
                            }elseif($my_status->status==4){
                                $dataDown->CHR_COD_STOP_P='003';
                            }elseif ($my_status->status==5) {
                                $dataDown->CHR_COD_STOP_P='004';
                            }else{
                                $dataDown->CHR_COD_STOP_P='006';
                            }
                            $dataDown->INT_KUB_DOWN_STATUS= 1; // --> Start Stop Line
                            $dataDown->DTM_TIM_RESTORTION=NULL;
                            $dataDown->DTM_TIM_DOWN_OCCURRENCE_UTC=Carbon::now('UTC')->format('Y-m-d H:i:s.0000000');
                            $dataDown->DTM_TIM_SERVER_UTC = Carbon::now('UTC')->format('Y-m-d H:i:s.0000000');
                            $dataDown->INT_KEY_REFERENCE=1;
                            $dataDown->CHR_INF_SAKUSEI_USER = 'SYSTEM';
                            $dataDown->CHR_NGP_SAKUSEI = Carbon::now()->format('Ymd');
                            $dataDown->CHR_TIM_SAKUSEI = Carbon::now()->format('Hi');
                            $dataDown->CHR_INF_KOSIN_USER = NULL;
                            $dataDown->CHR_NGP_KOSIN = NULL;
                            $dataDown->CHR_TIM_KOSIN = NULL;
                            $dataDown->timestamps = false;
                            $dataDown->save();

                            //Update Status Before disamakan
                            $my_status->status_before=$my_status->status;
                            $my_status->save();

                            DB::commit();
                        } catch (Exception $e) {
                            echo $ex->getMessage();
                            DB::rollBack();
                        }
                        
                    }else{
                        if($my_status->status_before!=0){

                            $dataDown=TT_DATA_DOWN_RESULT::where('CHR_COD_LINE', substr($my_status->line,2,3))
                            ->orderBy('DTM_TIM_DOWN_OCCURRENCE','DESC')
                            ->first();
                            if($dataDown){
                                try {
                                    DB::beginTransaction();
                                        //Update ke SQL Server
                                    $dataDown->INT_KUB_DOWN_STATUS= 3; // --> Finish/Restore
                                    $dataDown->DTM_TIM_RESTORTION=Carbon::now()->format('Y-m-d H:i:s.0000000');
                                    $dataDown->DTM_TIM_SERVER_UTC = Carbon::now('UTC')->format('Y-m-d H:i:s.0000000');
                                    $dataDown->CHR_INF_KOSIN_USER = 'SYSTEM';
                                    $dataDown->CHR_NGP_KOSIN = Carbon::now()->format('Ymd');
                                    $dataDown->CHR_TIM_KOSIN = Carbon::now()->format('Hi');
                                    $dataDown->timestamps = false;
                                    $dataDown->save();

                                    //Update Status Before disamakan
                                    $my_status->status_before=$my_status->status;
                                    $my_status->save();

                                    DB::commit();

                                } catch (Exception $e) {
                                    echo "Error karena: ".$ex->getMessage();
                                    DB::rollBack();
                                }
                            }


                        }
                    }
                }
            }elseif($my_status->status == 0 && $my_status->status_before > 1){

                $dataDown=TT_DATA_DOWN_RESULT::where('CHR_COD_LINE', substr($my_status->line,2,3))
                ->orderBy('DTM_TIM_DOWN_OCCURRENCE','DESC')
                ->first();
                if($dataDown){
                    try {
                        DB::beginTransaction();
                            //Update ke SQL Server
                        $dataDown->INT_KUB_DOWN_STATUS= 3; // --> Finish/Restore
                        $dataDown->DTM_TIM_RESTORTION=Carbon::now()->format('Y-m-d H:i:s.0000000');
                        $dataDown->DTM_TIM_SERVER_UTC = Carbon::now('UTC')->format('Y-m-d H:i:s.0000000');
                        $dataDown->CHR_INF_KOSIN_USER = 'SYSTEM';
                        $dataDown->CHR_NGP_KOSIN = Carbon::now()->format('Ymd');
                        $dataDown->CHR_TIM_KOSIN = Carbon::now()->format('Hi');
                        $dataDown->timestamps = false;
                        $dataDown->save();

                        //Update Status Before disamakan
                        $my_status->status_before=$my_status->status;
                        $my_status->save();

                        DB::commit();

                    } catch (Exception $e) {
                        echo "Error karena: ".$ex->getMessage();
                        DB::rollBack();
                    }
                }
            }
        }

    }
}
