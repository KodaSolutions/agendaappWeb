<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CustomMessage;

class CustomMessageController extends Controller
{
   public function index()
    {
        $messages = CustomMessage::where('active', true)->get();
        return response()->json($messages);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $message = CustomMessage::create($validated);
        return response()->json($message, 201);
    }

    public function show(CustomMessage $message)
    {
        return response()->json($message);
    }

    public function update(Request $request, CustomMessage $message)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'active' => 'boolean'
        ]);

        $message->update($validated);
        return response()->json($message);
    }

    public function destroy($message)
    {
        //$message->delete();
        $id = (int)$message;
        $message = CustomMessage::find($id);
        $message->delete();
        return response()->json(null, 204);
    }
}
