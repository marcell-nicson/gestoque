<?php

namespace App\Helpers;

use App\Models\Entrada;
use App\Models\Produto;
use App\Models\Saida;
use Exception;

function calculoEntradaeSaida($fornecedorId, $produtosId)
{


    $valorEntrada = Entrada::where('fornecedor_id', $fornecedorId)
    ->where('produto_id', $produtosId)
    ->where('status', 'ativo')
    ->sum('quantidade');

    $valorSaida = Saida::where('produto_id', $produtosId)
            ->sum('quantidade');

    $totalProduto = $valorEntrada - $valorSaida;

    return $totalProduto ? $totalProduto : 0000;
        

}

function listarprodutos()
{    
    return Produto::all()->pluck('nome', 'id');
};
