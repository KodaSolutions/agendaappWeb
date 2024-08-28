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
    $fcmToken = 'fAKynccKEUGQmemgOZQUyP:APA91bHJIDkRj1VBQXnqeABnMYnDitqkMRp3mx8KsRyOIH3w1pQ6XIAgAyLH5M8sm4skQkY6fV8CMWccJPEsLuKi1K8hq7IZGSDdBaKxOsqqDuE6IYDrMiUJ9Jzns6lUYXO1i7jFfJhB';
    $notifiable = new class {
        use Notifiable;

        public function routeNotificationForFcm()
        {
            return $this->fcmToken;
        }

        public $fcmToken;
    };
    $notifiable->fcmToken = $fcmToken;
    $notification = new \App\Notifications\PushNotification();
    $notification->toFcm($notifiable);

    return "Notificación FCM enviada.";
});
