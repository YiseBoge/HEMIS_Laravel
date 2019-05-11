<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateForeignStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('foreign_students', function (Blueprint $table) {
            $table->uuid('id');
            $table->bigInteger('number_of_male_students');
            $table->bigInteger('number_of_female_students');
            $table->timestamps();

            $table->string('program');
            $table->string('reason');

            $table()->primary('id');

            $table()->uuid('department_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('foreign_students');
    }
}
