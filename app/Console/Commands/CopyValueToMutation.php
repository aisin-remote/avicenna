<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Avicenna\avi_running_model;
use App\Models\Avicenna\avi_mutations;

class CopyValueToMutation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'CopyValueToMutation:CopyToMutation';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Copy value qty running model to mutation';

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
        //dev-1.0.0 : By Handika, Copy data dari avi_running_model ke avi_mutation
        $lines = avi_running_model::select('line_number')->get();
        foreach ($lines as $line) {
            $running          = avi_running_model::select('back_number','quantity','id_handled')->where('line_number' , '=' , $line->line_number)
                                ->first();
            $update           = avi_mutations::where('id' ,'=' , $running->id_mutation )->first();
            $update->quantity = $running->running_qty;
            $update->save();
        }
    }
}
