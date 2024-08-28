<?php

namespace App\Repositories;

use App\Models\Endereco;
use App\Models\Contato;
use App\Models\Fornecedor;


class FornecedorRepository 
{
    public function create(array $data)
    {
        $endereco = Endereco::create([
            'rua' => $data['rua'],
            'numero' => $data['numero'],
            'complemento' => $data['complemento'],
            'bairro' => $data['bairro'],
            'cidade' => $data['cidade'],
            'estado' => $data['estado'],
            'cep' => $data['cep'],
        ]);

        $contato = Contato::create([
            'telefone' => $data['telefone'],
            'whatsapp' => $data['whatsapp'],
            'email' => $data['email'],
        ]);

        $fornecedor = Fornecedor::create([
            'nome' => $data['nome'],
            'contato_id' => $contato->id,
            'endereco_id' => $endereco->id,
        ]);

        return $fornecedor;
    }
}
