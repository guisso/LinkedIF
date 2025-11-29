<?php

namespace App\Http\Controllers;

use App\Models\Candidatura;
use App\Models\Enums\EstadoCandidatura;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCandidaturaRequest;
use App\Http\Resources\CandidaturaResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class CandidaturaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Dependendo da lógica de negócio (candidato vê suas candidaturas, editor vê todas)
        // Por agora, retornamos uma coleção vazia ou implementamos o filtro:
        // Exemplo: return CandidaturaResource::collection(Auth::user()->candidaturas);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCandidaturaRequest $request): JsonResponse
    {
        // 1. Obter o ID do candidato autenticado (assumindo que o usuário é um Candidato)
        // Nota: Você deve garantir que o usuário autenticado (Auth::user()) corresponde a um Candidato.
        // Se a sua tabela 'users' for a de 'candidatos', você pode usar $request->user()->id.
        // Se houver uma tabela separada 'candidatos', você precisa fazer o mapeamento.
        
        // **ASSUMINDO QUE O ID DO USUÁRIO É O ID DO CANDIDATO**
        $candidatoId = Auth::id(); 
        
        // 2. Criar o array de dados para a candidatura
        $data = $request->validated();
        
        // Injetar o ID do candidato autenticado e o estado inicial (EM_ANALISE)
        $data['candidato_id'] = $candidatoId;
        $data['estado'] = EstadoCandidatura::EM_ANALISE->value;

        try {
            // 3. Criar a candidatura
            $candidatura = Candidatura::create($data);

            // 4. Retornar a resposta de sucesso
            return response()->json([
                'mensagem' => 'Candidatura enviada com sucesso e em análise.',
                'candidatura' => new CandidaturaResource($candidatura)
            ], 201);

        } catch (\Exception $e) {
            // Log do erro e retorno de falha
            \Log::error('Falha ao criar candidatura: ' . $e->getMessage());
            return response()->json([
                'mensagem' => 'Falha ao processar a candidatura.',
                'erro' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Candidatura $candidatura)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Candidatura $candidatura)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Candidatura $candidatura)
    {
        //
    }
}