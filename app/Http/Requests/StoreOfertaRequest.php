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
            'valor_original' => 'nullable',
            'valor' => 'required|string',
            'codigo_produto' => 'nullable|string',
            'categoria_id' => 'nullable|integer',
            'tipo' => 'nullable|string', 
            'link' => 'required|string',
            'marca_id' => 'nullable|integer',
            'image' => 'nullable|image|max:2048',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'valor' => $this->valor ? str_replace(' ', '', $this->valor) : null,
            'valor_original' => $this->valor_original ? str_replace(' ', '', $this->valor_original) : null,
        ]);
    }
}
