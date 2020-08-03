<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAviFurnaceStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('avi_furnace_status', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('line', 10);
            $table->string('furnace', 30);
            $table->char('pic', 6)->index();
            $table->tinyInteger('value')->default(0);
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
        Schema::drop('avi_furnace_status');
    }
}
