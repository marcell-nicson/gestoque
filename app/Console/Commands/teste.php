<?php

namespace App\Console\Commands;

use App\Models\Categoria;
use App\Models\Entrada;
use App\Models\Grupo;
use App\Models\Marca;
use App\Models\Produto;
use App\Models\Saida;
use App\Models\Venda;
use App\Services\Uzapi;
use Exception;
use Illuminate\Console\Command;

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

            // $uzapi = new Uzapi();

            // $grupoId = '120363303397548933';
            // $numeros = [
            //     '558496377856',
            //     '558481345425',
            //     '558496539798',
            // ];

            // foreach ($numeros as $numero) {

            //     $resposta = $uzapi->addParticipantGroup($grupoId, $numero);
            //     if($resposta){
            //         $this->info('adicionado: '. $numero);
            //     }
            // }
            
            $grupo = new Grupo();
            $grupo->nome = 'Nome do Grupo';
            $grupo->grupo_id = '123456789';
            $grupo->descricao = 'Descrição do grupo';
            $grupo->save();

        } catch (Exception $e) {
            $this->info($e->getMessage());
        }

            
    }

}
