<?php

use App\Models\Institution\Institution;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCostSharingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cost_sharings', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('name');
            $table->string('student_id');
            $table->string('tin_number');
            $table->date('registration_date');
            $table->string('field_of_study');
            $table->date('clearance_date');
            $table->bigInteger('tuition_fee');
            $table->bigInteger('food_expense');
            $table->bigInteger('dormitory_expense');
            $table->bigInteger('pre_payment_amount');
            $table->string('receipt_number');
            $table->bigInteger('unpaid_amount');
            $table->timestamps();

            $table->string('sex');
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
        Schema::dropIfExists('cost_sharings');
    }
}
