<?php

use App\Models\Institution\Institution;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminAndNonAcademicStaffTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_and_non_academic_staff', function (Blueprint $table) {
            $table->uuid('id');
            $table->bigInteger('male_staff_number');
            $table->bigInteger('female_staff_number');
            $table->timestamps();

            $table->string('education_level');
            $table->string('approval_status')->default(Institution::getEnum('ApprovalTypes')['PENDING']);

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
        Schema::dropIfExists('admin_and_non_academic_staff');
    }
}
