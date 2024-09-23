<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Models\User;
use App\Notifications\PushNotification;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Notification;
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

use App\Models\Client;
use App\Models\UserDetail;
use Illuminate\Support\Facades\DB;

Route::get('/insert-client', function () {
    // Verificar si el cliente ya existe
    $client = Client::find(1);

    // Si no existe, crear uno nuevo con ID 1
    if (!$client) {
        DB::insert('insert into clients (id, name, number, email, visit_count, created_at, updated_at) values (?, ?, ?, ?, ?, ?, ?)', [
            1,
            'Cliente Generico',
            '0000000000',
            'cliente@cliente.com',
            0,
            now(),
            now(),
        ]);
    } else {
        return response()->json(['message' => 'Cliente ya existe.'], 400);
    }

    // Insertar en la tabla user_details
    $userDetail = UserDetail::create([
        'name' => 'Nombre por defecto',
        'role_id' => 1,
        'user_id' => 1, // Usar el ID del cliente
        'age' => 0,
        'phone' => '000-000-0000',
        'gender' => 'no especificado',
        'birthday' => '0000-00-00', // Valor por defecto
    ]);

    return response()->json([
        'client' => ['id' => 1, 'name' => 'Cliente Generico'],
        'userDetail' => $userDetail,
    ]);
});



