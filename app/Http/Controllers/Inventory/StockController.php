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
        $stock = Stock::where('producto_id', $request->producto_id)->first();
        if($stock){
            if($request->cantidad > 0){
                $stock->increment('cantidad', $request->cantidad);
                MovimientosStock::create([
                    'producto_id' => $request->producto_id,
                    'cantidad' => $request->cantidad,
                    'tipo_movimiento' => 'alta',
                    'usuario_id' => auth()->user()->id ?? null
                ]);
            }else{
                $abs_cant = abs($request->cantidad);
                if ($stock->cantidad >= $abs_cant) {
                    $stock->decrement('cantidad', $abs_cant);
                    MovimientosStock::create([
                        'producto_id' => $request->producto_id,
                        'cantidad' => $abs_cant,
                        'tipo_movimiento' => 'baja',
                        'usuario_id' => auth()->user()->id ?? null,
                        'estatus' => 'pendiente'
                    ]);
                }else{
                    return response()->json([
                        'success' => false,
                        'message' => 'No hay suficiente stock para realizar esta baja'
                    ], 400);
                }
            }
        }else{
            $stock = Stock::create([
                'producto_id' => $request->producto_id,
                'cantidad' => max($request->cantidad, 0),
                'estado' => $request->estado ?? 'disponible'
            ]);
            MovimientosStock::create([
                'producto_id' => $request->producto_id,
                'cantidad' => $request->cantidad,
                'tipo_movimiento' => 'alta',
                'usuario_id' => auth()->user()->id ?? null
            ]);
        }

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
