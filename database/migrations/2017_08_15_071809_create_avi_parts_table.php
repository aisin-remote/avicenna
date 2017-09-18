<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAviPartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('avi_parts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('customer_id')->nullable();
            $table->string('supplier_id')->nullable();
            $table->string('back_number')->nullable();
            $table->string('part_number');
            $table->string('part_number_nostrip');
            $table->string('part_number_customer')->nullable(); //20170818, penambahan part_number_cust
            $table->string('part_name', 150)->nullable();           // dev-1.0, Ferry, 20170830
            $table->string('product_group')->nullable();            // dev-1.0, Ferry, 20170830, Grouping product
            $table->string('product_line')->nullable();             // dev-1.0, Ferry, 20170830, Grouping product
            $table->float('quantity_box');
            $table->float('min_stock')->nullable(); //20170509, by yudo, add min_stock
            $table->float('max_stock')->nullable(); //20170509, by yudo, add max_stock
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
        Schema::dropIfExists('avi_parts');
    }
}
