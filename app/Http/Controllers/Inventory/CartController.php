<?php

namespace App\Http\Controllers\Inventory;

use Illuminate\Http\Request;
use App\Models\Inventory\Stock;
use App\Models\Inventory\MovimientosStock;
use App\Http\Controllers\Controller;
use DB;
class CartController extends Controller
{
    public function store(Request $request){
        $request->validate([
            'carrito' => 'required|array',
            'carrito.*.producto_id' => 'required|exists:productos,id',
            'carrito.*.cant_cart' => 'required|integer|min:1'
        ]);
        DB::beginTransaction();
        try {
            foreach($request->carrito as $item){
                $producto_id = $item['producto_id'];
                $cantidad = $item['cant_cart'];
                $stock = Stock::where('producto_id', $producto_id)->first();
                if (!$stock || $stock->cantidad < $cantidad) {
                    DB::rollBack();
                    return response()->json([
                        'success' => false,
                        'message' => "No hay suficiente stock para el producto $producto_id"
                    ], 400);
                }
                $stock->decrement('cantidad', $cantidad);
                MovimientosStock::create([
                    'producto_id' => $producto_id,
                    'cantidad' => $cantidad,
                    'tipo_movimiento' => 'venta',
                    'usuario_id' => auth()->user()->id ?? null
                ]);
                DB::commit();
                return response()->json([
                    'success' => true,
                    'message' => 'Venta realizada y stock actualizado correctamente'
                ], 201);
            }
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error procesando la venta: ' . $e->getMessage()
            ], 500);
        }

    }

}
