<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class StoreCandidaturaRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Apenas usuários autenticados (candidatos) podem criar uma candidatura
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // Garante que o ID da oportunidade existe na tabela 'oportunidades'
            'oportunidade_id' => [
                'required',
                'integer',
                Rule::exists('oportunidades', 'id'),
            ],
            
            'mensagem' => 'nullable|string|max:250',
            'candidato_id' => 'sometimes|integer|exists:candidatos,id',
        ];
    }
}