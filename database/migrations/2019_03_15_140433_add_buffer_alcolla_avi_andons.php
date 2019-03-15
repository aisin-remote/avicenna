<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBufferAlcollaAviAndons extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('avi_andons', function (Blueprint $table) {
            $table->integer('buffer_alcolla')->after('buffer_mutation');
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
            $table->dropColumn('buffer_alcolla');
        });
    }
}
