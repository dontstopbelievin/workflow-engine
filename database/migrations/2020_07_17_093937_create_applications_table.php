<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('surname')->nullable();
            $table->string('email')->nullable();
            $table->string('adress')->nullable();
            $table->string('iin')->nullable();
            $table->string('bin')->nullable();
            $table->string('company_name')->nullable();
            $table->string('phone')->nullable();
            $table->string('cadastre')->nullable();
            $table->string('region')->nullable();
            $table->string('district')->nullable();
            $table->string('city')->nullable();
            $table->integer('process_id')->unsigned()->nullable();
            $table->foreign('process_id')->references('id')->on('processes');
            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('applications');
    }
}
