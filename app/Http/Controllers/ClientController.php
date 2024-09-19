<?php

namespace App\Http\Controllers;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function createClient(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'number' => 'required|unique:clients,number',
            'email' => 'required|email'
        ], [
            'number.unique' => 'Este número ya existe para otro cliente',
        ]);

        $client = new Client;
        $client->name = $validatedData['name'];
        $client->number = $validatedData['number'];
        $client->email = $validatedData['email'];
        $client->visit_count = 0;
        $client->save();
        
        return response()->json(['message' => 'Client creado correctamente', 'client' => $client], 201);
    }

    public function deleteClient($id){
        try {
            $client = Client::find($id);
            if($client){
                if($client->delete()){
                    return response()->json(['message' => 'Cliente eliminado con exito', 'client' => $client], 200);
                }
            }else{
                return response()->json(['message' => 'Cliente no encontrado'], 404);
            }
        } catch (Exception $e) {
            return response()->json(['message'=> 'Error al eliminar cliente', 'error' => $e->getMessage()], 500);
        }
    }

    public function getClients(){
        $clients = Client::all();
        return response()->json(compact('clients'));
    }
}
