<?php

namespace App\Services;

use App\Models\Produto;
use Illuminate\Support\Facades\Storage;

class OfertaService
{
    public function storeOferta(array $data)
    {
        $data = $this->prepareData($data);
        return Produto::create($data);
    }
    
    private function prepareData(array $data): array
    {
        return [
            'valor_original' => $this->formatValue($data['valor_original'] ?? 0),
            'valor' => $this->formatValue($data['valor'] ?? 0),
            'tipo' => 'afiliado',
            'status' => 'pendente',
            'nome' => $data['nome'] ?? null,
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

    public function formatMessage(array $produto)
    {       
        $valorOriginal = isset($produto['valor_original']) 
            ? 'De: ~' . number_format($produto['valor_original'] / 100, 2, ',', '.') . '~' 
            : null;

        $valor = 'por: ' . number_format($produto['valor'] / 100, 2, ',', '.') . " 🔥";
        $descricao = isset($produto['descricao']) 
            ? $produto['descricao'] 
            : '';

        $linkCompra = "🛒 Link de compra:\n" . route('ofertas.show', $produto['id']);
        $linkGrupo = "📲 Link do grupo de ofertas:\nhttps://chat.whatsapp.com/ENRq8GMZHfqKxLErJoYdXX";
       
        $message = '*' . $produto['nome'] . "*\n\n";

        if ($valorOriginal) {
            $message .= $valorOriginal . "\n";
        }

        $message .= $valor . "\n\n";
        $message .= $descricao ? $descricao . "\n\n" : '';
        $message .= $linkCompra . "\n\n";
        $message .= $linkGrupo;

        return $message;
    }



    public function sendText($grupoId, $mensagem)
    {
        $evolutionApi = new EvolutionApi();
        return $evolutionApi->sendText($grupoId, $mensagem);

    }
}
