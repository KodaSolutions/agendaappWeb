<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;
    protected $fillable = [
        'client_id',
        'created_by',
        'doctor_id',
        'appointment_date',
        'treatment_type',
        'status',
        'notification_read',
        'is_web',
        'is_approved',
        'pet_name',
        'species',
        'contact_number',
        'apptmType'
    ];
}
