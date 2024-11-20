<?php

namespace App\Http\Controllers\Inventory;

use Illuminate\Http\Request;
use App\Models\Inventory\Stock;
use App\Models\Inventory\MovimientosStock;
use App\Http\Controllers\Controller;
use App\Models\Inventory\Venta;
use App\Models\Inventory\VentaDetalle;
use DB;
use Carbon\Carbon;
class CartController extends Controller
{
    public function store(Request $request){
        $request->validate([
            'carrito' => 'required|array',
            'carrito.*.producto_id' => 'required|exists:productos,id',
            'carrito.*.cant_cart' => 'required|integer|min:1'
        ]);
        $cantidadProductos = count($request->carrito);
        DB::beginTransaction();
        try {
            $total = 0;
            $venta = Venta::create([
                'usuario_id' => auth()->user()->id ?? null,
                'created_at' => now(),
                'total' => 0,
                'cantidad' => $cantidadProductos,
            ]);
            foreach ($request->carrito as $item) {
                $producto_id = $item['producto_id'];
                $cantidad = $item['cant_cart'];
                $stock = Stock::where('producto_id', $producto_id)->first();
                if(!$stock || $stock->cantidad < $cantidad){
                    DB::rollBack();
                    return response()->json([
                        'success' => false,
                        'message' => "No hay suficiente stock para el producto $producto_id"
                    ], 400);
                }

                $precio = $stock->producto->precio;
                $total += $precio * $cantidad;
                VentaDetalle::create([
                    'venta_id' => $venta->id,
                    'producto_id' => $producto_id,
                    'cantidad' => $cantidad,
                    'precio' => $precio
                ]);
                $stock->decrement('cantidad', $cantidad);
                MovimientosStock::create([
                    'producto_id' => $producto_id,
                    'cantidad' => $cantidad,
                    'tipo_movimiento' => 'venta',
                    'usuario_id' => auth()->user()->id ?? null
                ]);
            }
            $venta->update(['total' => $total]);
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Venta realizada y guardada correctamente'
            ], 201);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error procesando la venta: ' . $e->getMessage()
            ], 500);
        }

    }
    public function getVentasPorCarrito(Request $request){

      $fechaInicio = $request->input('fecha_inicio');

      $fechaFin = $request->input('fecha_fin') 
                  ? Carbon::parse($request->input('fecha_fin'))->endOfDay() 
                 : now()->endOfDay();
      if($fechaInicio){
          $ventas = Venta::with('detalles.producto')->whereBetween('created_at', [$fechaInicio, $fechaFin])->get();
      }else{
        $ventas = Venta::with('detalles.producto')->get();
        }
        //date_default_timezone_set('America/Mexico_City');
        //$currentTimezone = date_default_timezone_get();
        //$fecha = now();
        return response()->json($ventas);
    }
    public function getVentasPorProducto(Request $request){
        $fechaInicio = $request->input('fecha_inicio') 
                       ? Carbon::parse($request->input('fecha_inicio'))->startOfDay() 
                       : now()->startOfDay();
        $fechaFin = $request->input('fecha_fin') 
                    ? Carbon::parse($request->input('fecha_fin'))->endOfDay() 
                    : now()->endOfDay();
        $productoId = $request->input('producto_id');
        $query = VentaDetalle::with('producto', 'venta')->whereHas('venta', function($q) use ($fechaInicio, $fechaFin){
                $q->whereBetween('created_at', [$fechaInicio, $fechaFin]);
        });
        if ($productoId) {
            $query->where('producto_id', $productoId);
        }
        $ventas = $query->get();
        return response()->json($ventas);
    }

}
