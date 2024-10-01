<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    protected $table = 'clients';
    protected $fillable = [
        'name',
        'number',
        'email',
        'visit_count'
    ];
    public function getVisitCountAttribute(){
        return $this->attributes['visit_count'];
    }
}
