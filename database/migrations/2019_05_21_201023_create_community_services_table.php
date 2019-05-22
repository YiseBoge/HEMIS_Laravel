<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommunityServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('community_services', function (Blueprint $table) {
            $table->uuid('id');
            $table->bigInteger('community_services')->default(0);

            $table->bigInteger('male_teachers_participated')->default(0);
            $table->bigInteger('female_teachers_participated')->default(0);

            $table->bigInteger('male_benefited')->default(0);
            $table->bigInteger('female_benefited')->default(0);

            $table->bigInteger('linked_tvets')->default(0);

            $table->boolean('has_spd')->default(false);
            $table->boolean('has_incubation')->default(false);
            $table->boolean('has_hdp_lead')->default(false);
            $table->boolean('has_ccpd_coordinator')->default(false);
            $table->boolean('has_elip_teachers')->default(false);
            $table->boolean('has_elip_students')->default(false);
            $table->boolean('has_career_center')->default(false);

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
        Schema::dropIfExists('community_services');
    }
}
