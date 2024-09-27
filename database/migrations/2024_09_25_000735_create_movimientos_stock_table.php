<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMovimientosStockTable extends Migration
{
    public function up()
    {
        Schema::create('movimientos_stock', function (Blueprint $table) {
            $table->id();
            $table->foreignId('producto_id')->constrained('productos')->onDelete('cascade');
            $table->integer('cantidad'); 
            $table->string('tipo_movimiento'); 
            $table->foreignId('usuario_id')->nullable()->constrained('users');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('movimientos_stock');
    }
}
