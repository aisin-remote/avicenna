<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFlagEmailColumnOnAviAndonStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('avi_andon_status', function (Blueprint $table) {
            $table->boolean('flag_email')->after('pic_gm');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('avi_andon_status', function (Blueprint $table) {
            $table->dropColumn('flag_email');
        });
    }
}
