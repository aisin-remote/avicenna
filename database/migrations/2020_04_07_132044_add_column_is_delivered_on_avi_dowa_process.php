<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnIsDeliveredOnAviDowaProcess extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('avi_dowa_process', function (Blueprint $table) {
            $table->char('is_delivered', 1)->after('npk_torimetron')->nullable()->comment('1 = delivered, 0 = not delivered');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('avi_dowa_process', function (Blueprint $table) {
            $table->dropColumn('is_delivered');
        });
    }
}
