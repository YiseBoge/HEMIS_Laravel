<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInistitutionBSCInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inistitution_b_s_c_infos', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('year');
            $table->bigInteger('value');
            $table->string('type');
            $table->timestamps();
            $table->primary('id');
            $table->uuid('institution_id');
            $table->uuid('institution_bsc_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inistitution_b_s_c_infos');
    }
}
