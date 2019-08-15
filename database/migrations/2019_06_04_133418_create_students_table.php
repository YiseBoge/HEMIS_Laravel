<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('name');
            $table->string('student_id');
            $table->string('phone_number');
            $table->date('birth_date');
            $table->text('remarks')->nullable();

            $table->string('sex');
            $table->timestamps();

            $table->primary('id');
            $table->uuid('student_service_id')->nullable();
            $table->uuid('studentable_id');
            $table->string('studentable_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('students');
    }
}
