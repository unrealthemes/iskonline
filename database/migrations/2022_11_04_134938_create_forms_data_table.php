<?php

use App\Models\Application;
use App\Models\FormUiForm;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormsDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forms_data', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->json('data');
            $table->foreignIdFor(FormUiForm::class);
            $table->foreignIdFor(Application::class);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('forms_data');
    }
}
