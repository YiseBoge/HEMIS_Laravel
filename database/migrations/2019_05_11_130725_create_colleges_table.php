<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCollegesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('colleges', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('education_level');
            $table->string('education_program');
            $table->timestamps();

            $table->primary('id');
            $table->uuid('college_name_id')->nullable();
            $table->uuid('band_id')->nullable();
            $table->uuid('institution_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('colleges');
    }
}
