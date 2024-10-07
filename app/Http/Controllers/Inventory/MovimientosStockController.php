<?php

namespace App\Http\Controllers\Inventory;

use Illuminate\Http\Request;
use App\Http\Resources\MovimientosResource;
use App\Models\Inventory\MovimientosStock;
use App\Http\Controllers\Controller;

class MovimientosStockController extends Controller
{
    public function index(){
      $movimientos = MovimientosStock::with(['producto', 'usuario'])->get();
        return response()->json($movimientos, 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'cantidad' => 'required|integer',
            'tipo_movimiento' => 'required|string',
            'usuario_id' => 'nullable|exists:users,id'
        ]);

        $movimiento = MovimientosStock::create($request->all());

        return response()->json($movimiento, 201);
    }

    public function show($id)
    {
        $movimiento = MovimientosStock::with(['producto', 'usuario'])->findOrFail($id);
        return response()->json($movimiento, 200);
    }

    public function update(Request $request, $id)
    {
        // Validar y actualizar un movimiento
        $request->validate([
            'cantidad' => 'required|integer',
            'tipo_movimiento' => 'required|string'
        ]);

        $movimiento = MovimientosStock::findOrFail($id);
        $movimiento->update($request->all());

        return response()->json($movimiento, 200);
    }

    public function destroy($id)
    {
        // Eliminar un movimiento de stock
        $movimiento = MovimientosStock::findOrFail($id);
        $movimiento->delete();

        return response()->json(null, 204);
    }
}
