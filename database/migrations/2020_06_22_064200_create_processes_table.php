<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProcessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('processes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('Наименоваие процесса');
            $table->integer('deadline')->comment('Количество дней на заявку');
            $table->integer('accepted_template_id')->unsigned()->nullable();
            $table->foreign('accepted_template_id')->references('id')->on('templates');
            $table->integer('rejected_template_id')->unsigned()->nullable();
            $table->foreign('rejected_template_id')->references('id')->on('templates');
            $table->integer('template_doc_id')->unsigned()->nullable();
            $table->foreign('template_doc_id')->references('id')->on('template_docs');
            $table->integer('main_organization_id')->unsigned()->nullable();
            $table->integer('support_organization_id')->unsigned()->nullable();
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
        Schema::dropIfExists('processes');
    }
}
