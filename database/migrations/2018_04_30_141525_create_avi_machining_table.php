<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAviMachiningTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('avi_machining', function (Blueprint $table) {
            $table->increments('id');
            $table->string('line_no', 25);
            $table->string('machine_no', 25);
            $table->string('tools_no', 25);
            $table->integer('std_life_time');
            $table->integer('actual_life_time');
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
     Schema::dropIfExists('avi_machining');   
    }
}
