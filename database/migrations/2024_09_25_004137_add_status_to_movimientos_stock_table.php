<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToMovimientosStockTable extends Migration
{
    public function up()
    {
        Schema::table('movimientos_stock', function (Blueprint $table) {
            $table->string('status')->nullable()->after('tipo_movimiento');
        });
    }

    public function down()
    {
        Schema::table('movimientos_stock', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
}
