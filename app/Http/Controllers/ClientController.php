<?php

namespace App\Http\Controllers;
use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ClientController extends Controller
{
    public function createClient(Request $request){
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
        $client = new Client;
        $client->name = $request->name;
        $client->number = $request->number;
        $client->email = $request->email;
        $client->visit_count = 0;
        $client->save();
        
        return response()->json(['message' => 'Client creado correctamente', 'client' => $client], 201);
    }
    public function deleteClient($id){
        try {
            $id = (int)$id;
            $client = Client::find($id);
            if($id === 1){
                return response()->json(['message' => 'Este cliente es generico y no puede eliminarse'], 302);

            }else{
                if($client){
                    if($client->delete()){
                        return response()->json(['message' => 'Cliente eliminado con exito', 'client' => $client], 200);
                    }
                }else{
                    return response()->json(['message' => 'Cliente no encontrado'], 404);
                }
            }
        } catch (Exception $e) {
            return response()->json(['message'=> 'Error al eliminar cliente', 'error' => $e->getMessage()], 500);
        }
    }

    public function getClients(){
        $clients = Client::all();
        return response()->json(compact('clients'));
    }
        public function createClientWithZeroId(Request $request)
{
  
  
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        $user = new User;
        $user->id = 1;
        $user->name = "Admin";
        $user->email = "admin@example.com";
        $user->password = Hash::make('1234');
        $user->save();
        
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        return response()->json(['message' => 'Usuario creado correctamente', 'user' => $user], 201);
}
}
