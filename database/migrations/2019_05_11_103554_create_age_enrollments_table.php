<?php

use App\Models\Institution\Institution;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgeEnrollmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('age_enrollments', function (Blueprint $table) {
            $table->uuid('id');
            $table->bigInteger('male_students_number');
            $table->bigInteger('female_students_number');

            $table->timestamps();

            $table->string('age');
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
        Schema::dropIfExists('age_enrollments');
    }
}
