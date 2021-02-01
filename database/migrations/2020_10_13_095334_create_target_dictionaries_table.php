<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTargetDictionariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('target_dictionaries', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('target_id')->unsigned()->nullable();
            $table->bigInteger('target_aurz')->unsigned()->nullable();
            $table->string('name_rus')->nullable();
            $table->string('name_kaz')->nullable();
            $table->bigInteger('cod_parent')->nullable();
            $table->string('category')->nullable();
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
        Schema::dropIfExists('target_dictionaries');
    }
}
