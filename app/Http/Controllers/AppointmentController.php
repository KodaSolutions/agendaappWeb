<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function store(Request $request){
        $validatedData = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'appointment_date' => 'required|date',
            'treatment_type' => 'required|string',
            'payment_method' => 'required|string',
            'status' => 'required|in:completed,upcoming,cancelled,rescheduled',
        ]);
        $user = Auth::user();

        $appointment = new Appointment;
        $appointment->client_id = $validatedData['client_id'];
        $appointment->created_by = $user->id;
        $appointment->doctor_id = $user->id;
        $appointment->appointment_date = $validatedData['appointment_date'];
        $appointment->treatment_type = $validatedData['treatment_type'];
        $appointment->payment_method = $validatedData['payment_method'];
        $appointment->status = $validatedData['status'];
        
        $appointment->save();

        return response()->json(['message' => 'Appointment creado correctamente', 'appointment' => $appointment], 201);
    }
}
