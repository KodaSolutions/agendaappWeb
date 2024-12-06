<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('venta_detalles', function (Blueprint $table) {
            $table->dropForeign(['producto_id']);
            $table->unsignedBigInteger('producto_id')->nullable()->change();
            $table->foreign('producto_id')
                  ->references('id')
                  ->on('productos')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('venta_detalles', function (Blueprint $table) {
            $table->dropForeign(['producto_id']);
            $table->unsignedBigInteger('producto_id')->nullable(false)->change();
            $table->foreign('producto_id')
                  ->references('id')
                  ->on('productos')
                  ->onDelete('restrict');
        });
    }
};
