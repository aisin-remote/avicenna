<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use \Carbon\Carbon;
use \DB;
use App\Models\Avicenna\avi_andon;
use App\Models\Avicenna\avi_parts;
use App\Models\Avicenna\avi_part_production;
use App\Models\Avicenna\avi_mutations;

class AvicennaAndonMutation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'avicenna:andonMutation';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Save to Avi_Mutation For GR Andon IN';

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
        /* Define all line */
        $lines = avi_andon::select('line','actual_qty','buffer_mutation','back_number')
                        ->where('back_number','<>','')
                        ->get();
        
        /* Define Mutation Date for posting */
        $mutation_date=Carbon::now()->format('Y-m-d');
        if (Carbon::now()->hour < 6){
            $mutation_date=Carbon::yesterday()->format('Y-m-d');
        }

        /* Looping to Save Mutation */
        foreach ($lines as $line) {
            if($line->actual_qty > $line->buffer_mutation){
                
                /* Find Part Number From Avi Parts Production */
                $part_prd=avi_part_production::where('back_number',$line->back_number)->first();
                $part=null;
                if ($part_prd){
                    
                    /* Find Part Name From Avi Part*/
                    $part=avi_parts::where('part_number',$part_prd->part_number)->first();
                }

                /* Calculate Quantity */
                $qty_prod_result=$line->actual_qty-$line->buffer_mutation;

                try {

                    /* Begin DB Transaction */
                    DB::beginTransaction();

                    /* Insert Mutation */
                    $mutation = new avi_mutations();
                    $mutation->mutation_date     = $mutation_date;
                    $mutation->mutation_code     = '133';
                    $mutation->part_number       = isset($part_prd->part_number) ? $part_prd->part_number : 'Part Number is Not Found';
                    $mutation->back_number       = $line->back_number;
                    $mutation->part_name         = isset($part->part_name) ? $part->part_name : 'Part Name is Not Found';
                    $mutation->store_location    = 'FG01';
                    $mutation->quantity          = $qty_prod_result;
                    $mutation->uom_code          = 'PCS';
                    $mutation->npk               = 'SYSTEM';
                    $mutation->flag_confirm      = 0;
                    $mutation->save();

                    /* Update Buffer Mutasi*/
                    $line->buffer_mutation=$line->actual_qty;
                    $line->save();

                    /* Commit Transaction */
                    DB::commit();

                } catch (Exception $e) {
                    /* Write the error message */
                    echo  $e->getMessage();

                    /* Roll Back the Transaction if error detected */
                    DB::rollBack();
                }
            }elseif($line->actual_qty < $line->buffer_mutation){
                
                /* Update Buffer Mutasi menjadi 0*/
                $line->buffer_mutation=0;
                $line->save();
            }else{

                /* Do Nothing */

            }
        }

    }
}
