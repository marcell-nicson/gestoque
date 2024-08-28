<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestUpdateFornecedor extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'nome' => 'nullable|string|max:255',
            'rua' => 'nullable|string|max:255',
            'numero' => 'nullable|string|max:255',
            'complemento' => 'nullable|string|max:255',
            'bairro' => 'nullable|string|max:255',
            'cidade' => 'nullable|string|max:255',
            'estado' => 'nullable|string|max:2',
            'cep' => 'nullable|string|max:10',
            'telefone' => 'nullable|string|max:255',
            'whatsapp' => 'nullable|string|max:255',
            'email' => 'nullable|string|max:255',
        ];
    }

    public function messages()
    {
        return [
            'nome.max' => 'O nome não pode ter mais que 255 caracteres.',
            'rua.max' => 'A rua não pode ter mais que 255 caracteres.',
            'numero.max' => 'O número não pode ter mais que 255 caracteres.',
            'complemento.max' => 'O complemento não pode ter mais que 255 caracteres.',
            'bairro.max' => 'O bairro não pode ter mais que 255 caracteres.',
            'cidade.max' => 'A cidade não pode ter mais que 255 caracteres.',
            'estado.max' => 'O estado não pode ter mais que 2 caracteres.',
            'cep.max' => 'O CEP não pode ter mais que 10 caracteres.',
            'telefone.max' => 'O telefone não pode ter mais que 255 caracteres.',
            'whatsapp.max' => 'O WhatsApp não pode ter mais que 255 caracteres.',
            'email.max' => 'O email não pode ter mais que 255 caracteres.',
        ];
    }
}
