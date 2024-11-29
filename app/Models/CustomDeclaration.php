<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomDeclaration extends Model
{
    
    use HasFactory;
protected $fillable = [
    'declaration_number', 'status',
];


    public function histories()
    {
        return $this->hasMany(DeclarationHistory::class, 'declaration_id');
    }
}
