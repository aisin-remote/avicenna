<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMPartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_parts', function (Blueprint $table) {
            $table->increments('id');
            $table->('customer_id')->reference('id')->on('m_customers')->onDelete('cascade');
            $table->string('back_number', 100);
            $table->string('part_number', 100);
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
        Schema::dropIfExists('m_parts');
    }
}
