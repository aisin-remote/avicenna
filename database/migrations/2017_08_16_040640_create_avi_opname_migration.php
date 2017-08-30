<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAviOpnameMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //20170816, Alliq, Create AviOpname Table
        Schema::create('avi_opname', function (Blueprint $table) {
            $table->increments('id');
            $table->string('part_number', 50);
            $table->date('opname_date');
            $table->integer('opname_quantity');
            $table->integer('opname_user_id');
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
        //20170816, Alliq, Drop Table AviOpname
        Schema::dropIfExists('avi_opname');
    }
}
