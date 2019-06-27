<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCollegeNamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('college_names', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('college_name');
            $table->string('acronym');
            $table->timestamps();

            $table->primary('id');

            $table->uuid('institution_name_id');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('college_names');
    }
}
