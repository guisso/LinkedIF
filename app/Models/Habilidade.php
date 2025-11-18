<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Representa uma Habilidade que pode ser associada a Oportunidades ou Candidatos.
 *
 * @property int $id Identificador único da habilidade
 * @property string $nome Nome da habilidade (max 20, único)
 */
class Habilidade extends Model
{
    use HasFactory;

    /**
     * Indica que este model não usa os timestamps 'created_at' e 'updated_at'.
     * @var bool
     */
    public $timestamps = false;

    /**
     * Atributos que podem ser atribuídos em massa.
     * @var array<int, string>
     */
    protected $fillable = [
        'nome',
    ];

    /**
     * Relação N:N com Oportunidades.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function oportunidades(): BelongsToMany
    {
        return $this->belongsToMany(Oportunidade::class, 'habilidade_oportunidade');
    }

    // ==================== GETTERS ====================

    /**
     * Obtém o ID da habilidade.
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Obtém o nome da habilidade.
     * @return string
     */
    public function getNome(): string
    {
        return $this->nome;
    }

    // ==================== SETTERS ====================

    /**
     * Define o nome da habilidade.
     *
     * @param string $nome Nome da habilidade (max 20)
     * @return self
     */
    public function setNome(string $nome): self
    {
        $this->nome = $nome;
        return $this;
    }
}