<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStaffTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staff', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('name');
            $table->string('phone_number');
            $table->string('nationality');
            $table->date('birth_date');
            $table->boolean('is_expatriate');
            $table->boolean('is_from_other_region');
            $table->bigInteger('salary');
            $table->bigInteger('service_year');
            $table->text('remarks')->nullable();

            $table->string('academic_level');
            $table->string('dedication');
            $table->string('sex');
            $table->string('employment_type');
            $table->timestamps();

            $table->primary('id');
            $table->uuid('staffable_id');
            $table->string('staffable_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('staff');
    }
}
