<?php

use App\Models\Institution\Institution;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAcademicStaffTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('academic_staff', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('field_of_study');
            $table->bigInteger('teaching_load');
            $table->text('overload_remark');
            $table->timestamps();

            $table->string('staffRank');
            $table->string('approval_status')->default(Institution::getEnum('ApprovalTypes')['PENDING']);

            $table->primary('id');
            $table->uuid('staff_leave_id')->nullable();
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
        Schema::dropIfExists('academic_staff');
    }
}
