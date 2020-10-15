<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLandCategoryDictionariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('land_category_dictionaries', function (Blueprint $table) {
            $table->id();
            $table->string('land_category_cod')->nullable();
            $table->string('name_rus')->nullable();
            $table->string('short_name_rus')->nullable();
            $table->string('name_kaz')->nullable();
            $table->string('short_name_kaz')->nullable();
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
        Schema::dropIfExists('land_category_dictionaries');
    }
}
