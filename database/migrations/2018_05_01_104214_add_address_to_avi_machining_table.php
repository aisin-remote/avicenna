<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAddressToAviMachiningTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
          Schema::table('avi_machining', function (Blueprint $table) {
            $table->string('reg_address','6')->after('tools_no')->unique();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('avi_machining', function (Blueprint $table) {
            // dev-1.0, Alliq, 20180501
            $table->dropColumn('reg_address');
        });   
    }
}
