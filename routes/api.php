<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\NotificationController;
use App\Models\User;
use App\Models\Inventory\Producto;

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
Route::post('editUserInfo/{id}', [AuthController::class, 'editUserInfo']);
Route::post('refresh', [AuthController::class, 'refresh']);
//controladores clientes
Route::post('createClient', [ClientController::class, 'createClient']);
Route::get('clientsAll', [ClientController::class, 'getClients']);
Route::post('deleteClient/{id}', [ClientController::class, 'deleteClient']);
Route::post('createAppoinment', [AppointmentController::class, 'store']);
Route::post('deleteAppoinment/{id}', [AppointmentController::class, 'deleteAppoinment']);
//controladores appointment
Route::put('editAppoinment/{id}', [AppointmentController::class, 'editAppoinment']);
Route::get('getAppoinments/{id}', [AppointmentController::class, 'getAppoinments']);
Route::get('getAppoinments/{id}', [AppointmentController::class, 'getAppoinments']);
Route::get('getAppoinmentsByUser/{id}', [AppointmentController::class, 'getAppoinmentsByUser']);
Route::put('/appointments/{id}/read', [AppointmentController::class, 'notificationRead']);
Route::put('/appointments/{id}/unRead', [AppointmentController::class, 'notificationUnRead']);
Route::get('getAppointmentsByDate/{id}/{date}', [AppointmentController::class,'getNotifications']);
//ruta envio notificacion personalizada
Route::post('sendNotification/{id}', [NotificationController::class, 'sendNotification']);

//ruta provicional cambiar contrasenas
route::get('/changes', function() {
    $users = Producto::all();
    /*foreach($users as $user){    
        $user->password = Hash::make('1234');
        $user->save();
    } */
    foreach ($users as $user) {
        $user->category_id = 63;
        $user->save();
    }
    return $users;
}); 

//rutas inventario
use App\Http\Controllers\Inventory\ProductoController;
use App\Http\Controllers\Inventory\StockController;
use App\Http\Controllers\Inventory\MovimientosStockController;
use App\Http\Controllers\Inventory\CategoryController;
use App\Http\Controllers\Inventory\CartController;

Route::apiResource('productos', ProductoController::class);
Route::apiResource('stock', StockController::class);
Route::apiResource('movimientos_stock', MovimientosStockController::class);
Route::apiResource('categories', CategoryController::class);
Route::post('carrito', [CartController::class, 'store']);
Route::get('ventas/carrito', [CartController::class, 'getVentasPorCarrito']);
Route::get('ventas/producto', [CartController::class, 'getVentasPorProducto']);
//Route::post('categories', [CategoryController::class, 'store']);
