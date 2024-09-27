<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCategoryIdToProductosTable extends Migration
{
    public function up()
    {
        Schema::table('productos', function (Blueprint $table) {
            $table->foreignId('category_id')->nullable()->constrained('categories')->onDelete('set null');

        });
    }

    public function down()
    {
        Schema::table('productos', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropColumn('category_id');
        });
    }
}
