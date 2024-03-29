<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AdsBufferAviAndonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::table('avi_andons', function (Blueprint $table) {
            $table->integer('buffer')->after('loss_time_mc');
            $table->string('word')->after('back_number');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('avi_andons', function (Blueprint $table) {
            $table->dropColumn('buffer');
            $table->dropColumn('word');
        });
    }
}
