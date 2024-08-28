<?php

namespace App\Http\Controllers;

use App\Http\Requests\RequestStoreFornecedor;
use App\Http\Requests\RequestUpdateFornecedor;
use App\Models\Fornecedor;
use App\Models\Endereco;
use App\Models\Contato;
use App\Models\Entrada;
use App\Models\Produto;
use App\Services\FornecedorService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use function App\Helpers\calculoEntradaeSaida;
use function App\Helpers\listarprodutos;

class FornecedorController extends Controller
{
    protected $fornecedorService;

    public function __construct(FornecedorService $fornecedorService)
    {
        $this->fornecedorService = $fornecedorService;
    }
    
    public function index(Request $request)
    {    
        $fornecedores = Fornecedor::with(['endereco', 'contato'])->get();
        $produtos = Produto::where('id', 30)->get();
        $porcentagem = 0;        

        if ($request->filled('search')) {

            $query = Fornecedor::query();
            $searchTerms = explode(' ', $request->search);
            
            foreach ($searchTerms as $term) {
                $query->where('nome', 'like', '%' . $term . '%');
            }

            $fornecedores = $query->get();
    
            return view('fornecedores.index', compact('fornecedores', 'produtos'));
        } 
        

        // $fornecedoresInfo = [];
        // foreach ($fornecedores as $fornecedor) {            
        //     $porcentagem = $this->quantidadeTotaldeProdutosPorFornecedor($fornecedor->id);

        //     $fornecedoresInfo[] = [
        //         'id' => $fornecedor->id,
        //         'nome' => $fornecedor->nome,
        //         'whatsapp' => $fornecedor->contato->whatsapp,
        //         'email' => $fornecedor->contato->email,
        //         'porcentagem' => $porcentagem,
        //         'status' => $fornecedor->status,
        //     ];
        // }

        // $produtosInfo = [];
        // foreach ($produtos as $produto) {            
        //     $produtosInfo[] = [
        //         'id' => $produto->id,
        //         'nome' => $produto->nome,
        //         'preco' => $produto->preco,
        //         'image' => $produto->image
                
        //     ];
        // }

        // $dados = [
        //     'fornecedores' => $fornecedoresInfo,
        //     'produtos' => $produtosInfo,
        // ];

        return view('fornecedores.index', compact('fornecedores', 'produtos'));
    }

    public function show($id)    
    {         
        $fornecedor = Fornecedor::find($id);

        $entradas = Entrada::where('fornecedor_id', $id)
                            ->orderBy('created_at', 'desc')
                            ->get();

        $entradaseprodutos = Entrada::where('entradas.fornecedor_id', $id)                          
                          ->select('produtos.id', 'produtos.nome')
                          ->join('produtos', 'produtos.id', '=', 'entradas.produto_id')
                          ->groupBy('produtos.id')->get();
                          

        $produtos = listarprodutos();

        $quantidadeprodutos = [];
        foreach ($entradaseprodutos as $produto) {
            
            $total = calculoEntradaeSaida($fornecedor->id, $produto->id);

            $quantidadeprodutos[] = 
            [
                'nome_produto' => $produto->nome,
                'total' => $total
            ];

        }

        return view('fornecedores.show', compact('fornecedor', 'entradas', 'produtos', 'quantidadeprodutos'));

    }


    public function quantidadeTotaldeProdutosPorFornecedor($fornecedorId)
    {
        $entradas = Entrada::where('fornecedor_id', $fornecedorId)->where('status', 'ativo')->select('quantidade')->get();
       
        $totalentradas = 0;
        foreach ($entradas as $entrada) {
            $totalentradas += $entrada->quantidade;
        }
        $total = round($totalentradas / 200) * 100;   
        $porcentagem = $total;

        return $porcentagem ? $porcentagem : 0;
    }

    public function create()    
    {
         
        return view('fornecedores.create');

    }

    public function store(RequestStoreFornecedor $request)
    {
        try {

            $fornecedor = $this->fornecedorService->store($request->all());
     
            return redirect()->route('fornecedores.index')->with('success', 'Fornecedor criado com sucesso.');

        } catch (Exception $e) {
            info($e);
            return redirect()->route('fornecedores.index')->with('danger', 'Erro ao Criar Fornecedor');
        }
    }

    public function edit($id)
    {
        $dadosDoFornecedor = Fornecedor::where('fornecedores.id', $id)
                                ->join('contatos', 'contatos.id', '=', 'fornecedores.contato_id')
                                ->join('enderecos', 'enderecos.id', '=', 'fornecedores.endereco_id')
                                ->first();
                                
      
        return view('fornecedores.edit', compact('dadosDoFornecedor'));

    }

    public function update(RequestUpdateFornecedor $request, $id)
    {
        try {
            DB::beginTransaction();
            
            $fornecedor = Fornecedor::with(['endereco', 'contato'])->findOrFail($id);

            $enderecoData = $request->only(['rua', 'numero', 'complemento', 'bairro', 'cidade', 'estado', 'cep']);
            if (!empty($enderecoData)) {
                $fornecedor->endereco->update($enderecoData);
            }
            $contatoData = $request->only(['telefone', 'whatsapp', 'email']);
            if (!empty($contatoData)) {
                $fornecedor->contato->update($contatoData);
            }

            if ($request->filled('nome')) {
                $fornecedor->update($request->only('nome'));
            }

            DB::commit();

            return redirect()->route('fornecedores.index')->with('success', 'Fornecedor atualizado com sucesso.');

        } catch (Exception $e) {
            DB::rollBack();
            info($e);
            return redirect()->route('fornecedores.index')->with('danger', 'Erro ao atualizar Fornecedor');
        }
    }

    public function destroy($id)
    {
        try {

            $fornecedor = Fornecedor::findOrFail($id);
            $fornecedor->delete();
            return redirect()->route('fornecedores.index')->with('success', 'Fornecedor deletado com sucesso.');

        } catch (Exception $e) {
            info($e);

            return redirect()->route('fornecedores.index')->with('danger', 'Erro ao deletar fornecedor.');
        }
    }

    public function entrada_create(Request $request, $fornecedorId)
    {
       try {

            $entrada = Entrada::create([
                'fornecedor_id' => $fornecedorId,
                'produto_id' => $request->produto_id,
                'quantidade' => $request->quantidade,
            ]);

            // dd($request);

            if($entrada){
               return redirect()->back()->with('success', 'Entrada incluida com sucesso.');
            }           

        } catch (Exception $e) {
            info($e);
            return redirect()->back()->with('danger', 'Erro ao cadastrar entrada');
        }
    }

    public function entradaUpdate(Request $request, $id)
    {
       try {

            $entrada = Entrada::find($id);

            if($entrada->status == 'inativo'){
                return redirect()->back()->with('danger', 'Essa entrada já foi cancelada.');
            }

            $entrada->status = $request->status;
            $entrada->save();

            return redirect()->route('fornecedores.show', $entrada->fornecedor_id)->with('success', 'Entrada Atualizada com sucesso.');

        } catch (Exception $e) {
            info($e);
            return redirect()->route('fornecedores.show', $entrada->fornecedor_id)->with('danger', 'Erro ao Atualizar a entrada');
        }
    }
}
