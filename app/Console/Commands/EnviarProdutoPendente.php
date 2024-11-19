<?php

namespace App\Console\Commands;

use App\Models\Grupo;
use App\Models\Produto;
use App\Services\EvolutionApi;
use App\Services\OfertaService;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\InteractsWithQueue;

class EnviarProdutoPendente extends Command
{
    protected $signature = 'enviar:enviar-produto-pendente';
    protected $description = 'Envia um produto pendente para os grupos a cada 60 minutos';

    protected $evolutionApi;
    protected $ofertaService;
    protected $grupo;

    public function __construct(EvolutionApi $evolutionApi, OfertaService $ofertaService, Grupo $grupo)
    {
        parent::__construct();
        $this->evolutionApi = $evolutionApi;
        $this->ofertaService = $ofertaService;
        $this->grupo = $grupo;
    }

    /**
     * Executa o comando.
     */
    public function handle()
    {
        $produto = Produto::where('status', 'pendente')->first();

        if ($produto) {
            try {
                $grupos = $this->grupo->allgroups();
                
                if(!$this->enviarProduto($produto, $grupos)){
                    Log::error('Erro ao enviar produto: ' . $produto->id . ' - ' . $produto->nome);
                }else{
                    $produto->status = 'enviado';
                    $produto->save();
                }
               
          
            } catch (Exception $e) {
                Log::error('Erro ao enviar produto: ' . $e->getMessage());
           
            }
        }
    }
    /**
     * Envia o produto para os grupos.
     *
     * @param Produto $produto
     * @param array $grupos
     */
    protected function enviarProduto($produto, $grupos)
    {
        $mensagem = $this->ofertaService->formatMessage($produto->toArray());

        foreach ($grupos as $grupo) {
            $this->evolutionApi->sendText($grupo->grupo_id, $mensagem);
        }
    }
}
