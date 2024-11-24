<?php

namespace App\Repositories;

use App\Models\Produto;

class ProdutoRepository
{
    public function show($id)
    {
        return Produto::findOrFail($id);
    }
    public function create(array $data)
    {
        return Produto::create($data);
    }
    public function produto_categoria_marca()
    {
        return Produto::with(['categoria', 'marca']);
    }

    public function quantidadeProdutosAmazonPendentes()
    {
        return Produto::where('status', 'pendente')
                        ->where('link', 'like', '%amzn%')
                        ->count();
    }

    public function quantidadeProdutosMercadoLivrePendentes()
    {
        return Produto::where('status', 'pendente')
                        ->where('link', 'like', '%mercadolivre%')
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
        return Produto::where('tipo', 'afiliado')
                        ->whereNotNull('link')
                        ->orderBy('created_at', 'desc')
                        ->get();

    }
}
