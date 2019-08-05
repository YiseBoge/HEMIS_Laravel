<?php

use App\Models\Institution\Institution;
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
            $table->timestamps();

            $table->string('budget_type');
            $table->string('approval_status')->default(Institution::getEnum('ApprovalTypes')['PENDING']);
            
            $table->primary('id');
            $table->uuid('budget_description_id')->nullable();

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
        Schema::dropIfExists('budgets');
    }
}
