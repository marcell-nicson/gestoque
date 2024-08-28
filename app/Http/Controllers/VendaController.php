<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use App\Models\Venda;
use Illuminate\Http\Request;
use App\Models\Saida;

class VendaController extends Controller
{
    public function index()
    {
        $vendas = Venda::all();
        $produtos = Produto::all();

        return view('vendas.index', compact('vendas', 'produtos'));
    }

    public function store(Request $request)
    {


        // Validação dos dados
        $validatedData = $request->validate([
            'items' => 'required|array',
            'items.*.produto_id' => 'required|exists:produtos,id',
            'items.*.quantidade' => 'required|integer|min:1',
            'tipo_pagamento' => 'required|string',
            'cliente_id' => 'required|exists:clientes,id',
            'desconto' => 'nullable|numeric',
            'porcentagem' => 'nullable|numeric',
            'troca' => 'nullable|boolean'
        ]);

        $valorTotal = 0;

        // Criação dos itens da venda (Saidas)
        foreach ($validatedData['items'] as $itemData) {
            $produto = Produto::findOrFail($itemData['produto_id']);
            $itemValor = $produto->valor * $itemData['quantidade'];
            $valorTotal += $itemValor;

        }


        // Criação da venda
        $venda = Venda::create([
            'valor_venda' => $valorTotal,
            'tipo_pagamento' => $validatedData['tipo_pagamento'],
            'cliente_id' => $validatedData['cliente_id'],
            'desconto' => $validatedData['desconto'] ?? 0,
            'porcentagem' => $validatedData['porcentagem'] ?? 0,
            'troca' => $validatedData['troca'] ?? false,
        ]);

  
        // Redirecionamento ou retorno de resposta apropriada
        return redirect()->route('vendas.index')->with('success', 'Venda criada com sucesso!');
    }

    public function finalizarCompra(Request $request)
    {

        
        $saidas = Saida::all();


        $valorTotal = $saidas->sum(function ($item) {
            return $item->produto->valor * $item->quantidade;
        });

        $desconto = $valorTotal * 0.20;
        $valorFinal = $valorTotal - $desconto;

        $venda = new Venda();
        $venda->valor_venda = $valorFinal;
        $venda->desconto = $desconto;
        $venda->save();


        // Redirecione para a página de vendas com uma mensagem de sucesso
        return redirect()->route('vendas.index')->with('success', 'Compra finalizada com sucesso!');
    }
}

