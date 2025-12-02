<?php

namespace App\Http\Controllers;

use App\Models\Candidatura;
use App\Models\Candidato;
use App\Models\Oportunidade;
use App\Models\Enums\EstadoCandidatura;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCandidaturaRequest;
use App\Http\Resources\CandidaturaResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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
     * Registra a candidatura via interface web
     * 
     * @param Request $request
     * @param int $oportunidadeId
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeWeb(Request $request, $oportunidadeId)
    {
        try {
            \Log::info('Iniciando candidatura', ['oportunidade_id' => $oportunidadeId]);
            
            // Tenta autenticar via token Bearer (do localStorage)
            $token = $request->bearerToken() ?: $request->header('Authorization');
            $credencial = null;

            if ($token) {
                // Remove "Bearer " se existir
                $token = str_replace('Bearer ', '', $token);
                $credencial = \App\Models\Credencial::where('api_token', $token)->first();
                \Log::info('Autenticação via token', ['credencial_encontrada' => $credencial ? true : false]);
            }

            // Se não encontrou via token, tenta via sessão padrão
            if (!$credencial) {
                $credencial = auth()->user();
                \Log::info('Autenticação via sessão', ['credencial_encontrada' => $credencial ? true : false]);
            }
            
            if (!$credencial) {
                \Log::warning('Nenhuma credencial encontrada');
                return response()->json([
                    'success' => false,
                    'message' => 'Você precisa estar logado para se candidatar.'
                ], 401);
            }

            $usuarioId = $credencial->getId();
            \Log::info('Usuario ID obtido', ['usuario_id' => $usuarioId]);

            // Verifica se existe um Candidato associado a este usuário
            $candidato = Candidato::with(['competencias', 'cursos', 'experiencias'])
                ->where('usuario_id', $usuarioId)
                ->first();

            \Log::info('Candidato encontrado', [
                'candidato_id' => $candidato ? $candidato->usuario_id : null,
                'curso' => $candidato ? $candidato->curso : null,
                'foto' => $candidato ? $candidato->foto : null,
                'competencias_count' => $candidato ? $candidato->competencias->count() : 0,
                'cursos_count' => $candidato ? $candidato->cursos->count() : 0,
                'experiencias_count' => $candidato ? $candidato->experiencias->count() : 0
            ]);

            if (!$candidato) {
                return response()->json([
                    'success' => false,
                    'message' => 'Apenas candidatos podem se candidatar a oportunidades.'
                ], 403);
            }

            // Verifica se o perfil está pelo menos 70% completo
            if (!$candidato->perfilCompleto()) {
                $camposFaltantes = $candidato->camposFaltantes();
                $completude = $candidato->calcularCompletudePerfilPorcentagem();
                
                \Log::info('Perfil incompleto', [
                    'candidato_id' => $candidato->usuario_id,
                    'completude' => $completude,
                    'campos_faltantes' => $camposFaltantes
                ]);
                
                return response()->json([
                    'success' => false,
                    'message' => 'Seu perfil precisa estar pelo menos 70% completo para se candidatar.',
                    'completude' => $completude,
                    'campos_faltantes' => $camposFaltantes
                ], 400);
            }

            // Verifica se a oportunidade existe
            $oportunidade = Oportunidade::findOrFail($oportunidadeId);

            // Verifica se já existe uma candidatura para esta oportunidade
            $candidaturaExistente = Candidatura::where('candidato_id', $candidato->usuario_id)
                ->where('oportunidade_id', $oportunidadeId)
                ->first();

            if ($candidaturaExistente) {
                return response()->json([
                    'success' => false,
                    'message' => 'Você já se candidatou a esta oportunidade.'
                ], 400);
            }

            // Cria a candidatura
            Candidatura::create([
                'candidato_id' => $candidato->usuario_id,
                'oportunidade_id' => $oportunidadeId,
                'estado' => EstadoCandidatura::EM_ANALISE
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Candidatura realizada com sucesso!'
            ], 200);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            \Log::error('Oportunidade não encontrada', ['exception' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Oportunidade não encontrada.'
            ], 404);
        } catch (\Exception $e) {
            \Log::error('Erro ao criar candidatura', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Erro ao realizar candidatura: ' . $e->getMessage(),
                'debug' => [
                    'file' => $e->getFile(),
                    'line' => $e->getLine()
                ]
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