<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VentaDetalle extends Model
{
    use HasFactory;
    protected $fillable = ['venta_id', 'producto_id', 'cantidad', 'precio'];

    public function venta() {
        return $this->belongsTo(Venta::class);
    }

    public function producto(){
        return $this->belongsTo(Producto::class)->withDefault();
    }
}