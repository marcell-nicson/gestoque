<?php

namespace App\Http\Controllers;

use App\Events\ProdutoCriado;
use App\Http\Requests\StoreOfertaRequest;
use App\Models\Produto;
use App\Services\OfertaService;
use App\Services\Uzapi;
use Exception;
use Illuminate\Http\Request;

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
        // $produtos = Produto::all();
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
            $validatedData = $request->validated();
    
            $produto = $this->ofertaService->storeOferta($validatedData);


            if ($produto) {
                
                $this->ofertaService->sendText($validatedData['grupo_id'], $this->ofertaService->formatMessage($produto->toArray()));
                
                // event(new ProdutoCriado($produto));
            }
            
    
            return redirect()->route('produtos.index')->with('success', 'Oferta criada com sucesso.');
    
        } catch (Exception $e) {
            info($e);
            return redirect()->route('produtos.index')->with('danger', 'Erro ao Criar Oferta.');
        }
    }

}
