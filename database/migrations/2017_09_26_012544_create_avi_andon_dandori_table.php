<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAviAndonDandoriTable extends Migration
{
    
    public function up()
    {
        Schema::create('avi_andon_dandori', function (Blueprint $table) {
         $table->increments('id');
         $table->string('ip_address',16);
         $table->string('line',40);
         $table->string('back_no',4);
         $table->boolean('is_dandori');
         $table->timestamps();
     });
    }

    
    public function down()
    {
        Schema::dropIfExists('avi_andon_dandori');
    }
}
