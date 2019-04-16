<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMgrCcColumnOnAviAndonStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('avi_andon_status', function (Blueprint $table) {
            $table->string('cc_spv')->after('pic_spv');
            $table->string('cc_mgr')->after('pic_mgr');
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
            $table->dropColumn('cc_spv');
            $table->dropColumn('cc_mgr');
        });
    }
}
