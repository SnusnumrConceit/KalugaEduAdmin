<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')
                ->comment('уникальный ID для временных папок');
            $table->string('name')
                ->unique()
                ->comment('наименование категории');
            $table->integer('parent_id')
                ->nullable()
                ->comment('id родительской категории');
            $table->string('slug')
                ->comment('ссылка на уникальные таблицы ддля категорий');
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
        Schema::dropIfExists('categories');
    }
}
