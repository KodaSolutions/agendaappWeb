<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVentasTable extends Migration
{
    public function up()
    {
        Schema::create('ventas', function (Blueprint $table) {
            $table->id(); // bigint(20) UNSIGNED, primary key, auto-increment
            $table->integer('cantidad')->unsigned(); // int(11), NOT NULL
            $table->decimal('total', 10, 2); // decimal(10,2), NOT NULL
            $table->unsignedBigInteger('usuario_id')->nullable(); // bigint(20) UNSIGNED, DEFAULT NULL
            $table->timestamps(); // created_at and updated_at, NULL DEFAULT NULL
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ventas');
    }
}
