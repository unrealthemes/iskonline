<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('title');
            $table->string('h1');
            $table->string('link');
            $table->text('subtitle');
            $table->string('keywords');
            $table->text('description');
            $table->string('icon_class');
            $table->boolean('show_author_block');
            $table->boolean('show_form_block');
            $table->boolean('show_share_block');
            $table->string('preview');
            $table->text('text');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blogs');
    }
}
