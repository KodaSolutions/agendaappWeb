<?php

namespace App\Http\Controllers\Inventory;

use Illuminate\Http\Request;
use App\Models\Inventory\Producto;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductoResource;
class ProductoController extends Controller
{
    public function index(){
        return ProductoResource::collection(Producto::with('stock')->get());
    }
    public function store(Request $request){
        $request->headers->set('Accept', 'application/json');
        $validatedData = $request->validate([
            'nombre' => 'required',
            'precio' => 'required|numeric',
            'codigo_barras' => 'required|unique:productos,codigo_barras',
            'descripcion' => 'nullable|string',
            'category_id' => 'nullable|integer',
        ], [
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

            return response()->json([
                'success' => true,
                'message' => 'Producto creado exitosamente',
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
