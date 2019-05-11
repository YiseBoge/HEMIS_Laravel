<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAcademicStaffTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('academic_staff', function (Blueprint $table) {
            $table->uuid('id'); 
            $table->bigInteger('male_number'); 
            $table->bigInteger('female_number'); 
            
            $table->string('staff_rank');
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
        Schema::dropIfExists('academic_staff');
    }
}
