<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAviMutationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('avi_mutations', function (Blueprint $table) {
            $table->increments('id');
            $table->date('mutation_date');
            $table->string('mutation_code', 3);             // dev-1.0, Ferry, 20170906, Kode Mutasi
            $table->string('part_number', 50);
            $table->string('part_number_customer', 50)->nullable();     // dev-1.0, Ferry, 20170911
            $table->string('store_location', 4);            // dev-1.0, Ferry, 20170830
            $table->double('quantity', 15, 2);              // dev-1.0, Ferry, 20170907, Jika pecahan
            $table->string('uom_code', 10);                // dev-1.0, Ferry, 20170907, Unit of Measure
            $table->integer('serial_no')->nullable();
            $table->string('loading_list', 50)->nullable();
            $table->string('delivery', 50)->nullable();
            $table->string('customer', 50)->nullable();
            $table->string('part_name', 150)->nullable();   // dev-1.0, Ferry, 20170830
            $table->string('npk', 10);
            $table->boolean('flag_confirm')->default(false);    // dev-1.0, Ferry, 20170907, Boolean lebih indah
            $table->string('npk_edited', 10)->nullable();
            $table->string('info_edited')->nullable();      // dev-1.0, Ferry, 20170907, Info Original sebelum edit, tiap info di separasi "||"
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
        Schema::dropIfExists('avi_mutations');
    }
}
