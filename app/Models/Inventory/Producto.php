<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'descripcion', 'precio', 'codigo_barras', 'category_id'];

   public function stock(){
        return $this->hasOne(Stock::class, 'producto_id');
    }
    public function movimientos(){
        return $this->hasMany(MovimientosStock::class);
    }
    public function category(){
        return $this->belongsTo(Category::class);
    }
}
