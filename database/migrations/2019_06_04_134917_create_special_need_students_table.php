<?php

use App\Models\Institution\Institution;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpecialNeedStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('special_need_students', function (Blueprint $table) {
            $table->uuid('id');
            $table->timestamps();

            $table->string('disability');
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
        Schema::dropIfExists('special_need_students');
    }
}
