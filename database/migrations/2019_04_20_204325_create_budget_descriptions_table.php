<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBudgetDescriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('budget_descriptions', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('budget_code');
            $table->string('description');
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
        Schema::dropIfExists('budget_descriptions');
    }
}
