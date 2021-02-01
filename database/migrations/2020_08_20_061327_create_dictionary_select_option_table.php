<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDictionarySelectOptionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dictionary_select_option', function (Blueprint $table) {
            $table->id();
            $table->integer('dictionary_id')->unsigned()->nullable();
            $table->foreign('dictionary_id')->references('id')->on('dictionaries');
            $table->integer('select_option_id')->unsigned()->nullable();
            $table->foreign('select_option_id')->references('id')->on('select_options');
//            $table->unsignedBigInteger('dictionary_id');
//            $table->unsignedBigInteger('select_option_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dictionary_select_option');
    }
}
