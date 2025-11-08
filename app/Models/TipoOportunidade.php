<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


class TipoOportunidade extends Model
{
    use HasFactory;

    /**
     * O nome da tabela no banco.
     * @var string
     */
    protected $table = 'tipo_oportunidades';

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

    
    public function oportunidades(): HasMany
    {
       
        return $this->hasMany(Oportunidade::class);
    }

    // ==================== GETTERS ====================

    /**
     * Obtém o ID do tipo.
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Obtém o nome do tipo.
     * @return string
     */
    public function getNome(): string
    {
        return $this->nome;
    }

    // ==================== SETTERS ====================

    /**
     * Define o nome do tipo.
     *
     * @param string $nome Nome do tipo (max 20)
     * @return self
     */
    public function setNome(string $nome): self
    {
        $this->nome = $nome;
        return $this;
    }
}