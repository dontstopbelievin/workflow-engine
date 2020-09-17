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
            $table->foreignId('input_type_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('insert_type_id')->nullable()->constrained()->onDelete('cascade');
//            $table->foreignId('template_id')->nullable()->constrained()->onDelete('cascade');
            $table->integer('template_id')->unsigned()->nullable();
            $table->foreign('template_id')->references('id')->on('templates');
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
