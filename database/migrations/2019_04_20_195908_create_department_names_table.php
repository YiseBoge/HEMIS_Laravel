<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDepartmentNamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('department_names', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('department_name');
            $table->string('acronym');
            $table->timestamps();

            $table->primary('id');
            $table->uuid('band_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('department_names');
    }
}
