<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUpgradingStaffTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('upgrading_staff', function (Blueprint $table) {
            $table->uuid('id'); 
            $table->bigInteger('male_number'); 
            $table->bigInteger('female_number'); 
            
            $table->string('place_of_study');
            $table->string('education_level');
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
        Schema::dropIfExists('upgrading_staff');
    }
}