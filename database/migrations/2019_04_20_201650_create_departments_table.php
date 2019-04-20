<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDepartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('departments', function (Blueprint $table) {
            $table->uuid('id');
            $table->bigInteger('year_level');
            $table->bigInteger('male_students_number');
            $table->bigInteger('female_students_number');
            $table->bigInteger('graduated_students_number');
            $table->bigInteger('prospective_graduates_number');
            $table->timestamps();

            $table->primary('id');
            $table->uuid('department_name_id');

            $table->uuid('band_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('departments');
    }
}
