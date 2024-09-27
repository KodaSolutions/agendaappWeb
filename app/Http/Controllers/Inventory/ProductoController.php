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
}