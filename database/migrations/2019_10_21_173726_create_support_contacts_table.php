<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSupportContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('support_contacts', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('name');
            $table->string('phone');
            $table->boolean('available_on_monday')->default(false);
            $table->boolean('available_on_tuesday')->default(false);
            $table->boolean('available_on_wednesday')->default(false);
            $table->boolean('available_on_thursday')->default(false);
            $table->boolean('available_on_friday')->default(false);
            $table->boolean('available_on_saturday')->default(false);
            $table->boolean('available_on_sunday')->default(false);
            $table->timestamps();

            $table->primary('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('support_contacts');
    }
}
