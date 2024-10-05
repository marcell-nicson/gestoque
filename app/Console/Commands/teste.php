<?php

namespace App\Console\Commands;

use App\Models\Categoria;
use App\Models\Entrada;
use App\Models\Grupo;
use App\Models\Marca;
use App\Models\Produto;
use App\Models\Saida;
use App\Models\Venda;
use App\Services\EvolutionApi;
use App\Services\MercadoLivreApi;
use App\Services\OfertaService;
use App\Services\Uzapi;
use Carbon\Carbon;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

use function App\Helpers\calculoEntradaeSaida;

class teste extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:teste';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {



        try {
            $service = new MercadoLivreApi();



            $app_id = '4086879977097318';
            $client_secret = 'y0T5Qs1BA6tKZLwkzk0psVEmrWBJ5VEe';
            $url_principal = 'https://api.mercadolibre.com/oauth/token';

            $data = [
                'grant_type' => 'refresh_token',
                'client_id' => $app_id,
                'client_secret' => $client_secret,
                'refresh_token' => 'TG-67017ec1e418f5000186632a-130970326',
            ];
    
            $response = Http::asForm()->post($url_principal, $data);
            $resposta = $response->json();

            $refresh_token_key = 'ml_refresh_token'; 
            $access_token_key = 'ml_access_token';  
            $expires_at_key = 'ml_token_expires_at'; 

            $expires_in = $resposta['expires_in'];
            $new_refresh_token = $resposta['refresh_token'];
            $access_token = $resposta['access_token'];
            $token_expires_at = Carbon::now()->addSeconds($expires_in);

            Redis::setex($access_token_key, $expires_in, $access_token);
            Redis::setex($refresh_token_key, $expires_in, $new_refresh_token);
            Redis::setex($expires_at_key, $expires_in, $token_expires_at->toISOString());


            // $service = new MercadoLivreApi();
            // $ofertaService = new OfertaService();
            // $evolutionApi = new EvolutionApi();
      
                      

            //     $jsonResponse = $service->getOfertas();
            //     $json = $jsonResponse->getData(true);        
 
            
            //     $filtradas = [];
            //     foreach ($json['results'] as $result) {
            //         $filtradas[] = [
            //             'id' => $result['id'],
            //             'nome' => $result['title'],
            //             'category_id' => $result['category_id'],
            //             'thumbnail' => $result['thumbnail'],
            //             'valor' => $result['price'],
            //             'original_price' => $result['original_price'],
            //             'image' => 'http://http2.mlstatic.com/D_NQ_NP_' . $result['thumbnail_id'] . '-O.webp'
            //         ];

            //         $criado = $ofertaService->storeOferta($filtradas);
            //         $mensagem = $ofertaService->formatMessage($criado);
                    
            //         $grupos = Grupo::all();

            //         foreach ($grupos as $grupo) {
            //             try {
                            
            //                 $resposta = $evolutionApi->sendText($grupo->grupo_id, $mensagem);
            //                 info($resposta);
            //                 dd($resposta);
            //             } catch (Exception $e) {
            //                 Log::error("Falha ao enviar mensagem para o grupo {$grupo->grupo_id}: " . $e->getMessage());
                            
            //                 break; 
            //             }
            //             sleep(4);
            //         }  
            //     }            
          
                // event(new ProdutoCriado($produto));
            
            
            
        } catch (Exception $e) {
            $this->info($e->getMessage());
        }            
    }
}































