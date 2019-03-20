<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use \Carbon\Carbon;
use \DB;
use App\Models\Avicenna\avi_andon;
use App\Models\Avicenna\avi_part_production;
use App\Models\Iot\TT_DATA_PROD_RESULT;

class AlcollaProductionResult extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'alcolla:productionResult';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mengisi table Al Colla Production Result';

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
        $lines = avi_andon::select('line','actual_qty','buffer_alcolla','back_number')
                        ->where('line','AS600')
                        ->orWhere('line','AS523')
                        ->get();
        // echo $lines;
        // echo"\n";
        foreach ($lines as $line) {
            if($line->actual_qty > $line->buffer_alcolla){
                try{
                    DB::beginTransaction();

                    $qty_prod_result=$line->actual_qty-$line->buffer_alcolla;
                    $master_part=avi_part_production::select('part_number','ct')
                        ->where('back_number',$line->back_number)
                        ->firstOrFail();

                    $product_result= new TT_DATA_PROD_RESULT();
                    $product_result->DTM_TIM_PROD_RESULT = Carbon::now()->format('Y-m-d H:i:s.0000000');
                    $product_result->CHR_COD_COMPANY = 'J922';
                    $product_result->CHR_COD_KJ = 'JE';
                    $product_result->CHR_COD_KOFU = 'AS';
                    $product_result->CHR_COD_LINE = substr($line->line,2,3);
                    $product_result->CHR_COD_HNMK = $master_part->part_number;
                    $product_result->DEC_SUR_RESULT = $qty_prod_result;
                    $product_result->DEC_SUR_THROWOUT = 0;
                    $product_result->DEC_TIM_CT = $master_part->ct;
                    $product_result->DTM_TIM_PROD_RESULT_UTC = Carbon::now('UTC')->format('Y-m-d H:i:s.0000000');
                    $product_result->DTM_TIM_SERVER_UTC = Carbon::now('UTC')->format('Y-m-d H:i:s.0000000');
                    $product_result->INT_KEY_REFERENCE=1;
                    $product_result->CHR_INF_SAKUSEI_USER = 'SYSTEM';
                    $product_result->CHR_NGP_SAKUSEI = Carbon::now()->format('Ymd');
                    $product_result->CHR_TIM_SAKUSEI = Carbon::now()->format('Hi');
                    $product_result->CHR_INF_KOSIN_USER = NULL;
                    $product_result->CHR_NGP_KOSIN = NULL;
                    $product_result->CHR_TIM_KOSIN = NULL;
                    $product_result->timestamps = false;
                    $product_result->save();
                    

                    $line->buffer_alcolla=$line->actual_qty;
                    $line->save();

                    DB::commit();
                }catch(\Exception $ex){
                    echo $ex->getMessage();
                    DB::rollBack();
                }
                
            }elseif($line->actual_qty < $line->buffer_alcolla){
                $line->buffer_alcolla=0;
                $line->save();
            }
            else{
                // Do nothing if same
            }
        }
    }
}
