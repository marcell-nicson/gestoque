<?php

namespace App\Http\Controllers;

use App\Models\Grupo;
use Exception;
use Illuminate\Http\Request;

class GrupoController extends Controller
{
   public function store(Request $request)
   {  
      try {

         $grupo = New Grupo();

         $grupo->nome = $request->nome;
         $grupo->grupo_id = $request->grupo_id;
         $grupo->descricao = $request->descricao ?? null;
         $grupo->save();
   
         return redirect()->route('afiliado.index')->with('success', 'Grupo criada com sucesso.');

      } catch (Exception $e) {
         info($e);
         return redirect()->route('afiliado.index')->with('danger', 'Erro ao Criar Grupo.');
     }
   }

   public function destroy($grupoId)
   {
      try {

         $grupo = Grupo::find($grupoId);      
         $grupo->delete();
   
         return redirect()->route('afiliado.index')->with('success', 'Grupo deletado com sucesso.');

      } catch (Exception $e) {
         info($e);
         return redirect()->route('afiliado.index')->with('danger', 'Erro ao deletar Grupo.');
     }
   }

}
