<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class EvolutionApi
{

    protected $baseUrl = 'http://evolution.redpay.com.br:8080';
    protected $apikey = 'AB69DC264957-4F51-9038-632F34A84076';
    protected $instance = 'GestoqueWpp';
    protected $description = 'Bem-vindo ao G-Ofertas!

    🔥 O grupo exclusivo de promoções e cupons das maiores lojas virtuais do Brasil.

    ⚠ Viu algo que gostou? Aproveite rápido! As ofertas têm duração limitada e podem acabar a qualquer momento.

    Acesse agora: https://promoestoque.com.br/ofertas e fique por dentro das melhores oportunidades!';


    public function createGroup($name, $participants = null)
    {  

        $response = Http::withHeaders([
        'Content-Type' => 'application/json',
        'apikey' => $this->apikey,
        ])->post($this->baseUrl. '/group/create/'. $this->instance  ,[
        'subject' => $name,
        'description' => $this->description,
        'participants' => $participants ? $participants : ['558487380723'],
        ]); 

        $resposta = json_decode($response->body(), true);
        Log::info($resposta);
     
        $this->updateGroupPicture($resposta['id'], 'https://promoestoque.com.br/logo.png');

        return $resposta['id'];
    }

    public function updateGroupPicture($id, $url)
    {
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'apikey' => $this->apikey,
            ])->put($this->baseUrl. '/group/updateGroupPicture/'. $this->instance .'/?groupJid='. $id,[
            'image' => $url,
            ]); 
    
            $resposta = json_decode($response->body(), true);
            dd($resposta);
            if($response->status() != 200){
                Log::info($response->status());
                throw new \Exception('Not possible to update group picture');
            }

        return $response;
    }
    public function fetchAllGroups()
    {  
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'apikey' => $this->apikey,
        ])->get($this->baseUrl . '/group/fetchAllGroups/' . $this->instance, [
            'getParticipants' => 'true',
        ]); 

        $resposta = json_decode($response->body(), true);
        info($resposta);
        // Coletar os IDs dos grupos
        $groupIds = array_map(function($group) {
            return $group['id'];
        }, $resposta);

        Log::info($groupIds);

        return $groupIds; 
    }
 
    public function sendText($number, $text, $quotedKey = null, $quotedMessage = null, $linkPreview = true, $mentionsEveryOne = false, $mentioned = [])
    {
        $data = [
            'number' => $number,
            'text' => $text,
            'delay' => 5, // Atraso em milissegundos (1 segundo)
            'linkPreview' => $linkPreview,
            'mentionsEveryOne' => $mentionsEveryOne,
        ];
    
        // Adiciona 'mentioned' apenas se houver menções
        if (!empty($mentioned)) {
            $data['mentioned'] = $mentioned;
        }
    
        // Verifica se quotedKey e quotedMessage são fornecidos
        if ($quotedKey && $quotedMessage) {
            $data['quoted'] = [
                'key' => $quotedKey,
                'message' => [
                    'conversation' => $quotedMessage,
                ],
            ];
        }
    
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'apikey' => $this->apikey,
        ])->post($this->baseUrl . '/message/sendText/' . $this->instance, $data); 
    

        Log::info($response);

        $resposta = json_decode($response->body(), true);  
     
    
        return $resposta; 
    }
}
