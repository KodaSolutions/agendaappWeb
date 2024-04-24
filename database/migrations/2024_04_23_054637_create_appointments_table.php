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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('clients')->onDelete('cascade');
            $table->foreignId('created_by')->constrained('user_details')->onDelete('cascade'); // Asistente que creó la cita
            $table->foreignId('doctor_id')->constrained('user_details')->onDelete('cascade'); // Doctor a cargo
            $table->date('appointment_date');
            $table->string('treatment_type');
            $table->string('payment_method');
            $table->enum('status', ['completed', 'upcoming', 'cancelled', 'rescheduled']);
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
        Schema::dropIfExists('appointments');
    }
};
