<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAviRunningHoursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('avi_running_hours', function (Blueprint $table) {
            $table->increments('id');
            $table->string('line', 10);
            $table->string('back_number', 10)->nullable();
            $table->string('part_number', 20);
            $table->integer('ct');
            $table->integer('qty_1')->nullable();
            $table->integer('time_1')->nullable();
            $table->integer('qty_2')->nullable();
            $table->integer('time_2')->nullable();
            $table->integer('qty_3')->nullable();
            $table->integer('time_3')->nullable();
            $table->integer('qty_4')->nullable();
            $table->integer('time_4')->nullable();
            $table->integer('qty_5')->nullable();
            $table->integer('time_5')->nullable();
            $table->integer('qty_6')->nullable();
            $table->integer('time_6')->nullable();
            $table->integer('qty_7')->nullable();
            $table->integer('time_7')->nullable();
            $table->integer('qty_8')->nullable();
            $table->integer('time_8')->nullable();
            $table->integer('qty_9')->nullable();
            $table->integer('time_9')->nullable();
            $table->integer('qty_10')->nullable();
            $table->integer('time_10')->nullable();
            $table->integer('qty_11')->nullable();
            $table->integer('time_11')->nullable();
            $table->integer('qty_12')->nullable();
            $table->integer('time_12')->nullable();
            $table->integer('qty_13')->nullable();
            $table->integer('time_13')->nullable();
            $table->integer('qty_14')->nullable();
            $table->integer('time_14')->nullable();
            $table->integer('qty_15')->nullable();
            $table->integer('time_15')->nullable();
            $table->integer('qty_16')->nullable();
            $table->integer('time_16')->nullable();
            $table->integer('qty_17')->nullable();
            $table->integer('time_17')->nullable();
            $table->integer('qty_18')->nullable();
            $table->integer('time_18')->nullable();
            $table->integer('qty_19')->nullable();
            $table->integer('time_19')->nullable();
            $table->integer('qty_20')->nullable();
            $table->integer('time_20')->nullable();
            $table->integer('qty_21')->nullable();
            $table->integer('time_21')->nullable();
            $table->integer('qty_22')->nullable();
            $table->integer('time_22')->nullable();
            $table->integer('qty_23')->nullable();
            $table->integer('time_23')->nullable();
            $table->integer('qty_24')->nullable();
            $table->integer('time_24')->nullable();
            $table->date('date')->nullable();
            $table->integer('buffer');
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
        Schema::dropIfExists('avi_running_hours');
    }
}
