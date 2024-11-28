<?php

namespace App\Http\Controllers\Inventory;

use Illuminate\Http\Request;
use App\Http\Resources\CategoryResource;
use App\Models\Inventory\Category;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Spatie\Dropbox\Client as DropboxClient;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $limit = $request->get('limit', 6);
        $offset = $request->get('offset', 0);
        $categories = Category::skip($offset)->take($limit + 1)->get();
        if($categories->count() > $limit){
            $categories->pop();
        }
        $categories->push(new Category(['nombre' => 'addCat']));
        return CategoryResource::collection($categories);
    }


    public function store(Request $request){
        $request->headers->set('Accept', 'application/json');
        $request->validate([
            'nombre' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $data = [
            'nombre' => $request->nombre,
        ];
        if($request->hasFile('foto')){
            $file = $request->file('foto');
            $path = Storage::disk('dropbox')->putFile('categories', $file);
            $dropboxClient = new DropboxClient(env('DROPBOX_AUTH_TOKEN'));
            $sharedLink = $dropboxClient->createSharedLinkWithSettings($path);
            $data['foto'] = str_replace('dl=0', 'raw=1', $sharedLink['url']);
        }else{
            $data['foto'] = 'https://example.com/default.jpg';
        }
        $category = Category::create($data);

        return response()->json($category, 201);
    }


    public function show($id){
        $category = Category::findOrFail($id);

        return response()->json($category);
    }

    public function update(Request $request, $id){
        $request->headers->set('Accept', 'application/json');

        \Log::info('Datos recibidos en la solicitud:', $request->all());

        $request->validate(
            [
                'nombre' => 'required|string|max:255',
                'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ],
            [
                'nombre.required' => 'El campo "nombre" es obligatorio.',
                'nombre.string' => 'El campo "nombre" debe ser una cadena de texto.',
                'nombre.max' => 'El campo "nombre" no puede exceder los 255 caracteres.',
                'foto.image' => 'El archivo de "foto" debe ser una imagen.',
                'foto.mimes' => 'El archivo de "foto" debe ser de tipo jpeg, png, jpg o gif.',
                'foto.max' => 'El archivo de "foto" no debe superar los 2048 KB.',
            ]
        );

        $category = Category::findOrFail($id);
        \Log::info('Categoría encontrada:', $category->toArray());

        if ($request->filled('nombre')) {
            \Log::info('Actualizando nombre:', ['nombre' => $request->nombre]);
            $category->nombre = $request->nombre;
        }
        if ($request->hasFile('foto')) {
            try {
                if ($category->foto && filter_var($category->foto, FILTER_VALIDATE_URL)) {
                    $existingPath = str_replace('https://www.dropbox.com/', '', str_replace('?raw=1', '', $category->foto));
                    Storage::disk('dropbox')->delete($existingPath);
                }

                $file = $request->file('foto');
                $path = Storage::disk('dropbox')->putFile('categories', $file);
                $dropboxClient = new DropboxClient(env('DROPBOX_AUTH_TOKEN'));
                $sharedLink = $dropboxClient->createSharedLinkWithSettings($path);
                $category->foto = str_replace('dl=0', 'raw=1', $sharedLink['url']);
                \Log::info('Foto actualizada en Dropbox:', ['foto' => $category->foto]);
            } catch (\Exception $e) {
                \Log::error('Error al procesar la foto:', ['message' => $e->getMessage()]);
                return response()->json(['error' => 'Hubo un problema al actualizar la foto.'], 500);
            }
        }

        $category->save();

        return response()->json($category);
    }



    public function destroy(Request $request, $id){
        $request->headers->set('Accept', 'application/json');
        try {
            $category = Category::findOrFail($id);
            $category->delete();
            return response()->json(null, 204);
            
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Error al eliminar categoria',
                'error' => $e->getMessage()
            ], 500);
        }

    }
}
