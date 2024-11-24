<?php

namespace App\Listeners;

use App\Events\ProdutoCriado;
use App\Models\Grupo;
use App\Models\Produto;
use App\Services\EvolutionApi;
use App\Services\OfertaService;
use App\Services\ProdutoService;
use App\Services\Uzapi;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Exception;

class EnviarNotificacaoProdutoCriado implements ShouldQueue
{
    use InteractsWithQueue;

    public $tries = 3;
    public $backoff = 10;

    protected $evolutionApi;
    protected $service;
    protected $grupo;

    /**
     * Create the event listener and instantiate services.
     */
    public function __construct(EvolutionApi $evolutionApi, ProdutoService $service, Grupo $grupo)
    {
        $this->evolutionApi = $evolutionApi;
        $this->service = $service;
        $this->grupo = $grupo;
    }

    /**
     * Handle the event.
     *
     * @param ProdutoCriado $event
     * @return void
     */
    public function handle(ProdutoCriado $event)
    {
        $produto = $event->produto;
        $grupos = $this->grupo->allgroups();
        $mensagem = $this->service->formatMessage($produto->toArray());

        foreach ($grupos as $grupo) {
            try {
                // $response = $this->uzapi->sendLink($grupo->grupo_id, $mensagem, route('ofertas.show', $produto->id));
                $resposta = $this->evolutionApi->sendText($grupo->grupo_id, $mensagem);
                Log::error($resposta);
            } catch (Exception $e) {
                Log::error("Falha ao enviar mensagem para o grupo {$grupo->grupo_id}: " . $e->getMessage());
                
                break; 
            }
            sleep(4);
        }

    }
}
