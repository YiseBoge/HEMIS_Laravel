<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBudgetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('budgets', function (Blueprint $table) {
            $table->uuid('id');
            $table->bigInteger('allocated_budget');
            $table->bigInteger('additional_budget');
            $table->bigInteger('utilized_budget');
            $table->string('budget_type');
            $table->timestamps();

            $table->primary('id');
            $table->uuid('budget_description_id');

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
        Schema::dropIfExists('budgets');
    }
}
