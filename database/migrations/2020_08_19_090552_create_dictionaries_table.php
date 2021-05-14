<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDictionariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dictionaries', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('label_name');
            $table->foreignId('input_type_id')->nullable();
            $table->foreignId('insert_type_id')->nullable();
            $table->boolean('required')->default(1);
            $table->string('select_dic')->nullable();
            $table->timestamps();
        });
        Schema::table('dictionaries', function (Blueprint $table)
        {
            $table->foreign('select_dic')->references('name')->on('dictionaries');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dictionaries');
    }
}
