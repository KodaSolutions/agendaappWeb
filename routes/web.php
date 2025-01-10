<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Models\User;
use App\Notifications\PushNotification;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Notification;
use App\Http\Controllers\Auth\LoginController;
use App\Notifications\AppointmentDeletedNotification;
use Illuminate\Support\Facades\Hash;
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
/*Route::get('/update-role', function () {
    $user = User::find(22);

    if (!$user) {
        return response()->json(['message' => 'Usuario no encontrado'], 404);
    }
    $user->role_id = 3;
    $user->save();

    return response()->json([
        'message' => 'Rol actualizado exitosamente',
        'user' => $user
    ]);
});*/
/*Route::get('/update-password', function () {
    $user = User::find(22);
    if (!$user) {
        return response()->json(['message' => 'Usuario no encontrado'], 404);
    }
    $user->password = Hash::make('1234');
    $user->save();
    return response()->json([
        'message' => 'Contraseña actualizada exitosamente',
        'user' => $user
    ]);
});*/