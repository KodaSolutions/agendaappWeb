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
        Schema::create('appointments2', function (Blueprint $table) {
            $table->id();
            $table->foreignId('form_template_id')->constrained();
            $table->json('form_data');
            $table->dateTime('appointment_date');
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('appointments2', function (Blueprint $table) {
            //
        });
    }
};
