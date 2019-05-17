<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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

            $table->boolean('has_emis_team')->default(false);
            $table->bigInteger('male_emis_team_members')->default(0);
            $table->bigInteger('female_emis_team_members')->default(0);

            $table->boolean('has_hiv_team')->default(false);
            $table->bigInteger('male_hiv_team_members')->default(0);
            $table->bigInteger('female_hiv_team_members')->default(0);

            $table->boolean('has_institute_of_technology')->default(false);
            $table->bigInteger('institute_of_technology_number')->default(0);

            $table->boolean('has_equipped_library')->default(false);
            $table->bigInteger('equipped_library_number')->default(0);

            $table->boolean('has_hiv_resources')->default(false);
            $table->boolean('has_internet_access')->default(false);
            $table->boolean('has_elearning_facilities')->default(false);
            $table->boolean('supports_disadvantaged')->default(false);
            $table->boolean('has_efficient_gender_office')->default(false);
            $table->boolean('has_sufficient_internal_income')->default(false);
            $table->boolean('has_research_center')->default(false);
            $table->boolean('has_qa_office')->default(false);
            $table->boolean('has_strategic_plan_documents')->default(false);


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
