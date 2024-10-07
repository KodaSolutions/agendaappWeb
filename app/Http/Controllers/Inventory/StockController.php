<?php

namespace App\Http\Controllers\Inventory;

use Illuminate\Http\Request;
use App\Http\Resources\StockResource;
use App\Models\Inventory\Stock;
use App\Http\Controllers\Controller;
use App\Models\Inventory\MovimientosStock;

class StockController extends Controller
{
    public function index(){
        return StockResource::collection(Stock::with('producto')->get());
    }
  public function store(Request $request)
    {
        $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'cantidad' => 'required|integer',
            'estado' => 'nullable|string'
        ]);

        // Actualizar el stock del producto o crearlo si no existe
        $stock = Stock::where('producto_id', $request->producto_id)->first();
        
        if ($stock) {
            $stock->increment('cantidad', $request->cantidad);
        } else {
            $stock = Stock::create($request->all());
        }

        // Registrar el movimiento
        MovimientosStock::create([
            'producto_id' => $request->producto_id,
            'cantidad' => $request->cantidad,
            'tipo_movimiento' => 'alta',  // En este caso se registraría como alta
            'usuario_id' => auth()->user()->id ?? null
        ]);

        return response()->json($stock, 201);
    }

    public function show($id)
    {
        $stock = Stock::with('producto')->findOrFail($id);
        return response()->json($stock, 200);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'cantidad' => 'required|integer',
            'estado' => 'nullable|string'
        ]);

        $stock = Stock::findOrFail($id);
        $stock->update($request->all());

        return response()->json($stock, 200);
    }

    public function destroy($id)
    {
        $stock = Stock::findOrFail($id);
        $stock->delete();

        return response()->json(null, 204);
    }
}
