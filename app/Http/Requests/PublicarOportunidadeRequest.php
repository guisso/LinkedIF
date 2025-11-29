<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Enums\Modalidade;
use Illuminate\Validation\Rules\Enum;

/**
 * Request de validação para publicação de oportunidades.
 * Implementa as validações do CU04 - Publicar Oportunidade
 */
class PublicarOportunidadeRequest extends FormRequest
{
    /**
     * Determina se o usuário está autorizado a fazer esta requisição.
     * 
     * @return bool
     */
    public function authorize(): bool
    {
        // A autorização específica (verificar se é Editor) é feita no controller
        // Aqui verificamos apenas se está autenticado
        return $this->user() !== null;
    }

    /**
     * Regras de validação para publicação de oportunidade.
     * 
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // Campos obrigatórios
            'tipo_oportunidade_id' => 'required|integer|exists:tipo_oportunidades,id',
            'titulo' => 'required|string|max:120',
            'descricao' => 'required|string|max:500',
            'requisitos' => 'required|string|max:500',
            'modalidade' => ['required', 'integer', new Enum(Modalidade::class)],
            'inicio' => 'required|date|after_or_equal:today',
            
            // Campos opcionais
            'beneficios' => 'nullable|string|max:500',
            'remuneracao' => 'nullable|numeric|min:0|max:999999.99',
            'vagas' => 'nullable|integer|min:1|max:999',
            'termino' => 'nullable|date|after:inicio',
            'horario_inicio' => 'nullable|date_format:H:i',
            'horario_termino' => 'nullable|date_format:H:i|after:horario_inicio',
            'escala' => 'nullable|integer|min:1|max:255',
            'localidade' => 'nullable|string|max:50',
            
            // Habilidades (array de IDs)
            'habilidades' => 'nullable|array',
            'habilidades.*' => 'integer|exists:habilidades,id',
        ];
    }

    /**
     * Mensagens de erro personalizadas.
     * 
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            // Tipo de oportunidade
            'tipo_oportunidade_id.required' => 'O tipo de oportunidade é obrigatório.',
            'tipo_oportunidade_id.exists' => 'O tipo de oportunidade selecionado é inválido.',
            
            // Título
            'titulo.required' => 'O título é obrigatório.',
            'titulo.max' => 'O título não pode ter mais de 120 caracteres.',
            
            // Descrição
            'descricao.required' => 'A descrição é obrigatória.',
            'descricao.max' => 'A descrição não pode ter mais de 500 caracteres.',
            
            // Requisitos
            'requisitos.required' => 'Os requisitos são obrigatórios.',
            'requisitos.max' => 'Os requisitos não podem ter mais de 500 caracteres.',
            
            // Modalidade
            'modalidade.required' => 'A modalidade é obrigatória.',
            'modalidade.integer' => 'A modalidade deve ser um número válido.',
            
            // Data de início
            'inicio.required' => 'A data de início é obrigatória.',
            'inicio.date' => 'A data de início deve ser uma data válida.',
            'inicio.after_or_equal' => 'A data de início não pode ser anterior a hoje.',
            
            // Campos opcionais
            'beneficios.max' => 'Os benefícios não podem ter mais de 500 caracteres.',
            'remuneracao.numeric' => 'A remuneração deve ser um valor numérico.',
            'remuneracao.min' => 'A remuneração não pode ser negativa.',
            'remuneracao.max' => 'A remuneração não pode ultrapassar R$ 999.999,99.',
            'vagas.integer' => 'O número de vagas deve ser um número inteiro.',
            'vagas.min' => 'Deve haver pelo menos 1 vaga.',
            'vagas.max' => 'O número máximo de vagas é 999.',
            'termino.date' => 'A data de término deve ser uma data válida.',
            'termino.after' => 'A data de término deve ser posterior à data de início.',
            'horario_inicio.date_format' => 'O horário de início deve estar no formato HH:MM.',
            'horario_termino.date_format' => 'O horário de término deve estar no formato HH:MM.',
            'horario_termino.after' => 'O horário de término deve ser posterior ao horário de início.',
            'escala.integer' => 'A escala deve ser um número inteiro.',
            'escala.min' => 'A escala deve ser pelo menos 1.',
            'escala.max' => 'A escala não pode ser maior que 255.',
            'localidade.max' => 'A localidade não pode ter mais de 50 caracteres.',
            
            // Habilidades
            'habilidades.array' => 'As habilidades devem ser um array.',
            'habilidades.*.integer' => 'Cada habilidade deve ser um ID válido.',
            'habilidades.*.exists' => 'Uma das habilidades selecionadas não existe.',
        ];
    }

    /**
     * Nomes personalizados dos atributos para mensagens de erro.
     * 
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'tipo_oportunidade_id' => 'tipo de oportunidade',
            'titulo' => 'título',
            'descricao' => 'descrição',
            'requisitos' => 'requisitos',
            'beneficios' => 'benefícios',
            'remuneracao' => 'remuneração',
            'vagas' => 'número de vagas',
            'inicio' => 'data de início',
            'termino' => 'data de término',
            'horario_inicio' => 'horário de início',
            'horario_termino' => 'horário de término',
            'escala' => 'escala',
            'modalidade' => 'modalidade',
            'localidade' => 'localidade',
            'habilidades' => 'habilidades',
        ];
    }
}

