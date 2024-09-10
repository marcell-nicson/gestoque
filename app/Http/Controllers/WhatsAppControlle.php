<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Uzapi;
use App\Services\ChatGPTService;

class WhatsAppController extends Controller
{
    protected $uzapi;
    protected $chatGPTService;

    public function __construct(Uzapi $uzapi, ChatGPTService $chatGPTService)
    {
        $this->uzapi = $uzapi;
        $this->chatGPTService = $chatGPTService;
    }

    // Função para processar a mensagem recebida via webhook
    public function webhook(Request $request)
    {
        $messageData = $request->all(); // Captura os dados da mensagem recebida
        $this->processIncomingMessage($messageData);
    }

    // Função para processar mensagens recebidas
    protected function processIncomingMessage($messageData)
    {
        $senderNumber = $messageData['from'];
        $message = $messageData['text'];

        // Chamar a API do ChatGPT para obter a resposta
        $chatGptResponse = $this->chatGPTService->getChatGPTResponse($message);

        // Enviar a resposta do ChatGPT de volta ao usuário no WhatsApp
        $this->uzapi->sendMessage([$senderNumber], $chatGptResponse);
    }
}
