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
        $now        = \Carbon::now()->format('Y-m-d');
        $detail     = avi_andon_detail::where('updated_at','!=','NULL')->where('updated_at', $now)->orderBy('updated_at', 'DESC')->first();
        $andon      = avi_andon::where('line', $detail->line)->first();

        if (is_null($detail)) {
           $Mutation        = new avi_mutations;
        }
    }
}
