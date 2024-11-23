<?php

namespace App\Repositories;

use App\Models\Produto;

class ProdutoRepository
{
    
    public function create(array $data)
    {
        return Produto::create($data);
    }
    public function with()
    {
        return Produto::with(['categoria', 'marca']);
    }

    public function list()
    {
        return $this->with()
            ->orderBy('created_at', 'desc')
            ->paginate(15);
    }

    public function search($searchTerms)
    {
        $query = $this->with();

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
}
