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
        $credentials = $request->only('identification', 'password');
        
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
                'identification' => $user->identification,
                'email' => $user->email,
                'name' => $user->name,
                'role' => $user->role ? $user->role->name : null
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
    public function store(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            //'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:4',
            'role_id' => 'required|exists:roles,id'
        ]);
        try {
            $name = str_replace(' ', '', strtolower($request->input('name')));
            $date = now()->format('dm');
            $email = $name . $date . '@cpv.com'; 
            $user = new User();
            $user->name = $request->input('name');
            $user->email = $email; //$request->input('email');
            $user->password = bcrypt($request->input('password'));
            $user->role_id = $request->input('role_id');
            $user->save();
            return response()->json([
                'message' => 'Usuario creado exitosamente',
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'identification' => $user->identification,
                    'role' => $user->role->name
                ]
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al crear usuario',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function deleteUser($userId){
        try {
            $user = User::find($userId);

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Usuario no encontrado'
                ], 404);
            }

            $user->delete();

            return response()->json([
                'success' => true,
                'message' => 'Usuario eliminado exitosamente'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar usuario',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function changePassword(Request $request, $userId){
        $request->validate([
            'password' => 'required|string|min:4',
        ]);

        try {
            $user = User::find($userId);

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Usuario no encontrado'
                ], 404);
            }

            $user->password = bcrypt($request->input('password'));
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Contraseña actualizada exitosamente'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar contraseña',
                'error' => $e->getMessage()
            ], 500);
        }
    }


}

