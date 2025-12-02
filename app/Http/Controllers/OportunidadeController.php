<?php

namespace App\Http\Controllers;

use App\Http\Requests\PublicarOportunidadeRequest;
use App\Models\Oportunidade;
use App\Models\Editor;
use App\Models\Enums\Modalidade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

/**
 * Controller responsável pelo gerenciamento de oportunidades.
 * Implementa o CU04 - Publicar Oportunidade
 */
class OportunidadeController extends Controller
{
    /**
     * CU04 - Publicar Oportunidade
     * 
     * Permite que o ofertante (Professor/Empresa) publique uma nova vaga ou projeto.
     * 
     * @param PublicarOportunidadeRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(PublicarOportunidadeRequest $request)
    {
        DB::beginTransaction();

        try {
            // Obtém o usuário autenticado
            $credencial = $request->user();

            // Verifica se o usuário é um Editor (Professor ou Empresa)
            $editor = Editor::where('usuario_id', $credencial->getId())->first();

            if (!$editor) {
                return response()->json([
                    'success' => false,
                    'message' => 'Apenas Professores e Empresas podem publicar oportunidades.',
                ], 403);
            }

            // Gera código único para a oportunidade
            $codigo = $this->gerarCodigoUnico();

            // Prepara os dados validados
            $dados = $request->validated();

            // Cria a oportunidade
            $oportunidade = new Oportunidade();
            $oportunidade->editor_id = $editor->usuario_id;
            $oportunidade->tipo_oportunidade_id = $dados['tipo_oportunidade_id'];
            $oportunidade->codigo = $codigo;
            $oportunidade->titulo = $dados['titulo'];
            $oportunidade->descricao = $dados['descricao'];
            $oportunidade->requisitos = $dados['requisitos'];
            $oportunidade->beneficios = $dados['beneficios'] ?? '';
            $oportunidade->remuneracao = $dados['remuneracao'] ?? null;
            $oportunidade->vagas = $dados['vagas'] ?? 1;
            $oportunidade->inicio = Carbon::parse($dados['inicio']);

            // Define término automático em 60 dias se não especificado
            $oportunidade->termino = isset($dados['termino'])
                ? Carbon::parse($dados['termino'])
                : Carbon::now()->addDays(60);

            // Campos opcionais
            $oportunidade->horarioInicio = isset($dados['horario_inicio'])
                ? Carbon::parse($dados['horario_inicio'])
                : null;

            $oportunidade->horarioTermino = isset($dados['horario_termino'])
                ? Carbon::parse($dados['horario_termino'])
                : null;

            $oportunidade->escala = $dados['escala'] ?? null;
            $oportunidade->modalidade = Modalidade::from($dados['modalidade']);
            $oportunidade->localidade = $dados['localidade'] ?? null;

            $oportunidade->save();

            // Se houver habilidades, associa
            if (isset($dados['habilidades']) && is_array($dados['habilidades'])) {
                $oportunidade->habilidades()->attach($dados['habilidades']);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Oportunidade publicada com sucesso!',
                'data' => [
                    'id' => $oportunidade->id,
                    'codigo' => $oportunidade->codigo,
                    'titulo' => $oportunidade->titulo,
                    'descricao' => $oportunidade->descricao,
                    'tipo' => $oportunidade->tipoOportunidade->nome ?? 'N/A',
                    'vagas' => $oportunidade->vagas,
                    'modalidade' => $oportunidade->modalidade->label(),
                    'inicio' => $oportunidade->inicio->format('d/m/Y'),
                    'termino' => $oportunidade->termino ? $oportunidade->termino->format('d/m/Y') : null,
                    'criado_em' => $oportunidade->created_at->toDateTimeString(),
                ]
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Erro ao publicar oportunidade.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Lista todas as oportunidades (feed público)
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        try {
            $query = Oportunidade::with(['tipoOportunidade', 'editor.usuario'])
                ->where('termino', '>=', Carbon::now())
                ->orderBy('created_at', 'desc');

            // Filtros opcionais
            if ($request->has('tipo_oportunidade_id')) {
                $query->where('tipo_oportunidade_id', $request->tipo_oportunidade_id);
            }

            if ($request->has('modalidade')) {
                $query->where('modalidade', $request->modalidade);
            }

            if ($request->has('busca')) {
                $busca = $request->busca;
                $query->where(function ($q) use ($busca) {
                    $q->where('titulo', 'like', "%{$busca}%")
                        ->orWhere('descricao', 'like', "%{$busca}%");
                });
            }

            $oportunidades = $query->paginate(15);

            return response()->json([
                'success' => true,
                'data' => $oportunidades->map(function ($oportunidade) {
                    try {
                        return [
                            'id' => $oportunidade->id,
                            'codigo' => $oportunidade->codigo,
                            'titulo' => $oportunidade->titulo,
                            'descricao' => $oportunidade->descricao,
                            'requisitos' => $oportunidade->requisitos,
                            'beneficios' => $oportunidade->beneficios,
                            'remuneracao' => $oportunidade->remuneracao,
                            'vagas' => $oportunidade->vagas,
                            'tipo' => $oportunidade->tipoOportunidade->nome ?? 'N/A',
                            'modalidade' => $oportunidade->modalidade->label(),
                            'localidade' => $oportunidade->localidade,
                            'inicio' => $oportunidade->inicio->format('d/m/Y'),
                            'termino' => $oportunidade->termino ? $oportunidade->termino->format('d/m/Y') : null,
                            'editor' => [
                                'nome' => $oportunidade->editor->usuario->nome ?? 'N/A',
                            ],
                            'publicado_em' => $oportunidade->created_at->diffForHumans(),
                        ];
                    } catch (\Exception $e) {
                        \Log::error('Erro ao mapear oportunidade ID ' . $oportunidade->id . ': ' . $e->getMessage());
                        return null;
                    }
                })->filter(), // Remove valores null
                'pagination' => [
                    'total' => $oportunidades->total(),
                    'per_page' => $oportunidades->perPage(),
                    'current_page' => $oportunidades->currentPage(),
                    'last_page' => $oportunidades->lastPage(),
                ]
            ], 200);

        } catch (\Exception $e) {
            \Log::error('Erro ao listar oportunidades: ' . $e->getMessage() . ' | Trace: ' . $e->getTraceAsString());
            return response()->json([
                'success' => false,
                'message' => 'Erro ao listar oportunidades.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Exibe uma oportunidade específica
     * 
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try {
            $oportunidade = Oportunidade::with([
                'tipoOportunidade',
                'editor' => function ($query) {
                    $query->with('usuario');
                }
            ])->findOrFail($id);

            // Tenta carregar habilidades se a tabela existir
            $habilidades = [];
            try {
                $oportunidade->load('habilidades');
                $habilidades = $oportunidade->habilidades->map(function ($hab) {
                    return [
                        'id' => $hab->id,
                        'nome' => $hab->nome,
                    ];
                });
            } catch (\Exception $e) {
                // Tabela de relacionamento não existe ainda
                \Log::warning('Não foi possível carregar habilidades: ' . $e->getMessage());
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $oportunidade->id,
                    'codigo' => $oportunidade->codigo,
                    'titulo' => $oportunidade->titulo,
                    'descricao' => $oportunidade->descricao,
                    'requisitos' => $oportunidade->requisitos,
                    'beneficios' => $oportunidade->beneficios,
                    'remuneracao' => $oportunidade->remuneracao,
                    'vagas' => $oportunidade->vagas,
                    'tipo' => $oportunidade->tipoOportunidade->nome ?? 'N/A',
                    'modalidade' => $oportunidade->modalidade->label(),
                    'localidade' => $oportunidade->localidade,
                    'inicio' => $oportunidade->inicio->format('d/m/Y'),
                    'termino' => $oportunidade->termino ? $oportunidade->termino->format('d/m/Y') : null,
                    'horario_inicio' => $oportunidade->horarioInicio ? $oportunidade->horarioInicio->format('H:i') : null,
                    'horario_termino' => $oportunidade->horarioTermino ? $oportunidade->horarioTermino->format('H:i') : null,
                    'escala' => $oportunidade->escala,
                    'habilidades' => $habilidades,
                    'editor' => [
                        'nome' => $oportunidade->editor->usuario->nome ?? 'N/A',
                        'descricao' => $oportunidade->editor->descricao ?? '',
                    ],
                    'publicado_em' => $oportunidade->created_at->diffForHumans(),
                ]
            ], 200);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            \Log::error('Oportunidade não encontrada. ID: ' . $id);
            return response()->json([
                'success' => false,
                'message' => 'Oportunidade não encontrada.',
            ], 404);
        } catch (\Exception $e) {
            \Log::error('Erro ao buscar oportunidade: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Erro ao carregar oportunidade: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Exibe os detalhes de uma oportunidade específica para candidatura na interface web
     * 
     * @param int $id
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function showWeb($id)
    {
        try {
            $oportunidade = Oportunidade::with([
                'tipoOportunidade',
                'editor' => function ($query) {
                    $query->with('usuario');
                },
                'habilidades'
            ])->findOrFail($id);

            // Verifica se o usuário já se candidatou
            $jaCandidatado = false;
            if (auth()->check()) {
                $credencial = auth()->user();
                $usuarioId = $credencial->getId();
                
                $jaCandidatado = \App\Models\Candidatura::whereHas('candidato', function($query) use ($usuarioId) {
                    $query->where('usuario_id', $usuarioId);
                })
                ->where('oportunidade_id', $id)
                ->exists();
            }

            return view('oportunidades.show', compact('oportunidade', 'jaCandidatado'));

        } catch (\Exception $e) {
            return redirect()->route('home')->with('error', 'Oportunidade não encontrada.');
        }
    }

    /**
     * Gera um código único para a oportunidade
     * 
     * @return string
     */
    private function gerarCodigoUnico(): string
    {
        do {
            // Formato: OPT-YYYYMMDD-XXXX (exemplo: OPT-20251126-A1B2)
            $codigo = 'OPT-' . date('Ymd') . '-' . strtoupper(Str::random(4));
        } while (Oportunidade::where('codigo', $codigo)->exists());

        return $codigo;
    }
}

