<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venda extends Model
{
    use HasFactory;

    protected $fillable = [
        'valor_venda',
        'produto_id',
        'desconto',
        'porcentagem',
        'tipo_pagamento',
        'troca',
        'cliente_id'
    ];

    public function produto()
    {
        return $this->hasMany(Produto::class);
    }

    public function cliente()
    {
        return $this->hasMany(Cliente::class);
    }
}
