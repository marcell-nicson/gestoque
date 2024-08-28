<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class Uzapi 
{

    protected $baseUrl = 'https://teste.uzapi.com.br:3333';
    protected $apitoken = 'ZapTic';
    protected $session = 'nova';
    protected $sessionKey = 'novakey';


    public function start()
    {
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'apitoken' => $this->apitoken,
            'sessionkey' => $this->sessionKey,
        ])->post($this->baseUrl.'/start',[
            'session' => $this->session 
        ]);

        // if($response->status() != 200){
        //     throw new \Exception('Não foi Possivel Criar o Grupo');
        // }

        $resposta = json_decode($response->body(), true);
        dd($resposta);
        return $resposta['id'];
    }

    public function getQrCode()
    {
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',           
        ])->post($this->baseUrl.'/getQrCode?session='.$this->apitoken.'&sessionkey='.$this->sessionKey,[
            'session' => $this->session 
        ]);

        // if($response->status() != 200){
        //     throw new \Exception('Não foi Possivel Criar o Grupo');
        // }

        $resposta = $response;
        dd($resposta);
        return $resposta['id'];
    }

    public function getSessionStatus()
    {
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'sessionkey' => $this->sessionKey,
        ])->post($this->baseUrl.'/getSessionStatus',[
            'session' => $this->session            
        ]);

        // if($response->status() != 200){
        //     throw new \Exception('Não foi Possivel Criar o Grupo');
        // }

        $resposta = json_decode($response->body(), true);
        dd($resposta);
        return $resposta['id'];
    }

    public function restartSession()
    {
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'sessionkey' => $this->sessionKey,
        ])->post($this->baseUrl.'/restartSession',[
            'session' => $this->session,        
        ]);

        // if($response->status() != 200){
        //     throw new \Exception('Não foi Possivel Criar o Grupo');
        // }

        $resposta = json_decode($response->body(), true);
        dd($resposta);
        return $resposta['id'];
    }
    
    public function createGroup($nome, $mumber)
    {
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'sessionkey' => $this->sessionKey,
        ])->post($this->baseUrl.'/createGroup',[
            'session' => $this->session,
            'name' => $nome,
            'participants' => "558487380723"
        ]);

        // if($response->status() != 200){
        //     throw new \Exception('Não foi Possivel Criar o Grupo');
        // }

        $resposta = json_decode($response->body(), true);
        dd($resposta);
        return $resposta['id'];
    }

    public function getAllGroups()
    {
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'sessionkey' => $this->sessionKey,
        ])->post($this->baseUrl.'/getAllGroups',[
            'session' => $this->session
        ]);

        if($response->status() != 200){
            throw new \Exception('Could not get groups from Uzapi.');
        }
        $resposta = json_decode($response->body(), true);

        return $resposta['groups'];
    }


    public function sendMessage(array $groups, string $message)
    {
        //dd($groups, $message);
        foreach ($groups as $group) {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'sessionkey' => $this->sessionKey,
            ])->post($this->baseUrl.'/sendText',[
                'session' => $this->session,
                'number' => $group,
                'text' => $message
            ]);
            if($response->status() != 200){
                Log::info($response->status());
                throw new \Exception('Could not send message to Uzapi.');
            }
        }

        return true;
    }

    public function sendLink($group, string $message, $url)
    {
        //dd($groups, $message);
        // foreach ($groups as $group) {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'sessionkey' => $this->sessionKey,
            ])->post($this->baseUrl.'/sendLink',[
                'session' => $this->session,
                'number' => $group,
                'text' => $message,
                'url' => $url
            ]);

            if($response->status() != 200){
                // Log::info($response->status());
                // throw new \Exception('Could not send message to Uzapi.');

                return false;
            }
        // }

        return true;
    }


    /*
     * curl --location -g 'https://fliptecnologia.uzapi.com.br:3333/setWebhooks' \
--header 'content-type: application/json' \
--header 'sessionkey: luanwppsessionkey' \
--data '{
    "session": "luanwppsessionkey",
    "wh_connect":"https://b397yuntrz.sharedwithexpose.com/webhook/1",
	"wh_qrcode":"https://b397yuntrz.sharedwithexpose.com/webhook/1",
	"wh_status":"https://b397yuntrz.sharedwithexpose.com/webhook/1",
	"wh_message":"https://b397yuntrz.sharedwithexpose.com/webhook/1"
}'
    */
    public function setWebhook($url)
    {
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'sessionkey' => $this->sessionKey,
        ])->post($this->baseUrl.'/setWebhooks',[
            'session' => $this->session,
            'wh_connect' => $url,
            'wh_status' => $url,
            'wh_message' => $url
        ]);

        if($response->status() != 200){
            throw new \Exception('Could not change webhooks.');
        }
    }

    public function getGroupMembers($groupId)
    {
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'sessionkey' => $this->sessionKey,
        ])->post($this->baseUrl.'/getGroupMembers',[
            'session' => $this->session,
            "groupid" => $groupId
        ]);

        if($response->status() != 200){
            throw new \Exception('Could not get group members from Uzapi.');
        }
        $participants = json_decode($response->body(), true);
        return $participants['participants'];
    }


    public function addParticipantGroup($groupId, $mumber)
    {
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'sessionkey' => $this->sessionKey,
        ])->post($this->baseUrl.'/addParticipant',[
            'session' => $this->session,
            "groupid" => $groupId,
            "number" => $mumber
        ]);

        // if($response->status() != 200){
        //     throw new \Exception('Could not add group members from Uzapi.');
        // }

        $resposta = json_decode($response->body(), true);
        return [$resposta];
    }

    public function getChat($number)
    {
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'sessionkey' => $this->sessionKey,
        ])->post($this->baseUrl.'/getAllContacts',[
            'session' => $this->session,
            // "number" => $number
        ]);

        if($response->status() != 200){
            dd(json_decode($response->body(), true));
            throw new \Exception('Could not get Chat from Uzapi.');
        }

        $member = json_decode($response->body(), true);

        
        return $member;
    }

    public function getAllContacts()
    {
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'sessionkey' => $this->sessionKey,
        ])->post($this->baseUrl.'/getAllContacts',[
            'session' => $this->session,

        ]);

        if($response->status() != 200){
            throw new \Exception('Could not add group members from Uzapi.');
        }
        $resposta = json_decode($response->body(), true);
        return [$resposta];
    }



}


//curl --location -g 'https://fliptecnologia.uzapi.com.br:3333/sendText' \
//--header 'content-type: application/json' \
//--header 'sessionkey: luanwppsessionkey' \
//--data '{
//    "session": "luanwppsessionkey",
//    "number": "120363300912960985",
//    "text": "Testando envio de texto."
//}'
