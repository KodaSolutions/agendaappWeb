<?php

namespace App\Http\Controllers\Inventory;

use Illuminate\Http\Request;
use App\Models\Inventory\Producto;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductoResource;
use App\Models\Inventory\Stock;
use App\Models\Inventory\MovimientosStock;
use App\Models\Inventory\Category;
use App\Http\Resources\CategoryResource;
class ProductoController extends Controller
{
    public function index(Request $request){
        $category_id = $request->query('category_id');
        if($category_id){
            $productos = Producto::where('category_id', $category_id)->with('stock')->get();
        } else{
            $productos = Producto::with('stock')->get();
        }

        return ProductoResource::collection($productos);
    }
    public function searchByBCode(Request $request){
        $barCode = $request->query('barCode');
        $producto = Producto::where('codigo_barras', $barCode)->with('stock')->get();

        return ProductoResource::collection($producto);
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
        try{
            $producto = Producto::create($validatedData);
            $stock = Stock::where('producto_id', $producto->id)->first();
            if($stock){
                $stock->increment('cantidad', 1);
            }else{
                Stock::create([
                    'producto_id' => $producto->id,
                    'cantidad' => 1,
                    'estado' => 'disponible'
                ]);
            }
            MovimientosStock::create([
                'producto_id' => $producto->id,
                'cantidad' => 1,
                'tipo_movimiento' => 'alta',
                'usuario_id' => auth()->user()->id ?? null
            ]);
            return response()->json([
                'success' => true,
                'message' => 'Producto creado y stock actualizado exitosamente',
                'data' => $producto
            ], 201);

        } catch(\Exception $e){
            return response()->json([
                'success' => false,
                'message' => 'Error al crear el producto: ' . $e->getMessage(),
            ], 500);
        }
    }

    public  function show($id){
        $id = (int) $id;
        $producto = Producto::with('stock')->findOrFail($id);
         return response()->json(['success' => true,
            'data' => [
                'id' => $producto->id,
                'nombre' => $producto->nombre,
                'descripcion' => $producto->descripcion,
                'precio' => $producto->precio,
                'codigo_barras' => $producto->codigo_barras,
                'category_id' => $producto->category_id,
                'stock' => [
                    'cantidad' => $producto->stock->cantidad ?? 0,
                    'estado' => $producto->stock->estado ?? 'no disponible'
                ]
            ]
        ]);
    }
    public function update(Request $request, $id){
        $request->headers->set('Accept', 'application/json');
        $validatedData = $request->validate([
            'nombre' => 'required',
            'precio' => 'required|numeric',
            'codigo_barras' => 'required|unique:productos,codigo_barras,' . $id,
            'descripcion' => 'nullable|string',
            'category_id' => 'required|integer',
            'cant' => 'nullable|integer'
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
        $id = (int) $id;
        try{
            $producto = Producto::findOrFail($id);
            $cant = $request->input('cant');
            $stock = Stock::where('producto_id', $producto->id)->first();
            if(!$stock){
                $stock = Stock::create([
                    'producto_id' => $producto->id,
                    'cantidad' => 0,
                    'estado' => 'disponible'
                ]);
            }
            if($cant){
                if($cant > 0){
                    //$stock->increment('cantidad', $cant);
                    $stock->cantidad = $cant;
                    $stock->save();
                    MovimientosStock::create([
                        'producto_id' => $producto->id,
                        'cantidad' => $cant,
                        'tipo_movimiento' => 'ajuste',
                        'usuario_id' => auth()->user()->id ?? null
                    ]);
                }else{
                    $abs_cant = abs($cant);
                    if($stock->cantidad >= $abs_cant){
                        $stock->decrement('cantidad', $abs_cant);
                        MovimientosStock::create([
                            'producto_id' => $producto->id,
                            'cantidad' => $abs_cant,
                            'tipo_movimiento' => 'ajuste',
                            'usuario_id' => auth()->user()->id ?? null,
                            'status' => 'pendiente'
                        ]);
                    } else {
                        return response()->json([
                            'success' => false,
                            'message' => 'No hay suficiente stock para realizar esta baja'
                        ], 400);
                    }
                }
            }
            $producto->update($validatedData);
        }catch(\Exception $e){
            return response()->json([
                'success' => false,
                'message' => 'Error al editar el producto: ' . $e->getMessage(),
            ], 500);
        }

        return response()->json([
            'success' => true,
            'message' => 'Producto actualizado y stock generado',
            'data' => $producto
        ]);
    }


    public function destroy($id){
        $producto = Producto::findOrFail($id);
        $producto->delete();

        return response()->json(null, 204);
    }
    public function search(Request $request){
        $searchQuery = $request->query('q', '');
        $categories = Category::where('nombre', 'LIKE', '%' . $searchQuery . '%')->get();
        $productos = Producto::where('nombre', 'LIKE', '%' . $searchQuery . '%')->get();

        return response()->json([
            'categories' => CategoryResource::collection($categories),
            'productos' => ProductoResource::collection($productos),
        ]);
    }
}
