<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MovimientosStock extends Model
{
    use HasFactory;
    protected $table = 'movimientos_stock';
    protected $fillable = ['producto_id', 'cantidad', 'tipo_movimiento', 'usuario_id', 'status'];
    public function producto(){
        return $this->belongsTo(Producto::class);
    }
    public function usuario(){
        return $this->belongsTo(User::class);
    }
}
