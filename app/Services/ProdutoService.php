<?php

namespace App\Services;

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

        $categorias = $this->produtoRepository->pluck(\App\Models\Categoria::class);
        $marcas = $this->produtoRepository->pluck(\App\Models\Marca::class);
        
        return compact('produtos', 'categorias', 'marcas');
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
        $response = $this->produtoRepository->create($data);
    
        if (!$response) {
            throw new Exception('Erro ao criar produto');
        }
    
        return [
            'status' => 'success',
            'message' => 'Produto criado com sucesso!'
        ];
    }
    

    private function prepareData(array $data): array
    {
        return [
            'nome' => $data['nome'] ?? null,
            'status' => 'pendente',
            'valor_original' => $this->formatValue($data['valor_original'] ?? 0),
            'valor' => $this->formatValue($data['valor'] ?? 0),
            'tipo' => $data['afiliado'] ?? 'estoque',
            'link' => $data['link'] ?? null,
            'categoria_id' => $data['categoria_id'] ?? null,
            'descricao' => $data['descricao'] ?? null,
            'image' => isset($data['image']) ? $this->handleImageUpload($data['image']) : null,
        ];
    }

    private function handleImageUpload($image): string
    {
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('images'), $imageName);

        return $imageName;
    }

    private function formatValue($value): int
    {
        return intval(str_replace(['.', ','], ['', '.'], $value) * 100);
    }
}
