<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRightTypeDictionariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('right_type_dictionaries', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('right_type_code')->unsigned()->nullable();
            $table->string('name_rus')->nullable();
            $table->string('name_kaz')->nullable();
            $table->boolean('deleted')->nullable();
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
        Schema::dropIfExists('right_type_dictionaries');
    }
}
