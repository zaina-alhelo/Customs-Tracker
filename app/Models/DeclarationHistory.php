<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeclarationHistory extends Model
{
    use HasFactory;
    protected $table = 'declaration_history'; 
    protected $fillable = [
        'user_id', 'declaration_id', 'action', 
    ];

    public function customDeclaration()
    {
        return $this->belongsTo(CustomDeclaration::class, 'declaration_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
