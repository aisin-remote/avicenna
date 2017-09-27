<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAviRunningModelTable extends Migration
{

        // By Alliq, 20170908, Untuk menyimpan model yang saat ini aktif digunakan dalam andon
         public function up()
         {
          if(!Schema::hasTable('avi_running_model')){
            Schema::create('avi_running_model', function (Blueprint $table) {
              $table->increments('id');
              $table->string('ip_address','20');
              $table->string('back_number','20');
              $table->string('part_number','30');
              $table->timestamp('dandori_date');
              $table->timestamps();
            });
          }
        }



        public function down()
        {
          Schema::dropIfExists('avi_running_model');
        }
}
