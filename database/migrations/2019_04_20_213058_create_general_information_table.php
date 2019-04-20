<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGeneralInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('general_information', function (Blueprint $table) {
            $table->uuid('id');

            $table->boolean('has_emis_team');
            $table->bigInteger('male_emis_team_members');
            $table->bigInteger('female_emis_team_members');

            $table->boolean('has_hiv_team');
            $table->bigInteger('male_hiv_team_members');
            $table->bigInteger('female_hiv_team_members');

            $table->boolean('has_institute_of_technology');
            $table->bigInteger('institute_of_technology_number');

            $table->boolean('has_equipped_library');
            $table->bigInteger('equipped_library_number');

            $table->boolean('has_hiv_resources');
            $table->boolean('has_internet_access');
            $table->boolean('has_elearning_facilities');
            $table->boolean('supports_disadvantaged');
            $table->boolean('has_efficient_gender_office');
            $table->boolean('has_sufficient_internal_income');
            $table->boolean('has_research_center');
            $table->boolean('has_qa_office');
            $table->boolean('has_strategic_plan_documents');


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
        Schema::dropIfExists('general_information');
    }
}
