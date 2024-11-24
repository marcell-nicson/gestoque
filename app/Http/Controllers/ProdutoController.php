<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProdutoRequest;
use App\Models\Categoria;
use App\Models\Entrada;
use App\Models\Grupo;
use App\Models\Marca;
use App\Models\Produto;
use App\Models\Saida;
use App\Services\EvolutionApi;
use App\Services\OfertaService;
use App\Services\ProdutoService;
use App\Services\Uzapi;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;

class ProdutoController extends Controller
{
    protected $service;
    protected $model;

    public function __construct(Produto $model, ProdutoService $service)
    {
        $this->service = $service;
        $this->model = $model;
    }

    public function index(Request $request)
    {       
        $dados = $this->service->index($request, $this->model);
        return view('produtos.index', $dados);
    }
 
    public function store(StoreProdutoRequest $request)
    {
        try {
            $result = $this->service->store($request->all());

            return redirect()
                ->route('produtos.index')
                ->with($result['status'], $result['message']);

        } catch (Exception $e) {
            info($e);
            return redirect()
                ->route('produtos.index')
                ->with('danger', $e->getMessage());

        }

    }

    // Mostrar detalhes do produto
    public function show($id)
    {
        $produto = $this->service->show($id);
        return view('produtos.show', compact('produto'));
    }

    public function ofertas()
    {
        $produtos = $this->service->ofertas();
        return view('ofertas.index', compact('produtos'));
    }

    public function showOferta($id)
    {
        $produto = $this->service->show($id);        
        return view('ofertas.show', compact('produto'));
    }

    // Formulário para editar produto
    public function edit($id)
    {
        $produtos = $this->model::all();       
        return view('produtos.index', compact('produtos'));
    }

    // Atualizar produto
    public function update(Request $request, $id)
    {

        try {
            $validatedData = $request->validate([
                'nome' => 'required|string|max:255',
                'promocao' => 'nullable' ?? 0,
                'descricao' => 'nullable' ?? 'Sem descricão',
                'valor' => 'nullable',
                'codigo_produto' => 'nullable',
                'categoria_id' => 'nullable',
                'tipo' => 'nullable',
                'link' => 'nullable',
                'marca_id' => 'nullable'
            ]);

            $data = $validatedData;

            if($request->file('image'))
            {
                $foto = $request->file('image');
                $nomeFoto = time() . '.' . $foto->getClientOriginalExtension();
                $foto->move(public_path('images'), $nomeFoto);
                $da['image'] = $nomeFoto; 
    
                $data = array_merge($validatedData, $da);
            }

    
            $pro = $this->model::whereId($id)->update($data);
            return redirect()->route('produtos.index')->with('success', 'Produto atualizado com sucesso.');

        } catch (Exception $e) {
           info($e);
           return redirect()->route('produtos.index')->with('danger', 'Erro ao Atualizar Produto');

        }
       
    }

    // Excluir produto
    public function destroy($id)
    {
        $produto = $this->model::findOrFail($id);
        $produto->delete();
        return redirect()->route('produtos.index')->with('success', 'Produto excluído com sucesso.');
    }

    public function calculoEntradaeSaida()
    {
        try {   

            $entradas = Entrada::all()->sum();

            $saidas = Saida::all();

            return $entradas;

        } catch (Exception $e) {
            info($e);
        }
    }

    public function reenviar($id)
    {
        $produto = $this->model::findOrFail($id);
        
        $grupos = Grupo::all();
        $evolutionApi = new EvolutionApi();

        $mensagem = $this->service->formatMessage($produto->toArray());

        foreach ($grupos as $grupo) {
            try {
                
                $regra = $grupo->nome == 'geral' || $produto->categoria_id === null;
            
                if ($regra || $produto->categoria_id == $grupo->categoria_id) {
                    $resposta = $evolutionApi->sendText($grupo->grupo_id, $mensagem);
                    info($resposta);
                    
                    $produto->status = 'enviado';
                    $produto->save(); 
                }

            } catch (Exception $e) {
                Log::error("Falha ao enviar mensagem para o grupo {$grupo->grupo_id}: " . $e->getMessage());
                
                break; 
            }
            sleep(4);
        }  
        
        return redirect()->route('produtos.index')->with('success', 'Produto reenviado com sucesso.');

    }


}