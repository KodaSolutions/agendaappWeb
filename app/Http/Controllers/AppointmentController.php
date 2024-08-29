<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\User;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;
use App\Notifications\AppointmentDeletedNotification;
use App\Notifications\AppointmentCreatedNotification;
use App\Notifications\AppointmentEditedNotification;
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
                'dr_id' => 'nullable',
            ]);

            $dateTime = $validatedData['date'] . ' ' . $validatedData['time'];
            $user = Auth::user();
            $id = $user->id;
            $id = (int) $id;
            if($id === 3){
                $doctor_id = $validatedData['dr_id'];
            }else{
                $doctor_id = $user->id;
            }
            $appointment = new Appointment;
            $clientZero = $validatedData['client_id'];
            if($clientZero === 0){
                $clientZero = 1;
            }
            $appointment->client_id = $clientZero;
            $appointment->created_by = $user->id;
            $appointment->doctor_id = $doctor_id;
            $appointment->appointment_date = $dateTime; 
            $appointment->treatment_type = $validatedData['treatment'];
            $appointment->status = 'Upcoming'; 
            $appointment->payment_method = 'Tarjeta'; 
            $appointment->client_name = $validatedData['name']; 
            $appointment->save();
            $appt = Appointment::where('doctor_id', $doctor_id)->orderBy('created_at', 'desc')->first();
            if($appt){
                $appointmentDate = $appt->appointment_date;
                    $doctor = User::find($doctor_id);
                if ($doctor && $doctor->fcm_token) {
                    $notification = new AppointmentCreatedNotification($appointmentDate);
                    $notification->toFcm($doctor);
                    return response()->json([
                        'message' => 'Appointment creado correctamente',
                        'appointment' => $appointment
                    ], 201);
                }
            }
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
        $id = (int) $id;
        if ($id === 3) {
            $appointments = Appointment::all();
        } else {
            $appointments = Appointment::where('doctor_id', $id)->get();
        }
        return response()->json(['appointments' => $appointments]);
    }
    public function getAppoinmentsAssit(){
        $appointment = Appointment::all();
        return response()->json(compact('appointment'));
    } 
    public function getNotifications($id, $date){
        $id = (int) $id;
        $date = Carbon::parse($date);
        if($id === 3){
            $appointments = Appointment::whereDate('appointment_date', $date)->get();
        }else{
            $appointments = Appointment::where('doctor_id', $id)->whereDate('appointment_date', $date)->get();
        }
        return response()->json(['appointments' => $appointments]);
    }
    public function deleteAppoinment($id)
    {
        try {
            $appt = Appointment::find($id);
            if ($appt) {
                $doctorId = $appt->doctor_id;
                $appointmentDate = $appt->appointment_date;

                if ($appt->delete()) {
                    $doctor = User::find($doctorId);
                if ($doctor && $doctor->fcm_token) {
                    $notification = new AppointmentDeletedNotification($appointmentDate);
                    $notification->toFcm($doctor);
                    return response()->json([
                        'message' => 'Appointment eliminado con éxito',
                        'appointment' => $appt,
                        'fcm_token' => $doctor->fcm_token,
                    ], 200);
                }
                    return response()->json([
                        'message' => 'Appointment eliminado, pero el doctor no tiene un token FCM registrado',
                        'appointment' => $appt,
                    ], 200);
                }
            }
            return response()->json(['message' => 'Appointment no encontrado'], 404);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al eliminar appointment',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function editAppoinment(Request $request, $id){
    try {
        $validatedData = $request->validate([
            'date' => 'required|date',
            'time' => 'required|date_format:H:i:s',
        ]);
        $dateTime = $validatedData['date'] . ' ' . $validatedData['time'];
        $appt = Appointment::find($id);
        if (!$appt) {
            return response()->json([
                'message' => 'Cita no encontrada',
                'error' => 'No se encontró una cita con el ID proporcionado.'
            ], 404);
        }
        $doctorId = $appt->doctor_id;
        $originalDate = $appt->appointment_date;
        $appt->appointment_date = $dateTime;
        $appt->save();
        $doctor = User::find($doctorId);
        if ($doctor && $doctor->fcm_token) {
            $notification = new AppointmentEditedNotification($originalDate, $dateTime);
            $notification->toFcm($doctor);
        }
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
    public function notificationRead($id) {
        try{
            $appt = Appointment::find($id);
            if (!$appt) {
                return response()->json([
                    'message' => 'Appointment no encontrado'
                ], 404);
            }

            $appt->notification_read = true;
            if ($appt->save()) {
                return response()->json([
                    'message' => 'Notification marcada como leída con éxito',
                    'appointment' => $appt
                ], 200);
            } else {
                return response()->json([
                    'message' => 'Error al marcar notification como leída'
                ], 500);
            }
        }catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al procesar la solicitud',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function notificationUnRead($id) {
        try{
            $appt = Appointment::find($id);
            if (!$appt) {
                return response()->json([
                    'message' => 'Appointment no encontrado'
                ], 404);
            }

            $appt->notification_read = false;
            if ($appt->save()) {
                return response()->json([
                    'message' => 'Notification marcada como no leída',
                    'appointment' => $appt
                ], 200);
            } else {
                return response()->json([
                    'message' => 'Error al marcar notification como no leída'
                ], 500);
            }
        }catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al procesar la solicitud',
                'error' => $e->getMessage()
            ], 500);
        }
    }

}