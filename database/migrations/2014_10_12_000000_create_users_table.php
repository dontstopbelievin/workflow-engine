<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('phone')->nullable();
            $table->string('usertype')->nullable();
            $table->string('email')->unique();
            $table->string('iin')->nullable();
            $table->string('bin')->nullable();
            $table->string('region')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->timestamp('password_changed_at')->nullable();
            $table->datetime('current_login_at')->nullable();
            $table->datetime('last_login_at')->nullable();
            $table->datetime('last_failed_login_at')->nullable();
            $table->string('last_login_ip')->nullable();
            $table->string('last_failed_login_ip')->nullable();
            $table->boolean('has_not_accepted_agreement')->default(1);
            $table->rememberToken();
            $table->string('session_id')->nullable();
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
        Schema::dropIfExists('users');
    }
}
