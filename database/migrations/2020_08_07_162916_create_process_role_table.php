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
            $table->integer('process_id')->unsigned();
            $table->foreign('process_id')->references('id')->on('processes');
            $table->integer('role_id')->unsigned();
            $table->foreign('role_id')->references('id')->on('roles');
            $table->integer('parent_role_id')->unsigned()->nullable();
            $table->foreign('parent_role_id')->references('id')->on('roles');
            $table->integer('can_reject')->default(0);
            $table->integer('can_send_to_revision')->default(0);
            $table->integer('can_motiv_otkaz')->default(0);
            $table->integer('can_ecp_sign')->default(0);
            $table->integer('is_selection')->default(0);
            $table->integer('order')->unsigned();
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
