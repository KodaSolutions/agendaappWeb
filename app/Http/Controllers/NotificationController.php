<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use App\Notifications\AlertMessageNotification;

class NotificationController extends Controller
{
    public function sendNotification(Request $request, $id){
        try {
            Log::info('Iniciando proceso de notificación', [
                'doctor_id' => $id,
                'request_data' => $request->all()
            ]);

            $validatedData = $request->validate([
                'message' => 'required',
            ]);

            Log::info('Datos validados correctamente', [
                'message' => $validatedData['message']
            ]);

            $msg = $validatedData['message'];
            $doctor = User::find($id);

            if (!$doctor) {
                Log::warning('Doctor no encontrado', ['id' => $id]);
                return response()->json([
                    'message' => 'Doctor no encontrado',
                    'error' => 'No se encontró un Doctor con el ID proporcionado'
                ], 404);            
            }

            Log::info('Doctor encontrado', [
                'doctor_id' => $doctor->id,
                'doctor_name' => $doctor->name,
                'fcm_token' => $doctor->fcm_token ? 'Presente' : 'Ausente'
            ]);

            if($doctor->fcm_token){
                Log::info('Preparando envío de notificación', [
                    'token' => $doctor->fcm_token,
                    'message' => $msg
                ]);
                
                try {
                    $notification = new AlertMessageNotification($msg);
                    Log::info('Notificación creada, intentando enviar');
                    
                    $notification->toFmc($doctor); // Nota: ¿Es toFmc o toFcm? Verifica el nombre correcto
                    
                    Log::info('Notificación enviada exitosamente');
                    return response()->json([
                        'message' => 'Notificación enviada exitosamente',
                        'doctor_id' => $doctor->id,
                        'message_sent' => $msg
                    ], 200);
                } catch (\Exception $e) {
                    Log::error('Error al enviar la notificación', [
                        'error' => $e->getMessage(),
                        'trace' => $e->getTraceAsString()
                    ]);
                    throw $e;
                }
            } else {
                Log::warning('Doctor sin token FCM', [
                    'doctor_id' => $doctor->id
                ]);
                return response()->json([
                    'message' => 'El doctor no tiene un token FCM disponible',
                    'error' => 'No se puede enviar la notificación'
                ], 400);
            }
        } catch (\Exception $e) {
            Log::error('Error general en el controlador', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'doctor_id' => $id ?? 'no disponible'
            ]);
            
            return response()->json([
                'message' => 'Error al enviar notification',
                'error' => $e->getMessage(),
                'error_type' => get_class($e)
            ], 500);
        }
    }
}
