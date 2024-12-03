<?php

namespace App\Repositories;

use App\Models\Produto;

class ProdutoRepository
{
    protected $model;

    public function __construct(Produto $model)
    {
        $this->model = $model;
    }
    public function show($id)
    {
        return $this->model::findOrFail($id);
    }
    public function create(array $data)
    {
        return $this->model::create($data);
    }
    public function update(array $data, $id)
    {
        return $this->model::findOrFail($id)->update($data);
    }
    public function produto_categoria_marca()
    {
        return $this->model::with(['categoria', 'marca']);
    }

    public function quantidadeProdutosAmazonPendentes()
    {
        return $this->model::where('status', 'pendente')
                        ->where('link', 'like', '%amzn%')
                        ->count();
    }

    public function quantidadeProdutosMercadoLivrePendentes()
    {
        return $this->model::where('status', 'pendente')
                        ->where('link', 'like', '%mercadolivre%')
                        ->count();
    }

    public function quantidadeDeoutrosProdutosPendentes()
    {
        return $this->model::where('status', 'pendente')
                        ->where('link', 'not like', '%amzn%')
                        ->where('link', 'not like', '%mercadolivre%')
                        ->count();
    }

    public function list()
    {
        return $this->produto_categoria_marca()
            ->orderBy('created_at', 'desc')
            ->paginate(15);
    }

    public function search($searchTerms)
    {
        $query = $this->produto_categoria_marca();

        foreach ($searchTerms as $term) {
            $query->where(function ($q) use ($term) {
                $q->where('nome', 'like', '%' . $term . '%')
                  ->orWhereHas('categoria', function ($q) use ($term) {
                      $q->where('nome', 'like', '%' . $term . '%');
                  })
                  ->orWhereHas('marca', function ($q) use ($term) {
                      $q->where('nome', 'like', '%' . $term . '%');
                  });
            });
        }

        return $query->paginate(15);
    }

    public function pluck($model)
    {
        return $model::pluck('nome', 'id');
    }

    public function ofertas()
    {
        return $this->model::where('tipo', 'afiliado')
                        ->whereNotNull('link')
                        ->orderBy('created_at', 'desc')
                        ->get();

    }
}
