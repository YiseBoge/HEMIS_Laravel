<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateManagementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('managements', function (Blueprint $table) {
            $table->uuid('id');
            $table->bigInteger('required_position_number');
            $table->bigInteger('currently_assigned_number');
            $table->bigInteger('female_number'); 
            
            $table->string('management_level');
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
        Schema::dropIfExists('managements');
    }
}
