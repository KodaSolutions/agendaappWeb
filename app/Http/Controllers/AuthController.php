<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Client;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function login(Request $request) {
        $credentials = $request->only('email', 'password');
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
            $user = auth()->user();
            if ($request->has('fcm_token')) {
                $user->fcm_token = $request->input('fcm_token');
                $user->save();
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        return response()->json([
            'token' => $token,
            'user' => [
                'id' => $user->id,
                'email' => $user->email,
                'nombre' => $user->name,
            ]
        ]);
    }
    public function logout(Request $request){
        try {
            $token = JWTAuth::getToken();
            if (!$token) {
                return response()->json(['error' => 'Token no proporcionado'], 400);
            }

            JWTAuth::invalidate($token);
            return response()->json(['message' => 'Cierre de sesión exitoso']);
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json(['error' => 'Token inválido'], 401);
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['error' => 'Fallo al cerrar sesión, intente nuevamente'], 500);
        }
    }

    public function getUser(Request $request){
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }
        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json(['token_expired'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json(['token_invalid'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['token_absent'], $e->getStatusCode());
        }

        return response()->json(compact('user'));
    }
    public function userAll(){
        $user = User::all();
        return response()->json(compact('user'));
    }
    public function editUserInfo(Request $request, $id){
        try {
            $validatedData = $request->all();
            $user = Client::find($id);
            if (!$user) {
                return response()->json([
                    'message' => 'Usuario no encontrado',
                    'error' => 'No se encontró un usuario con el ID proporcionado.'
                ], 404);
            }
            $user->name = $validatedData['name'];
            $user->number = $validatedData['number'];
            $user->email = $validatedData['email'];
            $user->save();
            return response()->json([
                'message' => 'Cliente actualizado correctamente',
                'cliente' => $user
            ], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al actualizar cliente',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function refresh(){
        try {
            $newToken = JWTAuth::refresh(JWTAuth::getToken());
            return response()->json(['token' => $newToken]);
        } catch (JWTException $e) {
            return response()->json(['error' => 'No se pudo refrescar el token'], 500);
        }
    }
public function getSchema()
{
    // Array para almacenar la estructura de la base de datos
    $databaseSchema = [];

    // Obtener todas las tablas de la base de datos
    $tables = DB::select("SELECT table_name FROM information_schema.tables WHERE table_schema = DATABASE()");

    // Recorrer cada tabla y obtener sus columnas
    foreach ($tables as $table) {
        $tableName = $table->table_name;

        // Obtener las columnas de la tabla actual
        $columns = DB::select("SELECT column_name, data_type, character_maximum_length, column_default 
                               FROM information_schema.columns 
                               WHERE table_schema = DATABASE() AND table_name = ?", [$tableName]);

        $columnData = [];
        foreach ($columns as $column) {
            $columnData[] = [
                'name' => $column->column_name,
                'type' => $column->data_type,
                'length' => $column->character_maximum_length,
                'default' => $column->column_default,
            ];
        }

        $databaseSchema[$tableName] = $columnData;
    }

    // Retornar la información en formato JSON
    return response()->json($databaseSchema);
}



}

