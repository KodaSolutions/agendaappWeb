<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;

    protected $fillable = ['usuario_id', 'fecha', 'total', 'cantidad'];

    public function detalles(){
        return $this->hasMany(VentaDetalle::class);
    }
}
