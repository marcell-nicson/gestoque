<?php

namespace App\Services;

use App\Models\Produto;
use Illuminate\Support\Facades\Storage;

class OfertaService
{
    public function storeOferta(array $data)
    {
        $valor = intval(str_replace(['.', ','], ['', '.'], $data['valor']) * 100);
        $data['valor'] = $valor;
        $data['tipo'] = 'afiliado';

        if (isset($data['image'])) {
            $foto = $data['image'];
            $nomeFoto = time() . '.' . $foto->getClientOriginalExtension();
            $foto->move(public_path('images'), $nomeFoto);
            $data['image'] = $nomeFoto; 
        }

        return Produto::create($data);
    }

    public function formatMessage(array $produto)
    {
        $produtoData = [
            'id' => $produto['id'],
            'nome' => $produto['nome'],
            'valor' => $produto['valor'], 
            'link' => $produto['link'],
            'link_ofertas' => 'https://chat.whatsapp.com/ENRq8GMZHfqKxLErJoYdXX'
        ];

        return '*' . $produtoData['nome'] . "*\n\n" .                            
               'por ' . number_format($produtoData['valor'] / 100, 2, ',', '.') . " 🔥\n\n" .                            
               "🛒 Link de compra:\n" . "https://promoestoque.com.br/ofertas/{$produtoData['id']}" . "\n\n" .
               "📲 Link do grupo de ofertas:\n" . $produtoData['link_ofertas'];
    }
}
