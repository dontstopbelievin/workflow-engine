<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProcessRoleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('process_role', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('process_id')->unsigned()->nullable();
            $table->foreign('process_id')->references('id')->on('processes');
            $table->integer('role_id')->unsigned()->nullable();
            $table->foreign('role_id')->references('id')->on('roles');
            $table->integer('parent_role_id')->unsigned()->nullable();
            $table->foreign('parent_role_id')->references('id')->on('roles');
            $table->integer('role_to_join')->unsigned()->nullable();
            $table->foreign('role_to_join')->references('id')->on('roles');
            $table->integer('is_parallel')->default(0)->nullable();
            $table->integer('can_reject')->default(0)->nullable();
            $table->integer('can_send_to_revision')->default(0)->nullable();
            $table->integer('approve_in_parallel')->nullable();
            $table->integer('priority')->nullable();
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
        Schema::dropIfExists('process_role');
    }
}
