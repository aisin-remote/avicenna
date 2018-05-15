<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditColumnAviAndons extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('avi_andons', function (Blueprint $table) {
            $table->renameColumn('reg_address','target');
            $table->dropColumn('name_reg');
            $table->renameColumn('value_reg','target_qty');
            $table->integer('actual_qty')->nullable();
            $table->integer('balance')->nullable();
            $table->integer('achive')->nullable();
            $table->integer('dandori')->nullable();
            $table->integer('loss_time_qa')->nullable();
            $table->integer('loss_time_parts')->nullable();
            $table->integer('loss_time_mc')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('avi_andons');
    }
}
