<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInternalRevenuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('internal_revenues', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('revenue_description');
            $table->bigInteger('income');
            $table->bigInteger('expense');
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
        Schema::dropIfExists('internal_revenues');
    }
}
