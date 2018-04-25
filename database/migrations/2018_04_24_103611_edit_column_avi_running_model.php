<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditColumnAviRunningModel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('avi_running_model', function (Blueprint $table) {
            $table->renameColumn('quantity', 'running_qty');
            $table->renameColumn('buffer', 'cumulative_qty');
            $table->renameColumn('id_handled', 'id_mutation');
            $table->dropColumn('ip_address');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('avi_running_model', function (Blueprint $table) {
            $table->renameColumn('running_qty', 'quantity');
            $table->renameColumn('cumulative_qty', 'buffer');
            $table->renameColumn('id_mutation', 'id_handled');
            $table->string('ip_address','20');
        });
    }
}
