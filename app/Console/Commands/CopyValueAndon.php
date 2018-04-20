<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Avicenna\avi_andon;
use App\Models\Avicenna\avi_running_model;

class CopyValueAndon extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'CopyValueAndon:CopyAndon';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Copy isi andon';

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
        $andon            = avi_andon::select('line', 'value_reg')
                            ->get();    
        $update           = avi_running_model::whereIn('line_number' , $andon->line );
        $update->quantity =  $andon->value_reg;
        $update->save();
        return $andon;


        //dev-1.`0.0 : By Handika, Copy data dari avi_andon ke avi_running_model
        // $andon  = avi_andon::select('line', 'value_reg')->where('line' , '=' , 'AS600')
        //         ->first();
        // $update = avi_running_model::where('line_number' , '=' , 'AS600' )->first();
        // $qty = $andon->value_reg - $update->buffer ;
        // $update->quantity =  $qty;
        // $update->save();

        // $andon  = avi_andon::select('line', 'value_reg')->where('line' , '=' , 'AS731')
        //         ->first();
        // $update = avi_running_model::where('line_number' , '=' , 'AS731' )->first();
        // $qty = $andon->value_reg - $update->buffer ;
        // $update->quantity =  $qty;
        // $update->save();
    }
}
