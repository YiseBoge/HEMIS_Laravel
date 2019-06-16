<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePublicationsAndPatentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('publications_and_patents', function (Blueprint $table) {
            $table->uuid('id');
            $table->bigInteger('student_publications')->default(0);
            $table->bigInteger('patents')->default(0);
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
        Schema::dropIfExists('publications_and_patents');
    }
}
