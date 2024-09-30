<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;
    protected $table = 'stock';
    protected $fillable = ['producto_id', 'cantidad', 'estado'];
    public function producto(){
        return $this->belongsTo(Producto::class);
    }
}
