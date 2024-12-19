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
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropForeign('appointments_created_by_foreign');
            $table->dropForeign('appointments_doctor_id_foreign');
            $table->foreign('created_by')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');

            $table->foreign('doctor_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropForeign('appointments_created_by_foreign');
            $table->dropForeign('appointments_doctor_id_foreign');
            $table->foreign('created_by')
                  ->references('id')
                  ->on('user_details')
                  ->onDelete('cascade');

            $table->foreign('doctor_id')
                  ->references('id')
                  ->on('user_details')
                  ->onDelete('cascade');
        });
    }
};
