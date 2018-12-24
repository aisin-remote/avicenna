<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTimestampAviAndonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('avi_andons', function (Blueprint $table) {
            $table->timestamps();
        });

        Schema::table('avi_andon_details', function (Blueprint $table) {
            $table->timestamp('created_at')->after('value_reg');
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
            $table->dropColumn('created_at');
            $table->dropColumn('updated_at');
        });

        Schema::table('avi_andon_details', function (Blueprint $table) {
            $table->dropColumn('created_at');
        });
    }
}
