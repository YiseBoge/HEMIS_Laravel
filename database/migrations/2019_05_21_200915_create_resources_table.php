<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResourcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resources', function (Blueprint $table) {
            $table->uuid('id');
            $table->bigInteger('number_of_libraries')->default(0);
            $table->bigInteger('number_of_laboratories')->default(0);
            $table->bigInteger('number_of_workshops')->default(0);

            $table->string('status_of_libraries')->nullable()->default('Unknown');
            $table->string('status_of_laboratories')->nullable()->default('Unknown');
            $table->string('status_of_workshops')->nullable()->default('Unknown');

            $table->bigInteger('number_of_classrooms')->default(0);
            $table->bigInteger('number_of_smart_classrooms')->default(0);

            $table->bigInteger('pupil_per_teacher')->default(0);
            $table->bigInteger('text_per_student')->default(0);

            $table->bigInteger('unjustifiable_expenses')->default(0);

            $table->timestamps();

            $table->primary('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('resources');
    }
}
