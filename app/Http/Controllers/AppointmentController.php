<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use Auth;

class AppointmentController extends Controller
{
public function store(Request $request){
    $validatedData = $request->validate([
        'client_id' => 'required|exists:clients,id',
        'date' => 'required|date',
        'time' => 'required', 
        'treatment' => 'required|string', 
    ]);
    
    $user = Auth::user();

    $appointment = new Appointment;
    $appointment->client_id = $validatedData['client_id'];
    $appointment->created_by = $user->id;
    $appointment->doctor_id = $user->id; 
    $appointment->appointment_date = $validatedData['date'] . ' ' . $validatedData['time']; 
    $appointment->treatment_type = $validatedData['treatment'];
    $appointment->status = 'Upcoming'; 

    $appointment->save(); 

    return response()->json([
        'message' => 'Appointment creado correctamente',
        'appointment' => $appointment
    ], 201);
}

}
