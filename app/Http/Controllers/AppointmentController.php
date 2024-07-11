<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use Auth;

class AppointmentController extends Controller
{
    public function store(Request $request){
        try {
            $validatedData = $request->validate([
                'client_id' => 'required',
                'date' => 'required|date',
                'time' => 'required', 
                'treatment' => 'required|string',
                'name' => 'required|string',
            ]);

            $dateTime = $validatedData['date'] . ' ' . $validatedData['time'];
            $user = Auth::user();
            $appointment = new Appointment;
            $clientZero = $validatedData['client_id'];
            if($clientZero === 0){
                $clientZero = 1;
            }
            $appointment->client_id = $clientZero;
            $appointment->created_by = $user->id;
            $appointment->doctor_id = $user->id;
            $appointment->appointment_date = $dateTime; 
            $appointment->treatment_type = $validatedData['treatment'];
            $appointment->status = 'Upcoming'; 
            $appointment->payment_method = 'Tarjeta'; 
            $appointment->client_name = $validatedData['name']; 
            $appointment->save();
            return response()->json([
                'message' => 'Appointment creado correctamente',
                'appointment' => $appointment
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al crear la cita',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function getAppoinments($id){
        $appointments = Appointment::where('doctor_id', $id)->get();
        return response()->json(['appointments' => $appointments]);
    } 
    public function deleteAppoinment($id){
        $appt = Appointment::find($id);
        if($appt->delete()){
            return response()->json(['message' => 'Appointment eliminado con exito', 'appointment' => $appt], 200);
        }else{
            return response()->json([
                'message' => 'Error al eliminar appointment',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function editAppoinment($id){
       try {
            $validatedData = $request->validate([
                'client_id' => 'required',
                'date' => 'required|date',
                'time' => 'required',
                'treatment' => 'string',
                'name' => 'string',
            ]);

            $dateTime = $validatedData['date'] . ' ' . $validatedData['time'];
            $appt = Appointment::find($id);
            
            if (!$appt) {
                return response()->json([
                    'message' => 'Cita no encontrada',
                ], 404);
            }
            $clientZero = $validatedData['client_id'];
            if($clientZero === 0){
                $clientZero = 1;
            }
            $appt->client_id = $clientZero;
            $appt->appointment_date = $dateTime;
            $appt->treatment_type = $validatedData['treatment'];
            $appt->client_name = $validatedData['name'];
            $appt->save();
            return response()->json([
                'message' => 'Cita actualizada correctamente',
                'appointment' => $appt
            ], 200);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al actualizar la cita',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
