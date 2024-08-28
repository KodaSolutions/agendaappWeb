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
Route::get('/send-test-notification', function () {
    $users = User::all();
    $user->notify(new PushNotification());

    return "Notificación de prueba enviada.";
});
Route::get('/send-fcm-notification', function () {
    // Token FCM específico (el token que mencionaste)
    $fcmToken = 'fymY5Pd9R0jXmETfwn7zPk:APA91bGTXyDMgVGOu0CjM524ys3zqtiSS1srEIP9rXcgNUYEjxYyGR1zhGBPlswT9PYwt0QhVNQyi3pQcOIESd7oXTzi0Gjg6HF5fI7rYev6zFK8dUTloIm1XCt_mIhPSHwMvBl6z6UV';

    // Crear una clase anónima (notificable temporal) que use el trait Notifiable
    $notifiable = new class {
        use Notifiable;

        public function routeNotificationForFcm()
        {
            return $this->fcmToken;
        }

        public $fcmToken;
    };

    // Asignar el token FCM al objeto notifiable
    $notifiable->fcmToken = $fcmToken;

    // Enviar la notificación
    Notification::send($notifiable, new PushNotification());

    return "Notificación FCM enviada.";
});