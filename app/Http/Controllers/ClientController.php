<?php

namespace App\Http\Controllers;
use App\Models\Client;
use Illuminate\Http\Request;

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
public function deleteClient($id)
{
    try {
        // Verifica si el cliente existe
        $client = Client::find($id);

        // Validar que el cliente no sea el cliente genérico
        if ($id === 1) {
            return response()->json(['message' => 'Este cliente es genérico y no puede eliminarse.'], 403);
        }

        // Verifica si el cliente existe
        if ($client) {
            // Eliminar el cliente
            $client->delete();
            return response()->json(['message' => 'Cliente eliminado con éxito.', 'client' => $client], 200);
        } else {
            return response()->json(['message' => 'Cliente no encontrado.'], 404);
        }
    } catch (\Exception $e) {
        return response()->json(['message' => 'Error al eliminar el cliente.', 'error' => $e->getMessage()], 500);
    }
}


    public function getClients(){
        $clients = Client::all();
        return response()->json(compact('clients'));
    }
}
