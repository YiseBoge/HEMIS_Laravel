<?php

use App\Models\Institution\Institution;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiasporaCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('diaspora_courses', function (Blueprint $table) {
            $table->uuid('id');
            $table->bigInteger('male_number');
            $table->bigInteger('female_number');
            $table->timestamps();

            $table->string('action');
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
        Schema::dropIfExists('diaspora_courses');
    }
}
