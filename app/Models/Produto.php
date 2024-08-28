<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'status',
        'marca',
        'valor',
        'promocao',
        'descricao',
        'categoria_id',
        'marca_id',
        'codigo_produto',
        'image',
        'tipo', 
        'link',
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function marca()
    {
        return $this->belongsTo(Marca::class);
    }

    public function entrada()
    {
        return $this->hasMany(Entrada::class);
    }

    public function quantidade()
    {
        return $this->entrada()->where('status', 'ativo')->sum('quantidade');
    }

    public static function listadeprodutos()
    {
        return self::with(['categoria', 'marca'])->orderBy('created_at', 'desc')->get();
    }


    public function vendas()
    {
        return $this->belongsTo(Venda::class);
    }

}
