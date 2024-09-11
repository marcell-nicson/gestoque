<?php

namespace App\Listeners;

use App\Events\ProdutoCriado;
use App\Models\Grupo;
use App\Services\OfertaService;
use App\Services\Uzapi;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class EnviarNotificacaoProdutoCriado implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
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

        $grupos = Grupo::all();
        $uzapi = new Uzapi();
        $ofertaService = new OfertaService();

        $mensagem = $ofertaService->formatMessage($produto->toArray());

        foreach ($grupos as $grupo) {
            $contador = 0;
            $sucesso = false;

            while ($contador < 3 && !$sucesso) {
                $response = $uzapi->sendLink($grupo->grupo_id, $mensagem, $produto->link);

                if ($response && $response->status() == 200) {
                    $sucesso = true;
                    Log::info("Mensagem enviada com sucesso para o grupo " . $grupo->grupo_id);
                } else {
                    $contador++;
                    Log::warning("Tentativa {$contador} falhou para o grupo " . $grupo->grupo_id);

                    if ($contador < 3) {
                        sleep(10);
                    }
                }
            }

            if (!$sucesso) {
                Log::error("Falha no envio para o grupo " . $grupo->grupo_id . " após 3 tentativas.");
                break;
            }
        }

        Log::info("Produto criado: " . $produto->nome);
    }
}
