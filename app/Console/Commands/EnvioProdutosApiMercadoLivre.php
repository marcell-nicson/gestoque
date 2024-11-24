<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\MercadoLivreApi;
use App\Services\OfertaService;
use App\Services\EvolutionApi;
use App\Models\Produto;
use App\Models\Grupo;
use App\Services\ProdutoService;
use Exception;
use Illuminate\Support\Facades\Log;

class EnvioProdutosApiMercadoLivre extends Command
{
    protected $signature = 'envio:produtos-apimercadolivre';
    protected $description = 'Enviar produtos da API Mercado Livre para grupos via Evolution API a cada 5 minutos';

    protected $mercadoLivreApi;
    protected $service;
    protected $evolutionApi;

    // Injeção de dependências via construtor
    public function __construct(MercadoLivreApi $mercadoLivreApi, ProdutoService $service, EvolutionApi $evolutionApi)
    {
        parent::__construct();
        $this->mercadoLivreApi = $mercadoLivreApi;
        $this->service = $service;
        $this->evolutionApi = $evolutionApi;
    }

    public function handle()
    {
        try {

            if (!$this->mercadoLivreApi->isAccessTokenValid()) {
                $this->mercadoLivreApi->refreshAccessToken();
            }

            // Obtenha as ofertas
            $jsonResponse = $this->mercadoLivreApi->getOfertas();
            $json = $jsonResponse->getData(true);

            // Processa cada resultado de oferta
            foreach ($json['results'] as $result) {
                $produto = $this->criarProduto($result);
                $mensagem = $this->service->formatMessage($produto->toArray());

                // Envia a mensagem para todos os grupos
                $this->enviarMensagemParaGrupos($mensagem);
            }

        } catch (Exception $e) {
            Log::error("Erro ao processar a API Mercado Livre: " . $e->getMessage());
        }
    }

    // Método para criar um produto e salvar no banco de dados
    protected function criarProduto(array $result): Produto
    {
        $produto = new Produto();
        $produto->nome = $result['title'];
        $produto->valor = intval(str_replace(['.', ','], ['', '.'], $result['price']) * 100);
        $produto->link = $result['permalink'];
        $produto->image = 'http://http2.mlstatic.com/D_NQ_NP_' . $result['thumbnail_id'] . '-O.webp';
        $produto->save();

        return $produto;
    }

    // Método para enviar a mensagem para todos os grupos
    protected function enviarMensagemParaGrupos(string $mensagem): void
    {
        $grupos = Grupo::all();

        foreach ($grupos as $grupo) {
            try {
                $this->evolutionApi->sendText($grupo->grupo_id, $mensagem);
                sleep(4); // Aguarde 4 segundos entre as mensagens

            } catch (Exception $e) {
                Log::error("Falha ao enviar mensagem para o grupo {$grupo->grupo_id}: " . $e->getMessage());
                break; // Interrompa o envio se falhar em um grupo
            }
        }
    }
}
