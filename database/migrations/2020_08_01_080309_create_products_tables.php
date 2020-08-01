<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products_tables', function (Blueprint $table) {
            $table->increments('id'); // increments auto tăng;
            $table->string('name', 100);
            $table->text('description')->nullable;
            $table->float('price');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products_tables');
        // php artisan migrate:rollback để xóa con mẹ nó bảng ra khỏi db
    }
}
