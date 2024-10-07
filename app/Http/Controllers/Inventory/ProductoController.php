<?php

namespace App\Http\Controllers\Inventory;

use Illuminate\Http\Request;
use App\Models\Inventory\Producto;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductoResource;
use App\Models\Inventory\Stock;
use App\Models\Inventory\MovimientosStock;
class ProductoController extends Controller
{
    public function index(Request $request){
        $category_id = $request->query('category_id');
        if ($category_id) {
            $productos = Producto::where('category_id', $category_id)->with('stock')->get();
        } else {
            $productos = Producto::with('stock')->get();
        }

        return ProductoResource::collection($productos);
    }
    public function store(Request $request){
        $request->headers->set('Accept', 'application/json');
        $validatedData = $request->validate([
            'nombre' => 'required',
            'precio' => 'required|numeric',
            'codigo_barras' => 'required|unique:productos,codigo_barras',
            'descripcion' => 'nullable|string',
            'category_id' => 'nullable|integer',
        ], 
        [
            'nombre.required' => 'El nombre del producto es obligatorio',
            'precio.required' => 'El precio es obligatorio',
            'precio.numeric' => 'El precio debe ser un número',
            'codigo_barras.required' => 'El código de barras es obligatorio',
            'codigo_barras.unique' => 'El código de barras ya está registrado, debe ser único',
            'descripcion.string' => 'La descripción debe ser un texto',
            'category_id.integer' => 'El ID de la categoría debe ser un número entero',
        ]);
     try {
            $producto = Producto::create($validatedData);
            
            // Verificar si el producto ya tiene stock
            $stock = Stock::where('producto_id', $producto->id)->first();
            
            if ($stock) {
                // Si el producto ya tiene stock, aumentamos la cantidad en 1
                $stock->increment('cantidad', 1);
            } else {
                // Si no hay stock, creamos un nuevo registro con cantidad inicial 1
                Stock::create([
                    'producto_id' => $producto->id,
                    'cantidad' => 1,
                    'estado' => 'disponible'
                ]);
            }

            // Registrar el movimiento de stock
            MovimientosStock::create([
                'producto_id' => $producto->id,
                'cantidad' => 1,
                'tipo_movimiento' => 'alta', // Se define como alta de producto
                'usuario_id' => auth()->user()->id ?? null // O el ID del usuario si está autenticado
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Producto creado y stock actualizado exitosamente',
                'data' => $producto
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al crear el producto: ' . $e->getMessage(),
            ], 500);
        }
    }

    public  function show($id){
        $id = (int) $id;
        $producto = Producto::findOrFail($id);
        return response()->json($producto);
    }
    public function update(Request $request, $id){
        $id = (int) $id;
        $request->validate([
            'nombre' => 'required']);
        $producto = Producto::findOrFail($id);
        $producto->update($request->all());
        return response()->json($producto);
    }
    public function destroy($id){
        $producto = Producto::findOrFail($id);
        $producto->delete();

        return response()->json(null, 204);
    }
}
