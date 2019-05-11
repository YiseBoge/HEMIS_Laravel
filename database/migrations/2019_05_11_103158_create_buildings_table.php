<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBuildingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buildings', function (Blueprint $table) {
            $table->uuid('id');
            $table->boolean('admin_purpose');
            $table->boolean('class_rooms');
            $table->boolean('library');
            $table->boolean('dormitories');
            $table->boolean('staff_residence');
            $table->boolean('workshop');
            $table->boolean('laboratories');
            $table->boolean('cafeteria');
            $table->boolean('start_date');
            $table->date('date_of_completion');
            $table->text('contractor_name');
            $table->text('consultant_name');
            $table->double('completion_status');
            $table->decimal('budget_allocated');
            $table->timestamps();

            $table->primary('id');

            $table->uuid('institution_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('buildings');
    }
}
