<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Entrada;
use App\Models\Grupo;
use App\Models\Marca;
use App\Models\Produto;
use App\Models\Saida;
use App\Services\EvolutionApi;
use App\Services\OfertaService;
use App\Services\Uzapi;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;

class ProdutoController extends Controller
{

    // Listar produtos
    public function index(Request $request)
    {
        
        $categorias = Categoria::pluck('nome', 'id');       
        $marcas = Marca::pluck('nome', 'id');
    
        if ($request->filled('search')) {
            $query = Produto::with(['categoria', 'marca']);
            $searchTerms = explode(' ', $request->search);
            
            foreach ($searchTerms as $term) {
                $query->where(function($q) use ($term) {
                    $q->where('nome', 'like', '%' . $term . '%')
                      ->orWhereHas('categoria', function($q) use ($term) {
                          $q->where('nome', 'like', '%' . $term . '%');
                      })
                      ->orWhereHas('marca', function($q) use ($term) {
                          $q->where('nome', 'like', '%' . $term . '%');
                      });
                });
            }            
            $produtos = $query->get();

            return view('produtos.index', compact('produtos', 'categorias', 'marcas'));
        }      

        $produtos = Produto::listadeprodutos(); 
        return view('produtos.index', compact('produtos', 'categorias', 'marcas'));
    }
    
 
    public function store(Request $request)
    {
        try {


            $validatedData = $request->validate([
                'nome' => 'required|string|max:255',
                'promocao' => 'nullable' ?? 0,
                'descricao' => 'nullable',
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
        
            Produto::create($data);
            return redirect()->route('produtos.index')->with('success', 'Produto criado com sucesso.');

        } catch (Exception $e) {
            info($e);
            return redirect()->route('produtos.index')->with('danger', 'Erro ao Criar Produto');

        }

    }

    // Mostrar detalhes do produto
    public function show($id)
    {
        $produto = Produto::findOrFail($id);
        

        return view('produtos.show', compact('produto'));
    }

    // Formulário para editar produto
    public function edit($id)
    {
        $produtos = Produto::all();
       
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

    
            $pro = Produto::whereId($id)->update($data);
            return redirect()->route('produtos.index')->with('success', 'Produto atualizado com sucesso.');

        } catch (Exception $e) {
           info($e);
           return redirect()->route('produtos.index')->with('danger', 'Erro ao Atualizar Produto');

        }
       
    }

    // Excluir produto
    public function destroy($id)
    {
        $produto = Produto::findOrFail($id);
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
        $produto = Produto::findOrFail($id);
        
        $grupos = Grupo::all();
        $evolutionApi = new EvolutionApi();
        $ofertaService = new OfertaService();

        $mensagem = $ofertaService->formatMessage($produto->toArray());

        foreach ($grupos as $grupo) {
            try {
                
                $resposta = $evolutionApi->sendText($grupo->grupo_id, $mensagem);
                info($resposta);

            } catch (Exception $e) {
                Log::error("Falha ao enviar mensagem para o grupo {$grupo->grupo_id}: " . $e->getMessage());
                
                break; 
            }
            sleep(4);
        }  
        
        return redirect()->route('produtos.index')->with('success', 'Produto reenviado com sucesso.');

    }


}