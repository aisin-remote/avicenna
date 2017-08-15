<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddQuantityAllPartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename('m_parts', 'avi_parts'); //rename parts
        Schema::rename('inventory_mutations', 'avi_mutations'); //rename mutations
        Schema::rename('m_customers', 'avi_customers'); //rename mutations

        Schema::table('avi_parts', function (Blueprint $table) {

            $table->integer('quantity')->after('part_number');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('avi_parts', function (Blueprint $table) {
            //
        });
    }
}
