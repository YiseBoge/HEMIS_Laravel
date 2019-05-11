<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStaffLeavesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staff_leaves', function (Blueprint $table) {
            $table->uuid('id');
            $table->bigInteger('number_of_male_students');
            $table->bigInteger('number_of_female_students');
            $table->timestamps();

            $table->string('level_of_study');
            $table->string('place_of_study');

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
        Schema::dropIfExists('staff_leaves');
    }
}
