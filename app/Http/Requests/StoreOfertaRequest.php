<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOfertaRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'nome' => 'required|string|max:255',
            'promocao' => 'nullable',
            'descricao' => 'nullable|string',
            'valor' => 'required|string',
            'codigo_produto' => 'nullable|string',
            'categoria_id' => 'nullable|integer',
            'tipo' => 'nullable|string', 
            'link' => 'required|string',
            'marca_id' => 'nullable|integer',
            'image' => 'nullable|image|max:2048',
        ];
    }
}
