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
        $request->validate([
            'nombre'=> 'required',
            'precio' => 'required|integer',
            'codigo_barras' => 'required|']);
        $producto = Producto::create($request->all());
        return response()->json($producto, 200);
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
