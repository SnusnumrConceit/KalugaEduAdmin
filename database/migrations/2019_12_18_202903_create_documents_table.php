<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')
                ->unique()
                ->comment('название документа');
            $table->string('url')
                ->comment('путь к документу');
            $table->unsignedBigInteger('category_id')
                ->nullable()
                ->comment('идентификатор категории');
            $table->timestamps();

            $table->foreign('category_id')
                ->references('id')
                ->on('categories')
                ->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('documents', 'category_id')) {
            Schema::table('documents', function (Blueprint $table) {
               $table->dropForeign(['category_id']);
            });
        }

        Schema::dropIfExists('documents');
    }
}
