<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grupo extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome', 
        'grupo_id', 
        'descricao',
        'categoria_id'
    ];

    public function allgroups()
    {
        return $this->all();
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }
}
