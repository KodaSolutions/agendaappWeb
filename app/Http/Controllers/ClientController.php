<?php

namespace App\Http\Controllers;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function createClient(Request $request){
        $validatedData = $request->validate([
            'name' => 'required',
            'number' => 'required',
            'email' => 'required']);
        $client = new Client;
        $client->name = $validatedData['name'];
        $client->number = $validatedData['number'];
        $client->email = $validatedData['email'];
        $client->visit_count = 0;
        $client->save();
        return response()->json(['message' => 'Client creado correctamente', 'client' => $client], 201);
    }
}
