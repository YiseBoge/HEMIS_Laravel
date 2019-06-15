<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMoSHEBSCSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mo_s_h_e_b_s_c_s', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('category');
            $table->string('policy');
            $table->string('kpi_description');

            $table->primary('id');
            $table->uuid('bsc_info_id');
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
        Schema::dropIfExists('mo_s_h_e_b_s_c_s');
    }
}
