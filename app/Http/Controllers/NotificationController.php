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
            $validatedData = $request->validate([
                'message' => 'required',
            ]);
            $msg = $validatedData['message'];
            $doctor = User::find($id);
            if (!$doctor) {
                return response()->json([
                    'message' => 'Doctor no encontrado',
                    'error' => 'No se encontró un Doctor con el ID proporcionado'
                ], 404);            
            }
            if($doctor->fcm_token){
                $notification = new AlertMessageNotification($msg);
                $notification->toFcm($doctor);
                return response()->json(['message' => 'Notificación enviada exitosamente'], 200);
            }else {
                return response()->json([
                    'message' => 'El doctor no tiene un token FCM disponible',
                    'error' => 'No se puede enviar la notificación'
                ], 400);
            }
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Error al enviar notification',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
