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
            $table->boolean('flag_spv')->after('pic_spv');
            $table->boolean('flag_mgr')->after('pic_mgr');
            $table->boolean('flag_gm')->after('pic_gm');
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
            $table->dropColumn('flag_spv');
            $table->dropColumn('flag_mgr');
            $table->dropColumn('flag_gm');
        });
    }
}
