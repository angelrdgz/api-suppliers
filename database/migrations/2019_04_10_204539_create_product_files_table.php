<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('product_files')) {
            Schema::create('product_files', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->integer('product_id')->references('id')->on('products');
                $table->string('url');
                $table->integer('type_id')->references('id')->on('file_types');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_files');
    }
}
