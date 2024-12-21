<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Models\User;
use App\Notifications\PushNotification;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Notification;
use App\Http\Controllers\Auth\LoginController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('userAll', [AuthController::class, 'userAll']);
Route::get('/database-schema', [AuthController::class, 'getSchema']);

//nuevas rutas para web
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});
use App\Notifications\AppointmentDeletedNotification;
Route::get('/testsend/{doctorId}', function ($doctorId) {
    try {
        // Encuentra al doctor por ID
        $doctor = User::find($doctorId);

        // Verifica si el doctor existe y tiene un token FCM
        if ($doctor && $doctor->fcm_token) {
            // Define una fecha de prueba para la notificación
            $appointmentDate = now();  // Puedes usar una fecha estática si lo prefieres

            // Crea la notificación
            $notification = new AppointmentDeletedNotification($appointmentDate);
            
            // Enviar la notificación FCM
            $notification->toFcm($doctor);
            
            return response()->json([
                'message' => 'Notificación enviada con éxito',
                'doctor' => $doctor->name,
                'fcm_token' => $doctor->fcm_token,
            ], 200);
        }

        return response()->json([
            'message' => 'Doctor no encontrado o no tiene un token FCM registrado',
        ], 404);

    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Error al enviar la notificación',
            'error' => $e->getMessage()
        ], 500);
    }
});