<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddHelperToServiceFormStepInputs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('service_form_step_inputs', function (Blueprint $table) {
            $table->string('helper_image');
            $table->string('helper_caption');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('service_form_step_inputs', function (Blueprint $table) {
            //
        });
    }
}
