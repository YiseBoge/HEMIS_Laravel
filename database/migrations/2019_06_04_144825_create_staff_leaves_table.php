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
            $table->string('institution');
            $table->string('country_of_study');
            $table->string('rank_of_study');
            $table->string('status_of_study');
            $table->string('leave_type');
            $table->string('scholarship_type');
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
        Schema::dropIfExists('staff_leaves');
    }
}
