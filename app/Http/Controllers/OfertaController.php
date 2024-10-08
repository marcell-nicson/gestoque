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
            $mensagem = $this->ofertaService->formatMessage($produto->toArray());

            if ($produto) {

                // $grupos = Grupo::all();
                // $evolutionApi = new EvolutionApi();
                // $ofertaService = new OfertaService();
    
                // $mensagem = $ofertaService->formatMessage($produto->toArray());
        
                // foreach ($grupos as $grupo) {
                //     try {
                        
                //         $resposta = $evolutionApi->sendText($grupo->grupo_id, $mensagem);
                //         info($resposta);
    
                //     } catch (Exception $e) {
                //         Log::error("Falha ao enviar mensagem para o grupo {$grupo->grupo_id}: " . $e->getMessage());
                        
                //         break; 
                //     }
                //     sleep(4);
                // }            
                event(new ProdutoCriado($produto));
            }
            
    
            return redirect()->route('produtos.index')->with('success', 'Oferta criada com sucesso.');
    
        } catch (Exception $e) {
            info($e);
            return redirect()->route('produtos.index')->with('danger', 'Erro ao Criar Oferta.');
        }
    }

    public function lista()
    {
        $service = new MercadoLivreApi();
    
        if (!$service->isAccessTokenValid()) {
            $service->refreshAccessToken(); 
        }
    
        $jsonResponse = $service->getOfertas();
        $json = $jsonResponse->getData(true);

        if ($jsonResponse->status() != 200) {
            return redirect()->route('ofertas.lista')->with('error', $jsonResponse->content());
        }       
    
        $filtradas = [];
        foreach ($json['results'] as $result) {
            $filtradas[] = [
                'id' => $result['id'],
                'title' => $result['title'],
                'category_id' => $result['category_id'],
                'thumbnail' => $result['thumbnail'],
                'price' => $result['price'],
                'original_price' => $result['original_price'],
                'image' => 'http://http2.mlstatic.com/D_NQ_NP_' . $result['thumbnail_id'] . '-O.webp'
            ];
        }
    
        return view('ofertas.lista', compact('filtradas'));
    }
    
    

}
