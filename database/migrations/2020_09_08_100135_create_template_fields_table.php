<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTemplateFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('template_fields', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('label_name');
            $table->foreignId('input_type_id')->nullable();
            $table->foreignId('insert_type_id')->nullable();
            $table->integer('template_id')->unsigned()->nullable();
            $table->foreign('template_id')->references('id')->on('templates');
            $table->integer('select_dic')->unsigned()->nullable();
            $table->foreign('select_dic')->references('id')->on('dictionaries');
            $table->unique(['name', 'template_id']);
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
        Schema::dropIfExists('template_fields');
    }
}
