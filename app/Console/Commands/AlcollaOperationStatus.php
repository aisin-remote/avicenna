<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use \Carbon\Carbon;
use \DB;
use App\Models\Avicenna\avi_andon_status;
use App\Models\Iot\TT_DATA_OPERATION_STATUS;


class AlcollaOperationStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'alcolla:operationStatus';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mengisi table Al Colla Operation Status';

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

       echo "tess alcolla";
    }
}
