<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    use HasFactory;
    protected $table = 'user_details';
        protected $fillable = [
        'name',
        'role_id',
        'user_id',
        'age',
        'phone',
        'gender',
    ];
    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
