<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\TraceListController;

class EmailTraceability extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'EmailTraceability';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $jam_7 = \Carbon\Carbon::now();
        if ($jam_7->hour == 8) {
            $tracepartreport = new TraceListController;
            return $tracepartreport->tracepartreport();
        }
        
    }

}
