<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddModelColumnAviAndonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::table('avi_andons', function (Blueprint $table) {
            $table->string('back_number',10)->after('line');
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
            $table->dropColumn('back_number');
        });
    }
}
