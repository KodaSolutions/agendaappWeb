<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormTemplate extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'fields'];
    protected $casts = [
        'fields' => 'array'
    ];
    
    public function appointments2(){
        return $this->hasMany(Appointment2::class);
    }
}
