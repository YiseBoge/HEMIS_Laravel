<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdministrativeStaffTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('administrative_staff', function (Blueprint $table) {
            $table->uuid('id');

            $table->text('staffRank');
            $table->timestamps();

            $table->primary('id');

            $table->uuid('institution_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('administrative_staff');
    }
}
