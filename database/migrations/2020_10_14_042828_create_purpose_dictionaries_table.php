<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurposeDictionariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purpose_dictionaries', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('purpose_id')->unsigned()->nullable();
            $table->string('name_rus')->nullable();
            $table->string('name_kaz')->nullable();
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
        Schema::dropIfExists('purpose_dictionaries');
    }
}
