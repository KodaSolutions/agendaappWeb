<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVentasTable extends Migration
{
    public function up()
    {
        Schema::table('ventas', function (Blueprint $table) {
            $table->dropColumn('producto_id'); 
            $table->dropColumn('cantidad');
            $table->date('fecha')->default(now())->after('usuario_id');
            $table->decimal('total', 8, 2)->after('fecha');
        });
    }

    public function down()
    {
        Schema::table('ventas', function (Blueprint $table) {
            $table->foreignId('producto_id')->constrained('productos')->onDelete('cascade');
            $table->integer('cantidad');
            $table->decimal('precio_venta', 10, 2);
            $table->dropColumn('fecha');
            $table->dropColumn('total');
        });
    
    }
}
