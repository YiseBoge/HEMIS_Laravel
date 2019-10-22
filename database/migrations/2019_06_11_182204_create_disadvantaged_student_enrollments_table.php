<?php

use App\Models\Institution\Institution;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDisadvantagedStudentEnrollmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('disadvantaged_student_enrollments', function (Blueprint $table) {
            $table->uuid('id');
            $table->bigInteger('male_students_number');
            $table->bigInteger('female_students_number');
            $table->timestamps();

            $table->string('quintile');
            $table->string('student_type')->default('Normal');
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
        Schema::dropIfExists('disadvantaged_student_enrollments');
    }
}
