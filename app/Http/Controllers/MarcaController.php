<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use Exception;
use Illuminate\Http\Request;

class MarcaController extends Controller
{
    public function store(Request $request)
    {
        try {
            $request->validate([
                'nome' => 'required|string|max:255',
            ]);
    
            Marca::create($request->all());
          
            return redirect()->route('produtos.index')
                ->with('success', 'Marca criada com sucesso.');

        } catch (Exception $e) {
            info($e);
        }
        
    }
}
