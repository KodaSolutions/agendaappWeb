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

Route::get('/insert-client', function () {
    // Intentar obtener el cliente con ID 1
    $client = Client::find(1);

    // Si no existe, crear uno nuevo con ID 1
    if (!$client) {
        $client = new Client([
            'id' => 1, // Forzar el ID
            'name' => 'Cliente Generico',
            'number' => '0000000000',
            'email' => 'cliente@cliente.com',
            'visit_count' => 0,
        ]);
        $client->save();
    }

    // Insertar en la tabla user_details
    $userDetail = UserDetail::create([
        'name' => 'Nombre por defecto',
        'role_id' => 1, // Ajusta este valor según sea necesario
        'user_id' => $client->id, // Usar el ID del cliente
        'age' => 0, // Ajusta según sea necesario
        'phone' => '000-000-0000', // Valor por defecto
        'gender' => 'no especificado',
        'birthday' => '000-000-0000' // Valor por defecto
    ]);

    return response()->json([
        'client' => $client,
        'userDetail' => $userDetail,
    ]);
});


