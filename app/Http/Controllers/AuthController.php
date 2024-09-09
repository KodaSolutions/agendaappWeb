<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

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
                'nombre' => $user->nombre,
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
            $user = User::find($id);
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
}

