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
        //dev-1.`0.0 : By Handika, Copy data dari avi_andon ke avi_running_model
        $lines = avi_andon::select('line')->get();
        foreach ($lines as $line) {
            $andon  = avi_andon::select('line', 'actual_qty')->where('line' , '=' , $line->line)
                    ->first();
            $update = avi_running_model::where('line_number' , '=' , $line->line )->first();
            $qty = $andon->actual_qty - $update->cumulative_qty ;
            $update->running_qty = $qty;
            $update->save();
        }
    }
}
