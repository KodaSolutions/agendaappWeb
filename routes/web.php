<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Models\User;
use App\Notifications\PushNotification;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Notification;
use App\Http\Controllers\Auth\LoginController;
use App\Notifications\AppointmentDeletedNotification;


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
Route::get('/testsend/{doctorId}', function ($doctorId) {
    try {
        $doctor = User::find($doctorId);
        if ($doctor && $doctor->fcm_token) {
            $appointmentDate = now(); 
            $notification = new AppointmentDeletedNotification($appointmentDate);
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
