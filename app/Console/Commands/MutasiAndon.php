<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use \Carbon;
use \DB;
use App\Models\Avicenna\avi_andon_detail;
use App\Models\Avicenna\avi_andon;
use App\Models\Avicenna\avi_mutations;

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
        $now        = \Carbon\Carbon::now()->format('Y-m-d');
        $detail     = avi_andon_detail::where('updated_at','!=','NULL')->where('updated_at', $now)->orderBy('updated_at', 'DESC');
        $andon      = avi_andon::where('line', $detail->line)->first();

        if (is_null($detail)) {
         $mutation                    = new avi_mutations();
         $mutation->mutation_date     = $now;
         $mutation->mutation_code     = '133';
         $mutation->part_number       = $detail->back_no;
         $mutation->back_number       = $detail->back_no;
         $mutation->store_location    = 'FG01';
         $mutation->quantity          = $andon->actual_qty;
         $mutation->uom_code          = 'PCS';
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
            if ($detail->word == $andon->word ) {
                $mutation                    = new avi_mutations();
                $mutation->mutation_date     = $now;
                $mutation->mutation_code     = '133';
                $mutation->part_number       = $detail->back_no;
                $mutation->back_number       = $detail->back_no;
                $mutation->store_location    = 'FG01';
                $mutation->quantity          = $andon->actual_qty - $andon->buffer;
                $mutation->uom_code          = 'PCS';
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
                $mutation                    = new avi_mutations();
                $mutation->mutation_date     = $now;
                $mutation->mutation_code     = '133';
                $mutation->part_number       = $detail->back_no;
                $mutation->store_location    = 'FG01';
                $mutation->quantity          = $detail->value_reg - $detail->buffer;
                $mutation->uom_code          = 'PCS';
                $mutation->npk               = '000000';
                $mutation->flag_confirm      = 0;
                $mutation->save();

                $andon->buffer               = $andon->actual_qty;
                $andon->save();

                $back_no                     = avi_andon_detail::select('back_no')->where('word', $andon->word)->first();

                $mutation2                    = new avi_mutations();
                $mutation2->mutation_date     = $now;
                $mutation2->mutation_code     = '133';
                $mutation2->part_number       = $detail->back_no;
                $mutation2->back_number       = $back_no->back_no;
                $mutation2->store_location    = 'FG01';
                $mutation2->quantity          = $detail->value_reg;
                $mutation2->uom_code          = 'PCS';
                $mutation2->npk               = '000000';
                $mutation2->flag_confirm      = 0;
                $mutation2->save();

                $dtl                         = avi_andon_detail::where('word', $andon->word)->first();
                $dtl->updated_at             = \Carbon\Carbon::now();
                $dtl->buffer                 = $dtl->value_reg;
                $dtl->save();

            }

        }
    }
}
