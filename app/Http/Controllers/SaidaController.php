<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produto;
use App\Models\Saida;
use Exception;

class SaidaController extends Controller
{
    public function index()
    {
        $saidas = Saida::where('status', 'ativo')->with('produto')->get();

        $subtotal = $saidas->sum(function($item) { return $item->produto->valor * $item->quantidade; });
        $descontos = $saidas->sum(function($item) { return $item->produto->valor * $item->quantidade; }) * 0.20;
        $total = $saidas->sum(function($item) { return $item->produto->valor * $item->quantidade; }) * 0.80 + 5000;

        return view('saidas.index', compact('saidas', 'subtotal', 'descontos', 'total'));
    }

    public function adicionarMultiplos(Request $request)
    {
        try {

     

            $produtoIds = $request->input('produtos', []);
            $quantidade = 1;
        
            $saidas = [];
        
            foreach ($produtoIds as $produtoIdd) {
                $produto = Produto::findOrFail($produtoIdd);

                if(!$produto->quantidade()){
                    return redirect()->back()->with('danger', 'Não temos o produto '. $produto->nome . ' em estoque!');
                }

                if ($produto && $produto->quantidade() >= $quantidade) {
                    $saida = $this->adicionarAoCarrinho($produto->id, $quantidade);
                    $saidas[] = $saida;                    
                }
                
            }
           
            return redirect()->route('saidas.index', compact('saidas'))->with('success', 'Produtos adicionados ao carrinho com sucesso!');
        } catch (Exception $e) {
            info($e);
        }

    }
    
    public function adicionarAoCarrinho($produtoId, $quantidade)
    {
        $produto = Produto::findOrFail($produtoId);
    
        $item = Saida::where('produto_id', $produtoId)
                     ->where('status', 'ativo')
                     ->first();
    
        if ($item) {
            $item->quantidade += $quantidade;
        } else {
            $item = new Saida();
            $item->produto_id = $produto->id;
            $item->quantidade = $quantidade;
            $item->status = 'ativo';
        }
    
        $item->save();
    
        return $item;
    }

    public function remover($id)
    {
        $item = Saida::findOrFail($id);
        $item->delete();

        return redirect()->route('saidas.index');
    }

    public function ajustarQuantidade(Request $request, $id)
    {
        $item = Saida::findOrFail($id);
        $item->quantidade = $request->quantidade;

        $item->save();

        return redirect()->route('saidas.index');
    }
}
