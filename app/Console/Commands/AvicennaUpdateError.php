<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Avicenna\avi_andon_status;
use Carbon\Carbon;

class AvicennaUpdateError extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'avicenna:updateerror';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update date time error at avi andon status';

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
        $lines = avi_andon_status::select('*')->get();
        foreach ($lines as $line) {
            $date = Carbon::now();
            $data = avi_andon_status::where('line', $line->line)->first();
            if ($data->status == 1 || $data->status == 0 || $data->status == 5 ) {
                $data->error_at = NULL;
                $data->save();

            }elseif($data->status == 2 && $data->error_at == NULL ){
                $data->error_at = $date;
                $data->save();

            }elseif($data->status == 3 && $data->error_at == NULL ){
                $data->error_at = $date;
                $data->save();

            }elseif($data->status == 4 && $data->error_at == NULL ){
                $data->error_at = $date;
                $data->save();

            }
        }
    }
}
