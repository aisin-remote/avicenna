<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

// dev-1.0, Ferry, 20170816
// Perkenalkan AISYA ==> Aisin Integrated System Application yang merupakan Evolusi dari AISIN BISA

class CreateAisAppsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ais_apps', function (Blueprint $table) {
            $table->increments('id');
            $table->string('apps_tcode', 4);
            $table->string('apps_sname', 10);
            $table->string('apps_fname', 50);
            $table->string('apps_icon_code', 50);
            $table->string('apps_icon_path');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ais_apps');
    }
}
