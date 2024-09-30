<?php

namespace App\Http\Controllers\Inventory;

use Illuminate\Http\Request;
use App\Http\Resources\StockResource;
use App\Models\Inventory\Stock;
use App\Http\Controllers\Controller;

class StockController extends Controller
{
    public function index(){
        return StockResource::collection(Stock::with('producto')->get());
    }
}
