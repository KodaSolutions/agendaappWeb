<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\AppointmentController;

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
Route::get('user', [AuthController::class, 'getUser'])->middleware('jwt.auth');
Route::post('createClient', [ClientController::class, 'createClient']);
Route::get('clientsAll', [ClientController::class, 'getClients']);
Route::post('createAppoinment', [AppointmentController::class, 'store']);
Route::post('deleteAppoinment/{id}', [AppointmentController::class, 'deleteAppoinment']);
Route::post('editAppoinment/{id}', [AppointmentController::class, 'editAppoinment']);
Route::get('getAppoinments/{id}', [AppointmentController::class, 'getAppoinments']);