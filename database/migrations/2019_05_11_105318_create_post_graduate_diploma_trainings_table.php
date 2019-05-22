<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostGraduateDiplomaTrainingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post_graduate_diploma_trainings', function (Blueprint $table) {
            $table->uuid('id');
            $table->bigInteger('number_of_male_students');
            $table->bigInteger('number_of_female_students');
            $table->boolean('is_lead');
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
        Schema::dropIfExists('post_graduate_diploma_trainings');
    }
}
