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
      $running_models     = avi_running_model::select('line_number','part_number')->get();

      foreach ($running_models as $model) {
              $carbon             = Carbon::now(); //mengambil tanggal dan jam sekarang
              $jam                = $carbon->hour; // mengambil format jam saja

              if ($jam == '0') {
                $jam = '24';
              }

              $qty                = 'qty_'.$jam; // membuat variable untuk mengetahui table qty yang akan disi
              $time               = 'time_'.$jam; // membuat variable untuk mengetahui table time yang akan disi
              $models             = avi_running_model::select('line_number','back_number','part_number','running_qty')
                                  ->where('line_number',$model->line_number)->first(); // ambil data dari avi_running_model
              $ct                 = avi_part_production::select('ct')->where('part_number',$model->part_number)->orderBy('id','desc')->first(); // ambil data cicle time dat avi_part_productions
              if(is_null($ct)){ // jika gak nemu cycle time makan di buat default ct = 1
                $ct       = new avi_part_production ;
                $ct->ct   = 1 ;
              }elseif (is_null($ct->ct)) {
                $ct       = new avi_part_production ;
                $ct->ct   = 1 ;
              }
              
              $mutation_date      = Carbon::now(); // tanggal pengakuan aisin per shift
              if($mutation_date->hour <= 5){ 
                  $mutation_date=Carbon::yesterday();
              }

              $andon_hours        = avi_running_hours::select('part_number','date')->where(function($query) use ($model,$mutation_date) {
                                  $query->where('part_number', $model->part_number)

                                        ->where('date', $mutation_date->format('Y-m-d'));})->orderBy('id','desc')->first(); // ambil data part dan tanggal dari avi running hours
              if ( ! $andon_hours ) { // jika tidak ada pencatatan hari ini
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
              }
              else{ // jika sudah ada pencatatan hari ini

                  $hours              = avi_running_hours::where(function($query) use ($model,$mutation_date) {
                                      $query->where('part_number', $model->part_number)
                                        ->where('date', $mutation_date->format('Y-m-d'));})->orderBy('id','desc')->first(); // ambil data dari avi running hours yang sesuai part
                  $a              = $jam-1; // variabel jam sebelumnya
                          if ($a == 0) {
                            $a = 24 ;
                          }
                          $qty2           = 'qty_'.$a; // variabel qty jam kemarin
                          $buffer         = $hours->buffer;
                      if ( is_null($hours->{$qty})) { // jika kolom qty pada jam sekarang null atau kosong
                          $a              = $jam-1; // variabel jam sebelumnya
                          if ($a == 0) {
                            $a = 24 ;
                          }
                          $qty2           = 'qty_'.$a; // variabel qty jam kemarin
                          $buffer         = $hours->buffer;
                          if ( $buffer <= 0) { // jika buffer kosong berarti set model pada awal shift
                            if ($models->running_qty < $hours->{$qty2}) {
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
                              $hours->{$qty}      = $models->running_qty-$hours->{$qty2}; // set qty jam sekarang dengan qty running di kurangi buffer
                              $hours->{$time}     = $ct->ct * $hours->{$qty}; // set time pada awal pergantian jam
                              $hours->buffer      = $hours->{$qty2};
                            }
                          }else{ // dandori pertama dan selanjutnya pada hari ini
                            if ($models->running_qty < $hours->{$qty2}) {
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
                              $buffer             = $hours->buffer + $hours->{$qty2}; //mengisi buffer dengan menambahkan dengan qty jam sebelumnya
                              $hours->{$qty}      = $models->running_qty-$buffer; // set qty jam sekarang dengan qty running di kurangi buffer
                              $hours->{$time}     = $ct->ct * $hours->{$qty}; // set time pada awal pergantian jam
                              $hours->buffer      = $buffer; // mengisi buffer
                            }
                          }
                      }else{ // jika jam dan tanggal hari ini sudah ada pencatatan dan tidak null
                        if ($models->running_qty < $hours->{$qty2}) {
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
                          $buffer         = $hours->buffer; //mengisi buffer dengan menambahkan dengan qty jam sebelumnya
                          $hours->{$qty}  = $models->running_qty - $buffer ; // mengisi qty dengan running model - buffer
                          $hours->{$time} = $ct->ct * $hours->{$qty} ; // time ct dikali qty 
                        }
                      }
                      $hours->save(); // save ke database
              }
      }
    }

}
