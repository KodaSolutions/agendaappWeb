<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment2 extends Model
{
    use HasFactory;
    protected $fillable = [
        'form_template_id', 
        'form_data',
        'appointment_date',
        'status'
    ];
    
    protected $casts = [
        'form_data' => 'array',
        'appointment_date' => 'datetime'
    ];
    
    public function formTemplate(){
        return $this->belongsTo(FormTemplate::class);
    }
}
