<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redis;

class MercadoLivreApi
{
    protected $app_id = '4086879977097318';
    protected $client_secret = 'y0T5Qs1BA6tKZLwkzk0psVEmrWBJ5VEe';
    protected $code = 'TG-67017eb59539d60001e10596-130970326';
    protected $uri_redirect = 'https://promoestoque.com.br/';

    protected $refresh_token_key = 'ml_refresh_token'; 
    protected $access_token_key = 'ml_access_token';  
    protected $expires_at_key = 'ml_token_expires_at'; 
    protected $url_principal = 'https://api.mercadolibre.com/oauth/token';
    protected $access_token = 'APP_USR-4086879977097318-100514-20bdeda2253963a2695448090f14a313-130970326';
    protected $refresh_token = 'TG-67017ec1e418f5000186632a-130970326';
    protected $token_expires_at;


    public function __construct()
    {
        $this->access_token = Redis::get($this->access_token_key);
        $this->token_expires_at = Redis::get($this->expires_at_key);
    }

    public function start()
    {
        if (!$this->isAccessTokenValid()) {

            $data = [
                'grant_type' => 'authorization_code',
                'client_id' => $this->app_id,
                'client_secret' => $this->client_secret,
                'code' =>  $this->code,
                'redirect_uri' => 'https://promoestoque.com.br/',
            ];

            $response = Http::asForm()->post($this->url_principal, $data);
            $resposta = $response->json();  

            Log::info($response);


            // $expires_in = $resposta['expires_in'];
            // $new_refresh_token = $resposta['refresh_token'];
            // $this->access_token = $resposta['access_token'];
            // $this->token_expires_at = Carbon::now()->addSeconds($expires_in);

            // Redis::setex($this->access_token_key, $expires_in, $this->access_token);
            // Redis::setex($this->refresh_token_key, $expires_in, $new_refresh_token);
            // Redis::setex($this->expires_at_key, $expires_in, $this->token_expires_at->toISOString());

            Log::info('Access token obtido com sucesso');
            return $this->access_token;
        }
    }

    public function isAccessTokenValid()
    {
        $expiresAt = Redis::get($this->expires_at_key);

        return $expiresAt && Carbon::now()->lt(Carbon::parse($expiresAt));
    }

    /**
     * Atualiza o access token utilizando o refresh token
     */
    public function refreshAccessToken()
    {
        $refresh_token = Redis::get($this->refresh_token_key);

        if (!$refresh_token) {
            Log::error('Refresh token não encontrado no Redis');
            return null;
        }

        $data = [
            'grant_type' => 'refresh_token',
            'client_id' => $this->app_id,
            'client_secret' => $this->client_secret,
            'refresh_token' => $refresh_token,
        ];

        $response = Http::asForm()->post($this->url_principal, $data);
        $resposta = $response->json();

        if (isset($resposta['access_token'])) {
            $expires_in = $resposta['expires_in'];
            $new_refresh_token = $resposta['refresh_token'];
            $this->access_token = $resposta['access_token'];
            $this->token_expires_at = Carbon::now()->addSeconds($expires_in);

            Redis::setex($this->access_token_key, $expires_in, $this->access_token);
            Redis::setex($this->refresh_token_key, $expires_in, $new_refresh_token);
            Redis::setex($this->expires_at_key, $expires_in, $this->token_expires_at->toISOString());

            Log::info('Access token atualizado com sucesso');
            return $this->access_token;
        } else {
            Log::error('Erro ao atualizar access_token: ' . json_encode($resposta));
            return null;
        }
    }

    /**
     * Verifica se o access token expirou e, se necessário, renova-o
     */
    public function getAccessToken()
    {
        if (!$this->token_expires_at || Carbon::now()->greaterThan(Carbon::parse($this->token_expires_at))) {
            Log::info('Token expirado, atualizando...');
            return $this->refreshAccessToken();
        }

        return $this->access_token;
    }    

    public function getOfertas()
    {
        $access_token = $this->getAccessToken();
        if (!$access_token) {
            return response()->json(['error' => 'Não foi possível obter o access token'], 500);
        }

        $url = 'https://api.mercadolibre.com/sites/MLB/search?category=' . $this->drawCategory().'&limit=1';

        try {
            $response = Http::withToken($access_token)->get($url);

            if ($response->successful()) {
                $ofertas = $response->json();
                return response()->json($ofertas, 200, [], JSON_PRETTY_PRINT);
            } else {
                return response()->json(['error' => 'Falha na requisição: ' . $response->status()], $response->status());
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao buscar as ofertas: ' . $e->getMessage()], 500);
        }
    }

    public function drawCategory()
    {
        $categories = ['MLB5672', 'MLB271599', 'MLB1403', 'MLB1071', 'MLB1367', 'MLB1368', 
                       'MLB1384', 'MLB1246', 'MLB1132', 'MLB1430', 'MLB1039', 'MLB1743', 
                       'MLB1574', 'MLB1051', 'MLB1500', 'MLB5726', 'MLB1000', 'MLB1276', 
                       'MLB263532', 'MLB12404', 'MLB1144', 'MLB1459', 'MLB1499', 'MLB1648', 
                       'MLB218519', 'MLB1182', 'MLB3937', 'MLB1196', 'MLB1168', 'MLB264586', 
                       'MLB1540', 'MLB1953'];
    
        return $categories[array_rand($categories)];
    }
}
