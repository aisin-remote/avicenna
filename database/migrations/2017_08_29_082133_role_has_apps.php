<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RoleHasApps extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // dev-1.0, Ferry, 20170829, relasi role dengan otorisasi aplikasi
        Schema::create('role_has_apps', function (Blueprint $table) {
            $table->integer('role_id')->unsigned();
            $table->integer('apps_id')->unsigned();

            $table->foreign('role_id')
                ->references('id')
                ->on('roles')
                ->onDelete('cascade');

            $table->foreign('apps_id')
                ->references('id')
                ->on('ais_apps')
                ->onDelete('cascade');

            $table->primary(['role_id', 'apps_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // dev-1.0, Ferry, 20170829, drop relasi role dengan otorisasi aplikasi
        Schema::drop('role_has_apps');
    }
}
