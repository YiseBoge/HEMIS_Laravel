<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePprcInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pprc_infos', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('year');
            $table->bigInteger('value');
            $table->string('type');
            $table->timestamps();
            $table->primary('id');
            $table->uuid('moshepprc_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pprc_infos');
    }
}
