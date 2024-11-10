<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Entrada;
use App\Models\Produto;
use App\Models\Saida;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    // public function index()
    // {
    //     //Quantidade de produtos por categorias
    //     $catData = Categoria::with('produto')->get();
    //     $catNome = [];
    //     $catTotal = [];
    //     $colors = [];

    //     foreach ($catData as $cat) {
        
    //         $total = $cat->produto->count();
    //         if ($total > 0) {
    //             $catNome[] = $cat->nome;
    //             $catTotal[] = $total;
    //             // Gera uma cor aleatória em formato hexadecimal
    //             $colors[] = sprintf('#%06X', mt_rand(0, 0xFFFFFF));
    //         }
    //     }
        
    //     $catLabel = json_encode($catNome);
    //     $catTotal = json_encode($catTotal);
    //     $colors = json_encode($colors);


    //     //

    //     return view('dashboard', compact('catLabel', 'catTotal', 'colors'));
    // }
    public function index()
    {

        // $produtosPorCat = $this->produtosPorCategorias(); 
        // $entradasEsaidas = $this->entradasEsaidas();
        // return view('dashboard', [
        //     'produtosLabels' => $produtosPorCat[0],
        //     'produtosVendas' => $produtosPorCat[1],
        //     'categoriasLabels' => $produtosPorCat[2],
        //     'categoriasEstoque' => $produtosPorCat[3],
        //     'categoriasColors' => $produtosPorCat[4],
        //     'months' => $entradasEsaidas[0],
        //     'entradas' => $entradasEsaidas[1],
        //     'saidas' => $entradasEsaidas[2],
        //     'porcentagem' => $entradasEsaidas[3],
        //     'totalentradasesaidas' => $entradasEsaidas[4]
        // ]);

        return view('produtos.index');
    }

    public function produtosPorCategorias()
    {   
        $produtosMaisVendidos = Produto::join('saidas', 'produtos.id', '=', 'saidas.produto_id')
            ->select('produtos.nome', DB::raw('SUM(saidas.quantidade) as total_vendido'))
            ->groupBy('produtos.nome')
            ->orderBy('total_vendido', 'desc')
            ->take(10)
            ->get();
        
        $produtosLabels = $produtosMaisVendidos->pluck('nome');
        $produtosVendas = $produtosMaisVendidos->pluck('total_vendido');

        $categorias = Categoria::withCount('produto')->get();

        $catTotal = [];
        $catNome = [];
        $catTotal = [];
        $colors = [];
        
        foreach ($categorias as $cat) {
            $total = $cat->produto->count();
            if ($total > 0) {
                $catNome[] = $cat->nome;
                $catTotal[] = $total;
                $colors[] = sprintf('#%06X', mt_rand(0, 0xFFFFFF));
            }  
        }
        
        return [
            $produtosLabels->toJson(),
            $produtosVendas->toJson(),
            json_encode($catTotal),
            json_encode($catNome),
            json_encode($colors)
        ];

    }


    public function entradasEsaidas()
    {
        $entradasMensais = Entrada::select(
            DB::raw('strftime(created_at, "%Y-%m") as month'),
            DB::raw('SUM(quantidade) as total_entradas')
        )
        ->where('status', 'ativo')
        ->groupBy('month')
        ->orderBy('month')
        ->get()
        ->pluck('total_entradas', 'month');
    
        $saidasMensais = Saida::select(
            DB::raw('strftime(created_at, "%Y-%m") as month'),
            DB::raw('SUM(quantidade) as total_saidas')
            
        )
        ->where('status', 'ativo')
        ->groupBy('month')
        ->orderBy('month')
        ->get()
        ->pluck('total_saidas', 'month');
    
        $months = [];
        $entradas = [];
        $saidas = [];
    
        foreach (range(0, 11) as $i) {
            $month = now()->subMonths($i)->format('Y-m');
            $months[] = $month;
            $entradas[] = $entradasMensais->get($month, 0);
            $saidas[] = $saidasMensais->get($month, 0);
        }
        $mesatual = now()->format('Y-m');
        $mesanterior = now()->subMonth()->format('Y-m');
    
        $atualEntradas = $entradasMensais->get($mesatual, 0);
        $anteriorEntradas = $entradasMensais->get($mesanterior, 0);
    
        $atualSaidas = $saidasMensais->get($mesatual, 0);
        $anteriorSaidas = $saidasMensais->get($mesanterior, 0);
    
        $mesatualTotal = $atualEntradas + $atualSaidas;
        $mesanteriorTotal = $anteriorEntradas + $anteriorSaidas;
    
        $porcentagem = $mesanteriorTotal > 0 ? (($mesatualTotal - $mesanteriorTotal) / $mesanteriorTotal) * 100 : ($mesatualTotal > 0 ? 100 : 0);
    
        $totalEntradasESaidas = ($entradasMensais->sum() + $saidasMensais->sum());
    
        return [
            json_encode(array_reverse($months)),
            json_encode(array_reverse($entradas)),
            json_encode(array_reverse($saidas)),
            round($porcentagem),
            $totalEntradasESaidas
        ];
    }
    


}


