<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\AppointmentController;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
/*rutas para uso Flutter*/
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout']);
Route::get('user', [AuthController::class, 'getUser'])->middleware('jwt.auth');
Route::post('refresh', [AuthController::class, 'refresh']);
Route::post('createClient', [ClientController::class, 'createClient']);
Route::get('clientsAll', [ClientController::class, 'getClients']);
Route::post('createAppoinment', [AppointmentController::class, 'store']);
Route::post('deleteAppoinment/{id}', [AppointmentController::class, 'deleteAppoinment']);
//funcion de prueba
Route::put('editAppoinment/{id}', [AppointmentController::class, 'editAppoinment']);
Route::post('editUserInfo/{id}', [AuthController::class, 'editUserInfo']);

Route::get('getAppoinments/{id}', [AppointmentController::class, 'getAppoinments']);
Route::get('getAppoinmentsAssit', [AppointmentController::class, 'getAppoinmentsAssit']);
Route::get('getAppointmentsByDate/{id}/{date}', [AppointmentController::class,'getNotifications']);
Route::put('/appointments/{id}/read', [AppointmentController::class, 'notificationRead']);
Route::put('/appointments/{id}/unRead', [AppointmentController::class, 'notificationUnRead']);

route::get('/changes', function() {
    $users = User::all();
    foreach($users as $user){    
        $user->password = Hash::make('1234');
        $user->save();
    }
    return $users;
}); 

