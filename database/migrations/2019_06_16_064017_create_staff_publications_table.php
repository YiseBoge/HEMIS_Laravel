<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStaffPublicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staff_publications', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('title');
            $table->date('date_of_publication');
            $table->timestamps();

            $table->primary('id');
            $table->uuid('academic_staff_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('staff_publications');
    }
}
