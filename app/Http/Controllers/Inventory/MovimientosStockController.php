<?php

namespace App\Http\Controllers\Inventory;

use Illuminate\Http\Request;
use App\Http\Resources\MovimientosResource;
use App\Models\Inventory\MovimientosStock;
use App\Http\Controllers\Controller;

class MovimientosStockController extends Controller
{
    public function index(){
        return MovimientosResource::collection(MovimientosStock::with(['producto', 'usuario'])->get());
    }
}
