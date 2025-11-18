<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCandidatoRequest extends FormRequest
{
    /**
     * Determina se o usuário está autorizado a fazer esta requisição.
     */
    public function authorize(): bool
    {
        // Por enquanto, vamos permitir que qualquer um crie.
        // Você pode adicionar sua lógica de autenticação aqui depois.
        return true;
    }

    /**
     * Retorna as regras de validação que se aplicam à requisição.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // Regras para o Candidato
            'foto' => 'nullable|string|max:255', // O '??' do diagrama virou '255'

            // --- Validação de Arrays ---
            // 'experiencias' deve ser um array (pode ser vazio)
            'experiencias' => 'nullable|array',
            // Regras para CADA item dentro do array 'experiencias'
            'experiencias.*.instituicao' => 'required|string|max:100',
            'experiencias.*.funcao' => 'required|string|max:100',
            'experiencias.*.descricao' => 'required|string|max:500',
            'experiencias.*.inicio' => 'required|date|before_or_equal:today',
            'experiencias.*.termino' => 'nullable|date|before_or_equal:today|after_or_equal:experiencias.*.inicio',

            // 'cursos' deve ser um array (pode ser vazio)
            'cursos' => 'nullable|array',
            'cursos.*.nome' => 'required|string|max:20',
            'cursos.*.ingresso' => 'required|integer|min:1900|max:' . date('Y'),
            'cursos.*.conclusao' => 'nullable|integer|min:1900|max:' . (date('Y') + 10),
            'cursos.*.instituicao' => 'required|string|max:20',
            'cursos.*.sitio' => 'nullable|url',

            // 'competencias' deve ser um array (pode ser vazio)
            'competencias' => 'nullable|array',
            'competencias.*.descricao' => 'required|string|max:150',
        ];
    }
}