<?php

namespace App\Services;

use App\Models\Endereco;
use App\Models\Contato;
use App\Models\Fornecedor;
use App\Repositories\FornecedorRepository;
use Exception;
use Illuminate\Support\Facades\Auth;

class FornecedorService
{
    protected $fornecedorRepository;

    public function __construct(FornecedorRepository $fornecedorRepository)
    {
        $this->fornecedorRepository = $fornecedorRepository;
    }

    public function store(array $data)
    {
        try {
            $fornecedor = $this->fornecedorRepository->create($data);    
                     
            return $fornecedor;
        } catch (Exception $e) {
            throw new Exception('Erro ao criar fornecedor: ' . $e->getMessage());
        }
    }
}
