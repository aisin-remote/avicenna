<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTriggerUpdateAviAndonStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprapred('CREATE TRIGGER update_updated_at_column_on_avi_andon_status BEFORE UPDATE ON `avi_andon_status` FOR EACH ROW BEGIN SET NEW.updated_at = NOW(); END');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER `avi_andon_status`')
    }
}
