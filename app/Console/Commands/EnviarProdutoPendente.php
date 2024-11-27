<?php

namespace App\Console\Commands;

use App\Models\Grupo;
use App\Models\Produto;
use App\Services\EvolutionApi;
use App\Services\ProdutoService;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\InteractsWithQueue;

class EnviarProdutoPendente extends Command
{
    protected $signature = 'enviar:enviar-produto-pendente';
    protected $description = 'Envia um produto pendente para os grupos a cada 60 minutos';

    protected $evolutionApi;
    protected $service;
    protected $grupo;

    public function __construct(EvolutionApi $evolutionApi, ProdutoService $service, Grupo $grupo)
    {
        parent::__construct();
        $this->evolutionApi = $evolutionApi;
        $this->service = $service;
        $this->grupo = $grupo;
    }

    /**
     * Executa o comando.
     */
    public function handle()
    {

        $produto = Produto::where('status', 'pendente')->whereNotNull('link')->first();

        if ($produto) {
            try {
                $grupos = $this->grupo->allgroups();
                
                if(!$this->enviarProduto($produto, $grupos)){
                    Log::error('Erro ao enviar produto: ' . $produto->id . ' - ' . $produto->nome);
                }

                $produto->status = 'enviado';
                $produto->save();               
               
          
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
        $mensagem = $this->service->formatMessage($produto->toArray());
    
        foreach ($grupos as $grupo) {

            $grupo_geral = false;
            $grupo_categoria = false;

            if($grupo->grupo_id == '120363303397548933@g.us' && $produto->categoria_id === null){
                $grupo_geral = true;
            }

            if(isset($produto->categoria_id) && $grupo->grupo_id == '120363303397548933@g.us'){
                $grupo_geral = true;
            }
            
            if (isset($produto->categoria_id) && isset($grupo->categoria_id) && $produto->categoria_id == $grupo->categoria_id) {
                $grupo_categoria = true;
            }

            if ($grupo_categoria || $grupo_geral) {
                $this->evolutionApi->sendText($grupo->grupo_id, $mensagem);
                $produto->status = 'enviado';
                $produto->save(); 
            }
            
         
        }
    }
}
