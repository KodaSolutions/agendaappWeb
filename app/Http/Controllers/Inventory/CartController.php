<?php

namespace App\Http\Controllers\Inventory;

use Illuminate\Http\Request;
use App\Models\Inventory\Stock;
use App\Models\Inventory\MovimientosStock;
use App\Http\Controllers\Controller;

class CartController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'carrito' => 'required|array',
            'carrito.*.producto_id' => 'required|exists:productos,id',
            'carrito.*.cant_cart' => 'required|integer|min:1'
        ]);
        foreach($request->carrito as $item){
            $producto_id = $item['producto_id'];
            $cantidad = $item['cant_cart'];
            $stock = Stock::where('producto_id', $producto_id)->first();
            if (!$stock || $stock->cantidad < $cantidad) {
                return response()->json([
                    'success' => false,
                    'message' => "No hay suficiente stock para el producto con ID $producto_id"
                ], 400);
            $stock->decrement('cantidad', $cantidad);
            MovimientosStock::create([
                'producto_id' => $producto_id,
                'cantidad' => $cantidad,
                'tipo_movimiento' => 'venta',
                'usuario_id' => auth()->user()->id ?? null
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Venta procesada y stock actualizado correctamente.'
        ], 201);
    }
}
