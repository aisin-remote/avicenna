<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Avicenna\avi_running_hours;
use App\Models\Avicenna\avi_running_model;
use App\Models\Avicenna\avi_part_production;
use Carbon\Carbon;


class CopyAndonHourly extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'CopyAndonHourly:CopyAndon';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Menyalin data qty per jam dari avi_running_model ke avi_running_hours';

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
        //dev-1.0.0 : By Handika, mengambil data produksi per jam dan di tempel pada tabel avi_running_hours
        $models             = avi_running_model::select('line_number','back_number','part_number','running_qty')
                            ->where('line_number','AS600')->first(); // ambil data dari avi_running_model
        $ct                 = avi_part_production::select('ct')->where('part_number','439430-12511')->first(); // ambil data cicle time dat avi_part_productions
        $mutation_date      = Carbon::now(); // tanggal pengakuan aisin per shift
            if($mutation_date->hour <= 5){ 
                $mutation_date=Carbon::yesterday();
            }
        $andon_hours        = avi_running_hours::select('part_number','date')
                            ->where('line','AS600')->first(); // ambil data part dan tanggal dari avi running hours
        $jam_carbon         = Carbon::now(); //mengambil tanggal dan jam sekarang
        $jam                = $jam_carbon->hour; // mengambil format jam saja
        $qty                = 'qty_'.$jam; // membuat variable untuk mengetahui table qty yang akan disi
        $time               = 'time_'.$jam; // membuat variable untuk mengetahui table time yang akan disi

        if ( ! $andon_hours ) {
            $hours              = new avi_running_hours ; // select semua data dari avi_running_hours
            $hours->line        = $models->line_number; // isi data line avi_running_hours dari avi_running_model
            $hours->back_number = $models->back_number; // isi data back_number avi_running_hours dari avi_running_model
            $hours->part_number = $models->part_number; // isi data part_number avi_running_hours dari avi_running_model
            $hours->ct          = $ct->ct; // isi data ct avi_running_hours dari avi_part_production
            $hours->{$qty}      = $models->running_qty;  //mengisi qty
            $hours->{$time}     = $ct->ct * $models->running_qty; //mengisi time
            $hours->buffer      = 0 ; //mengisi buffer
            $hours->date        = $mutation_date; //mengisi date
            $hours->save(); // save ke database
        }else{
            $hours              = avi_running_hours::all()->where('part_number', '439430-13340' )
                                ->first();
                if ( ! $hours->{$qty}) {
                    $hours->{$qty}      = $models->running_qty-$hours->buffer;
                    $hours->{$time}     = $ct->ct * $hours->{$qty};
                }else{
                    $a              = $jam-1;
                    $qty2           = 'qty_'.$a;
                    $buffer         = $hours->buffer + $hours->{$qty2};
                    $hours->{$qty}  = $models->running_qty - $buffer ;
                    $hours->buffer  = $buffer;
                    $hours->{$time} = $ct->ct * $hours->{$qty} ;
                }
                $hours->save(); // save ke database
        }
    }
}
