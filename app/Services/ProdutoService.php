<?php

namespace App\Services;

use App\Models\Categoria;
use App\Models\Marca;
use App\Repositories\ProdutoRepository;
use Exception;

class ProdutoService
{
    protected $produtoRepository;

    public function __construct(ProdutoRepository $produtoRepository)
    {
        $this->produtoRepository = $produtoRepository;
    }

    public function index($request)
    {
        $produtos = $request->filled('search') ? 
                    $this->search($request) : 
                    $this->list();
        
        $quantidadeAmazonPendente = $this->produtoRepository->quantidadeProdutosAmazonPendentes();
        $quantidadeMercadoLivrePendente = $this->produtoRepository->quantidadeProdutosMercadoLivrePendentes();
        $outros = $this->produtoRepository->quantidadeDeoutrosProdutosPendentes();

        $categorias = $this->produtoRepository->pluck(Categoria::class);
        $marcas = $this->produtoRepository->pluck(Marca::class);
        
        return compact('produtos', 'categorias', 'marcas', 'quantidadeAmazonPendente', 'quantidadeMercadoLivrePendente', 'outros');
    }

    public function show($id)
    {
        return $this->produtoRepository->show($id);
    }

    public function list()
    {
        return $this->produtoRepository->list();
    }

    public function search($request)
    {
        $searchTerms = explode(' ', $request->search);
        return $this->produtoRepository->search($searchTerms);
    }

    public function store(array $data): array
    {
        $data = $this->prepareData($data);

        if ($data['valor_original'] <= $data['valor']) {
            throw new Exception('O valor original não pode ser menor ou igual ao valor do produto');
        }

        if($data['tipo'] == 'afiliado' && $data['link'] === null) {
            throw new Exception('O link é obrigatório para produtos afiliados');
        }

        if(empty($data['image'] or $data['image'] === null)) {
            throw new Exception('A imagem é obrigatória');
        }

        $response = $this->produtoRepository->create($data);
    
        if (!$response) {
            throw new Exception('Erro ao criar produto');
        }
    
        return [
            'status' => 'success',
            'message' => 'Produto criado com sucesso!'
        ];
    }

    public function update(array $data, $id)
    {
        $data1 = $this->prepareData($data);

        $response = $this->produtoRepository->update($data1, $id);
    
        if (!$response) {
            throw new Exception('Erro ao editar produto');
        }
    
        return [
            'status' => 'success',
            'message' => 'Produto atualizado com sucesso!'
        ];

    }

    public function ofertas()
    {
        return $this->produtoRepository->ofertas();
    }    

    private function prepareData(array $data): array
    {
        return [
            'nome'           => $data['nome'] ?? null,
            'status'         => $data['status'] ?? null,
            'valor_original' => $this->formatValue($data['valor_original'] ?? 0),
            'valor'          => $this->formatValue($data['valor'] ?? 0),
            'tipo'           => $data['tipo'] ?? null,
            'promocao'       => $data['valor_original'] ? true : false,
            'link'           => $data['link'] ?? null,
            'categoria_id'   => $data['categoria_id'] ?? null,
            'descricao'      => $data['descricao'] ?? null,
            'image'          => isset($data['image']) ? $this->handleImage($data['image']) : null,
        ];
    }

    private function handleImage($image): string
    {
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('images'), $imageName);

        return $imageName;
    }

    private function formatValue($value): int
    {
        return intval(str_replace(['.', ','], ['', '.'], $value) * 100);
    }

    public function formatMessage(array $produto)
    {       
        $valorOriginal = isset($produto['valor_original']) 
            ? 'de: ~' . number_format($produto['valor_original'] / 100, 2, ',', '.') . '~' 
            : null;

        $valor = 'por: ' . number_format($produto['valor'] / 100, 2, ',', '.') . " 🔥";
        $descricao = isset($produto['descricao']) 
            ? $produto['descricao'] 
            : '';

        $linkCompra = "🛒 Link de compra:\n" . route('ofertas.showOferta', $produto['id']);
        $linkGrupo = "📲 Link do grupo de ofertas:\nhttps://chat.whatsapp.com/ENRq8GMZHfqKxLErJoYdXX";
       
        $message = '*' . $produto['nome'] . "*\n\n";

        if ($valorOriginal && $produto['valor_original'] > 0) {
            $message .= $valorOriginal . "\n";
        }

        $message .= $valor . "\n\n";
        $message .= $descricao ? $descricao . "\n\n" : '';
        $message .= $linkCompra . "\n\n";
        $message .= $linkGrupo;

        return $message;
    }
}
