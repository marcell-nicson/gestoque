<?php

namespace App\Listeners;

use App\Events\ProdutoCriado;
use App\Models\Grupo;
use App\Services\OfertaService;
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

    protected $uzapi;
    protected $ofertaService;
    protected $grupo;

    /**
     * Create the event listener and instantiate services.
     */
    public function __construct(Uzapi $uzapi, OfertaService $ofertaService, Grupo $grupo)
    {
        $this->uzapi = $uzapi;
        $this->ofertaService = $ofertaService;
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
        $mensagem = $this->ofertaService->formatMessage($produto->toArray());

        foreach ($grupos as $grupo) {
            try {
                $response = $this->uzapi->sendLink($grupo->grupo_id, $mensagem, route('ofertas.show', $produto->id));

                if ($response->status() != 200) {
                    throw new Exception("Erro  {$grupo->grupo_id}. Status: " . $response->status());
                }

            } catch (Exception $e) {
                Log::error("Falha ao enviar mensagem para o grupo {$grupo->grupo_id}: " . $e->getMessage());
                
                break; 
            }
            sleep(4);
        }

    }
}
