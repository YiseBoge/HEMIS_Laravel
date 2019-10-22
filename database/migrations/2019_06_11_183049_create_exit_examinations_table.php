<?php

use App\Models\Institution\Institution;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExitExaminationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exit_examinations', function (Blueprint $table) {
            $table->uuid('id');
            $table->bigInteger('males_sat');
            $table->bigInteger('females_sat');
            $table->bigInteger('males_passed');
            $table->bigInteger('females_passed');
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
        Schema::dropIfExists('exit_examinations');
    }
}
