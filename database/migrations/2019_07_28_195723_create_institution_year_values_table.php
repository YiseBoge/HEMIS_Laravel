<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstitutionYearValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('institution_year_values', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('year');
            $table->double('value')->default(0);
            $table->string('type')->default('normal');
            $table->timestamps();

            $table->primary('id');

            $table->uuid('institution_report_card_id');
            $table->uuid('institution_name_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('institution_year_values');
    }
}
