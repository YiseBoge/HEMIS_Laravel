<?php

use App\Models\Institution\Institution;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpecialProgramTeachersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('special_program_teachers', function (Blueprint $table) {
            $table->uuid('id');
            $table->bigInteger('male_number');
            $table->bigInteger('female_number');
            $table->timestamps();

            $table->string('program_type');
            $table->string('program_stat');
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
        Schema::dropIfExists('special_program_teachers');
    }
}
