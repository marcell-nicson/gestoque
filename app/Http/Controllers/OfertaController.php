<?php

namespace App\Http\Controllers;

use App\Events\ProdutoCriado;
use App\Http\Requests\StoreOfertaRequest;
use App\Models\Grupo;
use App\Models\Produto;
use App\Services\EvolutionApi;
use App\Services\MercadoLivreApi;
use App\Services\OfertaService;
use App\Services\Uzapi;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OfertaController extends Controller
{
    protected $ofertaService;

    public function __construct(OfertaService $ofertaService)
    {
        $this->ofertaService = $ofertaService;
    }
    
    public function index()
    {
        $produtos = Produto::where('tipo', 'afiliado')->whereNotNull('link')->orderBy('created_at', 'desc')->get();
        return view('ofertas.index', compact('produtos'));
    }

    public function show($id)
    {
        $produto = Produto::find($id);
        return view('ofertas.show', compact('produto'));

    }

    public function storeOferta(StoreOfertaRequest $request)
    {
        try {
            
            $this->ofertaService->storeOferta($request->validated());

            return redirect()->route('produtos.index')->with('success', 'Oferta criada com sucesso.');
    
        } catch (Exception $e) {
            info($e);
            return redirect()->route('produtos.index')->with('danger', 'Erro ao Criar Oferta.');
        }
    }


}
