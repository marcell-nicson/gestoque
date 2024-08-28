<?php

namespace App\Http\Controllers;

use App\Models\Grupo;
use App\Services\Uzapi;
use Exception;
use Illuminate\Http\Request;

class AfiliadoController extends Controller
{
    public function index()
    {

        $grupos = Grupo::all();

        $selectgrupos = $grupos->pluck('nome', 'id');
        
        return view('afiliado.index', compact('grupos', 'selectgrupos'));

    }

    public function adicionarMembrosNoGrupo(Request $request)
    {
        try {

            $uzapi = new Uzapi();
            $grupoId = Grupo::find($request->IdGrupo)->grupo_id;
            $idsContatos = explode(',', str_replace(["\r\n", "\n", "\r", ' '], '', $request->idsContatos));    
            // $grupoId = '120363303397548933';
            
            if($grupoId and $idsContatos){                
                foreach ($idsContatos as $numero) {
                    $resposta = $uzapi->addParticipantGroup($grupoId, $numero);
                    info($resposta);
                }
            }

            return redirect()->back()->with('success',  'Membros adicionados com sucesso!');

        } catch (Exception $e) {
            info($e->getMessage());

            return $e->getMessage();
        }

    }
}
