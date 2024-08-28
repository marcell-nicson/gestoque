<?php

namespace App\Http\Controllers;

use App\Services\Uzapi;
use Exception;
use Illuminate\Http\Request;

class WappController extends Controller
{
    public function adicionarContato(){

        
        try {

            $uzapi = new Uzapi();

            $grupoId = '120363303397548933';
            $numeros = [
                '558496377856',
                '558481345425',
                '558496539798',               
            ];

            foreach ($numeros as $numero) {

                $resposta = $uzapi->addParticipantGroup($grupoId, $numero);
                
                if($resposta){
                }
            }
         

        } catch (Exception $e) {
            info($e->getMessage());
        }

    }
}
