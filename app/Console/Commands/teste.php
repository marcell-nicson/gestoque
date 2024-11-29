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
            
            $grupos = Grupo::all();
    
            foreach ($grupos as $grupo) {
                $grupo->delete();
            }
            
            
        } catch (Exception $e) {
            $this->info($e->getMessage());
        }            
    }
}































