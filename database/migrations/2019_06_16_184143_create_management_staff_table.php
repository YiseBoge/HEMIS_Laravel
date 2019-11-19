<?php

use App\Models\Institution\Institution;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateManagementStaffTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('management_staff', function (Blueprint $table) {
            $table->uuid('id');
            $table->timestamps();

            $table->string('management_level');
            $table->string('approval_status')->default(Institution::getEnum('ApprovalTypes')['PENDING']);
            
            $table->primary('id');

            $table->uuid('college_id');
            $table->uuid('job_title_id');
            $table->uuid('staff_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('management_staff');
    }
}
