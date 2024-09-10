<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ChatGPTService
{
    protected $apiKey;

    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    // Função para obter a resposta do ChatGPT
    public function getChatGPTResponse($message)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
            'Content-Type' => 'application/json',
        ])->post('https://api.openai.com/v1/chat/completions', [
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                [
                    'role' => 'user',
                    'content' => $message,
                ]
            ]
        ]);

        if ($response->status() != 200) {
            throw new \Exception('Erro ao conectar com ChatGPT.');
        }

        $resposta = json_decode($response->body(), true);
        return $resposta['choices'][0]['message']['content'];
    }
}
