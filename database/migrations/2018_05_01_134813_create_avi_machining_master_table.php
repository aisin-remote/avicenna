<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAviMachiningMasterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // By ALQ, 20180501
        Schema::create('avi_machining_master', function (Blueprint $table) {
            $table->increments('id');
            $table->string('line_no', 25);
            $table->string('machine_name', 25);
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
        // By ALQ, 20180501
        Schema::dropIfExists('avi_machining_master');   
    }
}
