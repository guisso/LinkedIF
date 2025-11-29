<?php

namespace App\Http\Controllers;

// 1. Importações necessárias
use App\Models\Candidato;
use App\Http\Requests\StoreCandidatoRequest; // Nosso validador
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB; // Para usar Transações
use Throwable; // Para capturar erros

class CandidatoController extends Controller
{
    /**
     * Lista todos os candidatos com seus relacionamentos.
     * (GET /api/candidatos)
     */
    public function index(): JsonResponse
    {
        // 'with()' carrega os relacionamentos para evitar N+1 queries.
        $candidatos = Candidato::with('experiencias', 'cursos', 'competencias')->get();

        return response()->json($candidatos);
    }

    /**
     * Cria um novo candidato e suas entidades relacionadas.
     * (POST /api/candidatos)
     */
    public function store(StoreCandidatoRequest $request): JsonResponse
    {
        // $request já está validado!
        $validatedData = $request->validated();

        try {
            // Usamos uma transação para garantir que ou tudo é salvo, ou nada é.
            // Se salvar o curso falhar, o candidato não será criado.
            $candidato = DB::transaction(function () use ($validatedData) {

                // 1. Cria a entidade principal
                $candidato = Candidato::create([
                    'foto' => $validatedData['foto'] ?? null,
                ]);

                // 2. Cria as entidades relacionadas (usando o relacionamento)
                // Usar createMany() é muito mais performático que um loop!

                if (!empty($validatedData['experiencias'])) {
                    $candidato->experiencias()->createMany($validatedData['experiencias']);
                }

                if (!empty($validatedData['cursos'])) {
                    $candidato->cursos()->createMany($validatedData['cursos']);
                }

                if (!empty($validatedData['competencias'])) {
                    $candidato->competencias()->createMany($validatedData['competencias']);
                }

                // 3. Recarrega o candidato com todos os dados criados
                return $candidato->load('experiencias', 'cursos', 'competencias');
            });

            // Se tudo deu certo, retorna o candidato criado com status 201 (Created)
            return response()->json($candidato, 201);

        } catch (Throwable $e) {
            // Se algo deu errado na transação
            return response()->json([
                'message' => 'Erro ao criar candidato.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Exibe um candidato específico.
     * (GET /api/candidatos/{id})
     */
    public function show(string $id): JsonResponse
    {
        // findOrFail() retorna um 404 automaticamente se não encontrar
        $candidato = Candidato::with('experiencias', 'cursos', 'competencias')
            ->findOrFail($id);

        return response()->json($candidato);
    }

    /**
     * Atualiza um candidato. (PUT/PATCH /api/candidatos/{id})
     * (Fica como exercício, mas a lógica é parecida com a 'store')
     */
    public function update(StoreCandidatoRequest $request, string $id)
    {
        // Lógica de atualização aqui...
        // 1. Encontre o candidato
        // 2. Atualize os dados do candidato (ex: $candidato->update(...))
        // 3. Delete os relacionamentos antigos (ex: $candidato->experiencias()->delete())
        // 4. Crie os novos relacionamentos (igual na 'store')
    }

    /**
     * Deleta um candidato.
     * (DELETE /api/candidatos/{id})
     */
    public function destroy(string $id): JsonResponse
    {
        $candidato = Candidato::findOrFail($id);
        $candidato->delete(); // Graças ao 'onDelete('cascade')' na migration,
        // tudo relacionado a ele será apagado.

        return response()->json(null, 204); // 204 = No Content
    }
}