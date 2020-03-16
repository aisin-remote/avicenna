<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAviDowaProcessTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('avi_dowa_process', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code')->unique();
            $table->string('kbn_int_casting', 4)->nullable()->comment="kanban internal casting";
            $table->string('kbn_supply')->nullable();
            $table->string('kbn_fg')->nullable();
            $table->dateTime('scan_delivery_dowa_at')->nullable();
            $table->string('npk_delivery_dowa')->nullable();
            $table->dateTime('scan_torimetron_at')->nullable();
            $table->string('npk_torimetron')->nullable();
            $table->string('status',1)->nullable()->comment="1=OK, 0=NG";
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
        Schema::drop('avi_dowa_process');
    }
}
