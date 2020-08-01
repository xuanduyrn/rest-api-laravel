<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameTableProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Rename table https://stackoverflow.com/questions/33888599/laravel-migration-to-change-table-name#:~:text=To%20change%20a%20table%20name,%3A%3AdropIfExists('users')%3B
        Schema::rename('products_tables', 'products');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::drop('users');
        Schema::dropIfExists('products_tables');
    }
}
