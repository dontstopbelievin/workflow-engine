<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSelectOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('select_options', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('dictionary_id')->nullable();
            $table->string('name_rus')->nullable();
            $table->string('name_kaz')->nullable();
            $table->string('short_name_rus')->nullable();
            $table->string('short_name_kaz')->nullable();

            $table->bigInteger('target_id')->unsigned()->nullable();
            $table->bigInteger('target_aurz')->unsigned()->nullable();
            $table->bigInteger('cod_parent')->nullable();
            $table->string('category')->nullable();
            $table->bigInteger('purpose_id')->unsigned()->nullable();
            $table->bigInteger('right_type_code')->unsigned()->nullable();
            $table->string('land_category_cod')->nullable();
            $table->string('land_divisibility_code')->nullable();

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
        Schema::dropIfExists('select_options');
    }
}
