<?php

namespace App\Models;

use App\Models\Enums\Modalidade; 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Representa uma Oportunidade (vaga, pesquisa, etc.) criada por um Editor.
 *
 * @property int $id Identificador único
 * @property int $editor_id ID do Editor (User) que criou a oportunidade
 * @property int $tipo_oportunidade_id ID do Tipo de Oportunidade
 * @property string $codigo Código interno da vaga (max 20, único)
 * @property string $titulo Título da oportunidade (max 120)
 * @property string $descricao Descrição detalhada (max 500)
 * @property string $requisitos Requisitos da vaga (max 500)
 * @property string $beneficios Benefícios oferecidos (max 500)
 * @property float|null $remuneracao Valor da remuneração (decimal)
 * @property int $vagas Número de vagas (padrão 1)
 * @property \Carbon\Carbon $inicio Data de início
 * @property \Carbon\Carbon|null $termino Data de término (nulo se indefinido)
 * @property \Carbon\Carbon|null $horarioInicio Horário de início (nulo indica flexível)
 * @property \Carbon\Carbon|null $horarioTermino Horário de término (nulo indica flexível)
 * @property int|null $escala Escala de trabalho (mapeado como byte/tinyInt)
 * @property Modalidade $modalidade Enum (PRESENCIAL, REMOTO, HIBRIDO)
 * @property string|null $localidade Localidade da vaga (max 50)
 *
 * (Propriedades herdadas de Entidade)
 * @property \Carbon\Carbon $criacao Data de criação
 * @property \Carbon\Carbon|null $ultimaAtualizacao Data da última atualização
 */
class Oportunidade extends Entidade
{
    use HasFactory;

    /**
     * Atributos que podem ser atribuídos em massa.
     * @var array<int, string>
     */
    protected $fillable = [
        'editor_id',
        'tipo_oportunidade_id',
        'codigo',
        'titulo',
        'descricao',
        'requisitos',
        'beneficios',
        'remuneracao',
        'vagas',
        'inicio',
        'termino',
        'horarioInicio',
        'horarioTermino',
        'escala',
        'modalidade',
        'localidade',
    ];

    /**
     * Conversão de tipos dos atributos.
     * @var array<string, string>
     */
    protected $casts = [
        'remuneracao' => 'decimal:2',
        'vagas' => 'integer',
        'inicio' => 'date',
        'termino' => 'date',
        'horarioInicio' => 'datetime:H:i',
        'horarioTermino' => 'datetime:H:i',
        'escala' => 'integer',
        'modalidade' => Modalidade::class,
        'criacao' => 'datetime',
        'ultimaAtualizacao' => 'datetime',
    ];

    /**
     * Valores padrão dos atributos.
     * @var array
     */
    protected $attributes = [
        'vagas' => 1,
    ];

    // ==================== RELAÇÕES ====================

    /**
     * Relação N:1 com Editor.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function editor(): BelongsTo
    {
        return $this->belongsTo(Editor::class, 'editor_id');
    }

    /**
     * Relação N:1 com TipoOportunidade.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tipoOportunidade(): BelongsTo
    {
        return $this->belongsTo(TipoOportunidade::class);
    }

    /**
     * Relação N:N com Habilidade.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function habilidades(): BelongsToMany
    {
        return $this->belongsToMany(Habilidade::class, 'habilidade_oportunidade');
    }

    // ==================== GETTERS ====================

    public function getId(): int { return $this->id; }
    public function getEditorId(): int { return $this->editor_id; }
    public function getTipoOportunidadeId(): int { return $this->tipo_oportunidade_id; }
    public function getCodigo(): string { return $this->codigo; }
    public function getTitulo(): string { return $this->titulo; }
    public function getDescricao(): string { return $this->descricao; }
    public function getRequisitos(): string { return $this->requisitos; }
    public function getBeneficios(): string { return $this->beneficios; }
    public function getRemuneracao(): ?float { return $this->remuneracao; }
    public function getVagas(): int { return $this->vagas; }
    public function getInicio(): \Carbon\Carbon { return $this->inicio; }
    public function getTermino(): ?\Carbon\Carbon { return $this->termino; }
    public function getHorarioInicio(): ?\Carbon\Carbon { return $this->horarioInicio; }
    public function getHorarioTermino(): ?\Carbon\Carbon { return $this->horarioTermino; }
    public function getEscala(): ?int { return $this->escala; }
    public function getModalidade(): Modalidade { return $this->modalidade; }
    public function getLocalidade(): ?string { return $this->localidade; }
    public function getCriacao(): \Carbon\Carbon { return $this->criacao; }
    public function getUltimaAtualizacao(): ?\Carbon\Carbon { return $this->ultimaAtualizacao; }

    // ==================== SETTERS ====================

    public function setEditor(Editor $editor): self
    {
        $this->editor_id = $editor->getId();
        return $this;
    }

    public function setTipoOportunidade(TipoOportunidade $tipo): self
    {
        $this->tipo_oportunidade_id = $tipo->getId();
        return $this;
    }

    public function setCodigo(string $codigo): self
    {
        $this->codigo = $codigo;
        return $this;
    }

    public function setTitulo(string $titulo): self
    {
        $this->titulo = $titulo;
        return $this;
    }

    public function setDescricao(string $descricao): self
    {
        $this->descricao = $descricao;
        return $this;
    }

    public function setRequisitos(string $requisitos): self
    {
        $this->requisitos = $requisitos;
        return $this;
    }

    public function setBeneficios(string $beneficios): self
    {
        $this->beneficios = $beneficios;
        return $this;
    }

    public function setRemuneracao(?float $valor): self
    {
        $this->remuneracao = $valor;
        return $this;
    }

    public function setVagas(int $vagas): self
    {
        $this->vagas = $vagas;
        return $this;
    }

    public function setInicio(\Carbon\Carbon $data): self
    {
        $this->inicio = $data;
        return $this;
    }

    public function setTermino(?\Carbon\Carbon $data): self
    {
        $this->termino = $data;
        return $this;
    }

    public function setHorarioInicio(?\Carbon\Carbon $hora): self
    {
        $this->horarioInicio = $hora;
        return $this;
    }
    
    public function setHorarioTermino(?\Carbon\Carbon $hora): self
    {
        $this->horarioTermino = $hora;
        return $this;
    }

    public function setEscala(?int $escala): self
    {
        $this->escala = $escala;
        return $this;
    }

    public function setModalidade(Modalidade $modalidade): self
    {
        $this->modalidade = $modalidade;
        return $this;
    }

    public function setLocalidade(?string $localidade): self
    {
        $this->localidade = $localidade;
        return $this;
    }

    // ==================== MÉTODOS AUXILIARES ====================

    /**
     * Verifica se a modalidade é Presencial.
     * @return bool
     */
    public function isPresencial(): bool
    {
        return $this->modalidade === Modalidade::PRESENCIAL;
    }

    /**
     * Verifica se a modalidade é Remota.
     * @return bool
     */
    public function isRemoto(): bool
    {
        return $this->modalidade === Modalidade::REMOTO;
    }

    /**
     * Verifica se a modalidade é Híbrida.
     * @return bool
     */
    public function isHibrido(): bool
    {
        return $this->modalidade === Modalidade::HIBRIDO;
    }

    /**
     * Verifica se o horário é flexível.
     * @return bool
     */
    public function isHorarioFlexivel(): bool
    {
        // Conforme o UML: "Nulo indicará horário flexível"
        return is_null($this->horarioInicio);
    }
}