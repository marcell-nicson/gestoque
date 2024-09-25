<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class EvolutionApi
{

    protected $baseUrl = 'http://165.22.185.250:8080';
    protected $apikey = '105B2BDC82A3-4474-AE70-9056997ABEA1';
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

        // Coletar os IDs dos grupos
        $groupIds = array_map(function($group) {
            return $group['id'];
        }, $resposta);

        Log::info($groupIds);

        return $groupIds; 
    }

    public function sendPromotionTemplate($number, $product, $oldPrice = null, $installments = null)
    {
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'apikey' => $this->apikey,
        ])->post($this->baseUrl . '/message/sendTemplate/'.$this->instance, [
            'number' => $number, 
            'name' => 'promotion_template', // Nome do template aprovado
            'language' => 'pt_BR',
            'components' => [
                [
                    'type' => 'header',
                    'parameters' => [
                        [
                            'type' => 'image', // Adiciona a imagem do produto no cabeçalho
                            'image' => [
                                'link' => $product->image // Link da imagem do produto
                            ]
                        ]
                    ]
                ],
                [
                    'type' => 'body',
                    'parameters' => [
                        [
                            'type' => 'text', // Nome do produto
                            'text' => $product->nome
                        ],
                        // [
                        //     'type' => 'text', // Preço antigo
                        //     'text' => $oldPrice
                        // ],
                        [
                            'type' => 'text', // Preço novo com desconto
                            'text' => $product->valor
                        ],
                        // [
                        //     'type' => 'text', // Parcelamento
                        //     'text' => $installments
                        // ]
                    ]
                ],
                // [
                //     'type' => 'footer',
                //     'parameters' => [
                //         [
                //             'type' => 'text', // Mensagem de frete grátis ou algum benefício
                //             'text' => 'Frete Grátis c/ Amazon PRIME'
                //         ]
                //     ]
                // ],
                [
                    'type' => 'button',
                    'sub_type' => 'url', // Botão com link para compra
                    'index' => '0',
                    'parameters' => [
                        [
                            'type' => 'text',
                            'text' => 'Link de compra: ' . route('ofertas.show', $product->id)
                        ]
                    ]
                ],
                [
                    'type' => 'button',
                    'sub_type' => 'url', // Botão com link para grupo de ofertas
                    'index' => '1',
                    'parameters' => [
                        [
                            'type' => 'text',
                            'text' => 'Link do grupo de ofertas: https://chat.whatsapp.com/ENRq8GMZHfqKxLErJoYdXX'
                        ]
                    ]
                ]
            ]
        ]);

        $resposta = json_decode($response->body(), true);
        Log::info($resposta);     

        return $resposta;
    }

    // public function sendText($number, $text, $quotedKey = null, $quotedMessage = null, $linkPreview = true, $mentionsEveryOne = true, $mentioned = [])
    // {
    //     $response = Http::withHeaders([
    //         'Content-Type' => 'application/json',
    //         'apikey' => $this->apikey,
    //     ])->post($this->baseUrl . '/message/sendText/' . $this->instance, [
    //         'number' => $number,
    //         'text' => $text,
    //         'delay' => '1',
    //         'quoted' => [
    //             'key' => $quotedKey,
    //             'message' => [
    //                 'conversation' => $quotedMessage,
    //             ],
    //         ],
    //         'linkPreview' => $linkPreview,
    //         'mentionsEveryOne' => $mentionsEveryOne,
    //         'mentioned' => $mentioned,
    //     ]); 
    
    //     $resposta = json_decode($response->body(), true);
    
    //     Log::info($resposta);
    
    //     return $resposta; 
    // }
    
    public function sendText($number, $text, $quotedKey = null, $quotedMessage = null, $linkPreview = true, $mentionsEveryOne = false, $mentioned = [])
    {
        $data = [
            'number' => $number,
            'text' => $text,
            'delay' => 1000, // Atraso em milissegundos (1 segundo)
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
    
        $resposta = json_decode($response->body(), true);
    
        Log::info($resposta);
    
        return $resposta; 
    }
}
