<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJointProgramEnrollmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('joint_program_enrollments', function (Blueprint $table) {
            $table->uuid('id');
            $table->bigInteger('male_students_number');
            $table->bigInteger('female_students_number');
            $table->timestamps();

            $table->string('sponsor');

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
        Schema::dropIfExists('joint_program_enrollments');
    }
}