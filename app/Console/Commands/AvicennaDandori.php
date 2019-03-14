<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use \DB;
use App\Models\Avicenna\avi_andon;

class AvicennaDandori extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'avicenna:dandori';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'For handling Dandori Event (change Part Number, And then Create Buffer)';

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
         $lines = avi_andon::select('line as prod_line','actual_qty','buffer','back_number')
                        ->where('line','AS600')
                        ->orWhere('line','AS523')
                        ->get();
        foreach ($lines as $line) {
            # code...
        }
    }
}
