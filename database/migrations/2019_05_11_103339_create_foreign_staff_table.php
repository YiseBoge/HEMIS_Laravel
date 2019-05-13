<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateForeignStaffTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('foreign_staff', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('name');
            $table->string('remark');
            $table->date('employment_date');
            $table->date('contract_start_date');
            $table->date('contract_end_date');
            $table->string('specialization');
            $table->string('department');
            $table->bigInteger('country_of_origin');

            $table->string('sex');
            $table->string('education_level');            
            $table->bigInteger('staff_rank'); 
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
        Schema::dropIfExists('foreign_staff');
    }
}
