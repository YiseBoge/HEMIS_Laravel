<?php

use App\Models\Institution\Institution;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->bigInteger('number_of_courses');
            $table->bigInteger('number_of_researches');
            $table->timestamps();

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
