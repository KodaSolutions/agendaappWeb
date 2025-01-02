<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomMessage extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'content',
        'active'
    ];

    protected $casts = [
        'active' => 'boolean'
    ];
}
