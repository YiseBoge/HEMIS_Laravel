<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBuildingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buildings', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('building_name');
            $table->text('contractor_name');
            $table->text('consultant_name');
            $table->date('date_started');
            $table->date('date_completed');
            $table->double('completion_status')->nullable();
            $table->decimal('budget_allocated', 10, 2);
            $table->decimal('financial_status', 10, 2)->nullable();
            $table->timestamps();

            $table->primary('id');

            $table->uuid('college_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('buildings');
    }
}
