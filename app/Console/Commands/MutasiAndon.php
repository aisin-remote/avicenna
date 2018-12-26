<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use \Carbon;
use \DB;
use App\Models\Avicenna\avi_andon_detail;
use App\Models\Avicenna\avi_andon;
use App\Models\Avicenna\avi_mutations;
use App\Models\Avicenna\avi_part_production;

class MutasiAndon extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Andon:Mutation';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make mutation from andon';

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
        $now        = \Carbon\Carbon::now();
        if($now->hour <= 5){ 
            $now = \Carbon\Carbon::yesterday()->format('Y-m-d');
        }
        $detail     = avi_andon_detail::whereRaw('DATE(updated_at)', $now)->orderBy('updated_at', 'DESC')->first();

        $andon      = avi_andon::where('line','AS600')->first();
        $part_number = avi_part_production::select('*')
        ->join('avi_andon_details','avi_part_productions.back_number', '=', 'avi_andon_details.back_no')
        ->where('avi_andon_details.word', $andon->word)
        ->first();

        // //reset buffer
        $now1       = \Carbon\Carbon::now()->format('Y-m-d');
        $start1     = \Carbon\Carbon::createFromTimestamp(strtotime($now1 . '06:00:00'));
        $end1       = \Carbon\Carbon::createFromTimestamp(strtotime($now1 . '06:05:00'));
        $start2     = \Carbon\Carbon::createFromTimestamp(strtotime($now1 . '14:10:00'));
        $end2       = \Carbon\Carbon::createFromTimestamp(strtotime($now1 . '14:15:00'));
        $start3     = \Carbon\Carbon::createFromTimestamp(strtotime($now1 . '22:10:00'));
        $end3       = \Carbon\Carbon::createFromTimestamp(strtotime($now1 . '22:15:00'));

        if ($start1 <= $now && $now <= $end1 || $start2 <= $now && $now <= $end2 || $start3 <= $now && $now <= $end3 ) {
            $detail = DB::table('avi_andon_details')->where('line', '=', 'AS600')->update(array('buffer' => 0, 'updated_at' => NULL));
            $andon  = DB::table('avi_andons')->where('line', '=', 'AS600')->update(array('buffer' => 0, 'updated_at' => NULL));
            echo "reset";
            return;
        }

        try {
            DB::beginTransaction();

            if (!$detail) { //element kosong
                echo "kondisi satu ";

                $mutation                    = new avi_mutations();
                $mutation->mutation_date     = $now;
                $mutation->mutation_code     = '133';
                $mutation->part_number       = $part_number->part_number;
                $mutation->back_number       = $part_number->back_number;
                $mutation->store_location    = 'FG01';
                $mutation->quantity          = $andon->actual_qty;
                if ($mutation->quantity == 0) {
                    DB::rollBack();
                    return "qty 0";
                }
                $mutation->uom_code          = 'PCS';
                $mutation->npk               = '000000';
                $mutation->flag_confirm      = 0;
                $mutation->save();

                $andon->buffer               = $andon->actual_qty;
                $andon->save();

                $dtl                         = avi_andon_detail::where('word', $andon->word)->first();
                $dtl->updated_at             = \Carbon\Carbon::now();
                $dtl->buffer                 = $dtl->value_reg;
                $dtl->save();
            }
            else{ //ketemu back no di detail
                echo "kondisi dua ";

                if ($detail->word == $andon->word ) {
                    echo "kondisi sama";

                    $mutation                    = new avi_mutations();
                    $mutation->mutation_date     = $now;
                    $mutation->mutation_code     = '133';
                    $mutation->part_number       = $part_number->part_number;
                    $mutation->back_number       = $part_number->back_number;
                    $mutation->store_location    = 'FG01';
                    $mutation->quantity          = $andon->actual_qty - $andon->buffer;
                    if ($mutation->quantity == 0) {
                        DB::rollBack();
                        return "qty 0";
                    }
                    $mutation->uom_code          = 'PCS';
                    $mutation->npk               = '000000';
                    $mutation->flag_confirm      = 0;
                    $mutation->save();

                    $andon->buffer               = $andon->actual_qty;
                    $andon->save();

                    $dtl                         = avi_andon_detail::where('word', $andon->word)->first();
                    $dtl->updated_at             = \Carbon\Carbon::now();
                    $dtl->buffer                 = $dtl->value_reg;
                    $dtl->save();


                }
                else{
                    echo "kondisi beda";
                    $part_number1 = avi_part_production::select('*')
                    ->join('avi_andon_details','avi_part_productions.back_number', '=', 'avi_andon_details.back_no')
                    ->where('avi_andon_details.word', $detail->word)
                    ->first();

                    $mutation                    = new avi_mutations();
                    $mutation->mutation_date     = $now;
                    $mutation->mutation_code     = '133';
                    $mutation->part_number       = $part_number1->part_number;
                    $mutation->back_number       = $part_number1->back_number;
                    $mutation->store_location    = 'FG01';
                    $mutation->quantity          = $detail->value_reg - $detail->buffer;
                    $mutation->uom_code          = 'PCS';
                    $mutation->npk               = '000000';
                    $mutation->flag_confirm      = 0;
                    $mutation->save();

                    $dtl                         = avi_andon_detail::where('word', $detail->word)->first();
                    $dtl->updated_at             = \Carbon\Carbon::now();
                    $dtl->buffer                 = $dtl->value_reg;
                    $dtl->save();

                    $andon->buffer               = $andon->actual_qty;
                    $andon->save();


                    $back_no                     = avi_andon_detail::where('word', $andon->word)->first();

                    $mutation2                    = new avi_mutations();
                    $mutation2->mutation_date     = $now;
                    $mutation2->mutation_code     = '133';
                    $mutation2->part_number       = $part_number->part_number;
                    $mutation2->back_number       = $part_number->back_number;
                    $mutation2->store_location    = 'FG01';
                    $mutation2->quantity          = $back_no->value_reg - $back_no->buffer ;
                    $mutation2->uom_code          = 'PCS';
                    $mutation2->npk               = '000000';
                    $mutation2->flag_confirm      = 0;
                    $mutation2->save();

                    $dtl                         = avi_andon_detail::where('word', $andon->word)->first();
                    $dtl->updated_at             = \Carbon\Carbon::now()->addSecond();
                    $dtl->buffer                 = $dtl->value_reg;
                    $dtl->save();

                }

            }

            DB::commit();
            
        } catch (\Exception $e) {
            echo $e->getMessage();
            DB::rollBack();
        }
        
    }
}
