<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportYearValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('report_year_values', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('year');
            $table->double('value')->default(0);
            $table->timestamps();

            $table->primary('id');

            $table->uuid('report_card_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('report_year_values');
    }
}
