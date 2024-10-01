<?php

namespace App\Http\Controllers\Inventory;

use Illuminate\Http\Request;
use App\Http\Resources\CategoryResource;
use App\Models\Inventory\Category;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function index(Request $request){
        $limit = $request->get('limit', 6);
        $offset = $request->get('offset', 0);
        $categories = Category::skip($offset)->take($limit)->get();
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
            $image = $request->file('foto');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('categories'), $imageName);
            $data['foto'] = 'categories/' . $imageName;
        } else{
            $data['foto'] = 'images/default.jpg'; 
        }
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
