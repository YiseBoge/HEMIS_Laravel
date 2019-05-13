<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUniversityIndustryLinkagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('university_industry_linkages', function (Blueprint $table) {
            $table->uuid('id');
            $table->bigInteger("number_of_industry_links");
            $table->string('training_area');
            $table->bigInteger('number_of_students');
            $table->timestamps();

            $table->string('year');

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
        Schema::dropIfExists('university_industry_linkages');
    }
}
