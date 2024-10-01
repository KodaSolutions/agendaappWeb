<?php

namespace App\Http\Controllers\Inventory;

use Illuminate\Http\Request;
use App\Http\Resources\CategoryResource;
use App\Models\Inventory\Category;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function index(Request $request){
        $limit = $request->get('limit', 6);
        $offset = $request->get('offset', 0);
        $categories = Category::skip($offset)->take($limit)->get();
        return CategoryResource::collection($categories);
    }
    public function store(Request $request){
        // Validar los datos
        $request->validate([
            'nombre' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = [
            'nombre' => $request->nombre,
        ];

        // Procesar la imagen si fue subida
        if ($request->hasFile('foto')) {
            // Obtener el archivo subido
            $file = $request->file('foto');

            // Subir a Dropbox
            $path = Storage::disk('dropbox')->putFile('categories', $file);

            // Obtener la URL pública del archivo
            $link = Storage::disk('dropbox')->getDriver()->createSharedLinkWithSettings($path);

            // Guardar la URL en la base de datos
            $data['foto'] = str_replace('dl=0', 'raw=1', $link['url']);
        } else {
            // Asignar una imagen predeterminada
            $data['foto'] = 'https://example.com/default.jpg';
        }

        // Crear la categoría
        $category = Category::create($data);

        return response()->json($category, 201);
    }

    public function show($id){
        $category = Category::findOrFail($id);

        return response()->json($category);
    }

    public function update(Request $request, $id){
        $request->validate([
            'nombre' => 'required|string|max:255'
        ]);
        $category = Category::findOrFail($id);
        $category->update($request->all());

        return response()->json($category);
    }

    public function destroy($id){
        $category = Category::findOrFail($id);
        $category->delete();

        return response()->json(null, 204);
    }
}
