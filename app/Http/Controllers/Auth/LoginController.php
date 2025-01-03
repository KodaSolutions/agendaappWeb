<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm(){
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'identification' => ['required'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'identification' => 'Credenciales invalidas',
        ])->onlyInput('identification');
    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();   
        return redirect('/');
    }
    public function createClientWithZeroId(Request $request)
{
    $validator = \Validator::make($request->all(), [
        'name' => 'required',
        'number' => 'required|unique:clients,number',
        'email' => 'required|email'
    ], [
        'number.unique' => 'Este número ya existe para otro cliente',
    ]);

    if ($validator->fails() && $validator->errors()->has('number')) {
        return response()->json([
            'message' => 'Por favor verifica que este contacto no se encuentra ya registrado',
        ], 422);
    }

    if ($validator->fails()) {
        return response()->json($validator->errors(), 422);
    }

    DB::statement('SET FOREIGN_KEY_CHECKS=0;');
    
    $client = new Client;
    $client->id = 1;  // Forzamos el ID a 0
    $client->name = $request->name;
    $client->number = $request->number;
    $client->email = $request->email;
    $client->visit_count = 0;
    $client->save();
    
    DB::statement('SET FOREIGN_KEY_CHECKS=1;');

    return response()->json(['message' => 'Cliente creado correctamente', 'client' => $client], 201);
}
}
