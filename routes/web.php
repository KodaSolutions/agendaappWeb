<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Models\User;
use App\Notifications\PushNotification;
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
Route::get('/send-test-notification', function () {
    $users = User::all();

    foreach ($users as $user) {
        $user->notify(new PushNotification());
    }

    return "Notificaciones de prueba enviadas a todos los usuarios.";
});