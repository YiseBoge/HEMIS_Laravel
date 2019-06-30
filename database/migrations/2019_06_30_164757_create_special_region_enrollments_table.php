<?php

use App\Models\Institution\Institution;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpecialRegionEnrollmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('special_region_enrollments', function (Blueprint $table) {
            $table->uuid('id'); 
            $table->bigInteger('male_number'); 
            $table->bigInteger('female_number');             
            $table->timestamps();

            $table->string('region_type');
            $table->string('approval_status')->default(Institution::getEnum('ApprovalTypes')['PENDING']);

            $table->primary('id');
            
            $table->uuid('region_name_id');
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
        Schema::dropIfExists('special_region_enrollments');
    }
}
