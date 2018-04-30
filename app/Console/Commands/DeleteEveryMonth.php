<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use \Carbon;
use \DB;

class DeleteEveryMonth extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'DeleteEveryMonth:DeleteMutations';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Menghapus mutasi pada tabel avi_mutations pada akhir bulan ';

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
        $date = \Carbon\Carbon::now()->startofMonth()->subMonth()->endOfMonth()->format('Y-m-d');
        DB::table('avi_mutations')->where('mutation_date','<=', $date)->delete();
    }
}