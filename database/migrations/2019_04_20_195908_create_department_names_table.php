<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
        Schema::dropIfExists('department_names');
    }
}
