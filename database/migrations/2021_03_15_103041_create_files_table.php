<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files_categories', function (Blueprint $table) {
            $table->increments('id')->comment('ИД');
            $table->string('name', 255)->comment('Название категории файла');
            $table->string('allowed_ext', 255)->comment('Разрешенные расширение файлов');
            $table->boolean('is_visible')->comment('Флаг видимости');
            $table->integer('role_id')->nullable()->unsigned()->comment('ИД роли');
            $table->foreign('role_id')->references('id')->on('roles');
            $table->timestamps();
        });

        Schema::create('files', function (Blueprint $table) {
            $table->increments('id')->comment('ИД');
            $table->string('name', 255)->comment('Название файла');
            $table->string('url', 255)->comment('Ссылка на файл');
            $table->string('hash', 255)->unique()->comment('Хэш файла');
            $table->string('extension', 255)->comment('Расширение файла');
            $table->string('content_type', 255)->comment('Тип файла');
            $table->string('size', 255)->comment('Размер файла');
            $table->integer('category_id')->unsigned()->comment('ИД категории')->nullable();
            $table->foreign('category_id')->references('id')->on('files_categories');
            $table->integer('user_id')->unsigned()->comment('ИД пользователя')->nullable();
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
        Schema::dropIfExists('files_categories');
        Schema::dropIfExists('files');
    }
}
