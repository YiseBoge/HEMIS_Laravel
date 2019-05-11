<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpecialProgramTeachersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('special_program_teachers', function (Blueprint $table) {
            $table->uuid('id');
            $table->bigInteger('male_number');
            $table->bigInteger('female_number');

            $table->string('program_type');
            $table->string('program_status');
            $table->timestamps();

            $table->primary('id');
            
            $table->uuid('department_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('special_program_teachers');
    }
}
