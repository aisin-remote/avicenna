<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAviAndonStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('avi_andon_status', function (Blueprint $table) {
            $table->increments('id');
            $table->string('line');
            $table->integer('status');
            $table->string('pic_ldr');
            $table->string('pic_spv');
            $table->string('pic_mgr');
            $table->string('pic_gm');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('avi_trace_status');
    }
}
