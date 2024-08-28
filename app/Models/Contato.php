<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contato extends Model
{
    protected $fillable = [
        'telefone',
        'whatsapp',
        'email',
    ];

    public function fornecedor()
    {
        return $this->hasOne(Fornecedor::class);
    }
}
