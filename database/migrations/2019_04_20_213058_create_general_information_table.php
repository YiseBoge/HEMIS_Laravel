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

            $table->bigInteger('campuses')->default(0);
            $table->bigInteger('schools')->default(0);
            $table->bigInteger('institutes')->default(0);
            $table->bigInteger('hospitals')->default(0);

            $table->bigInteger('board_members')->default(0);
            $table->bigInteger('vice_presidents')->default(0);
            $table->bigInteger('middle_level_leaders')->default(0);

            $table->timestamps();

            $table->primary('id');

            $table->uuid('resource_id')->nullable();
            $table->uuid('community_service_id')->nullable();
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
