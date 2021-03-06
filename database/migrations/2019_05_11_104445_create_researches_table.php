<?php

use App\Models\Institution\Institution;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResearchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('researches', function (Blueprint $table) {
            $table->uuid('id');
            $table->bigInteger('number');
            $table->bigInteger('male_teachers_participating_number');
            $table->bigInteger('female_teachers_participating_number');
            $table->bigInteger('female_researchers_number');
            $table->bigInteger('male_researchers_other_number');
            $table->bigInteger('female_researchers_other_number');
            $table->decimal('budget_allocated');
            $table->decimal('budget_from_externals');
            $table->timestamps();

            $table->string('status');
            $table->string('type');
            $table->string('approval_status')->default(Institution::getEnum('ApprovalTypes')['PENDING']);

            $table->primary('id');
            $table->uuid('department_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('researches');
    }
}
