<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Representa um Usuário base no sistema (podendo ser Candidato ou Editor).
 *
 * @property int $id Identificador único
 * @property string $nome Nome do usuário (max 45)
 * @property string $email Email (max 250, único)
 * @property string $telefone Telefone (max 16)
 * @property bool $whatsApp Indica se o telefone é WhatsApp
 * @property \Carbon\Carbon $nascimento Data de nascimento
 * @property int $idade Idade (mapeado como byte/tinyInt)
 *
 * (Propriedades herdadas de Entidade)
 * @property \Carbon\Carbon $criacao Data de criação
 * @property \Carbon\Carbon|null $ultimaAtualizacao Data da última atualização
 */

class Usuario extends Entidade
{
    use HasFactory;

    /**
     * Atributos que podem ser atribuídos em massa.
     * @var array<int, string>
     */
    protected $fillable = [
        'nome',
        'email',
        'telefone',
        'whatsApp',
        'nascimento',
        'idade',
    ];

    /**
     * Conversão de tipos dos atributos.
     * @var array<string, string>
     */
    protected $casts = [
        'email' => 'string',
        'whatsApp' => 'boolean',
        'nascimento' => 'date',
        'idade' => 'integer', // 'byte' do UML mapeado para 'integer'
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // ==================== RELAÇÕES ====================

    /**
     * Relação 1:1 com Credencial.
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function credencial(): HasOne
    {
        return $this->hasOne(Credencial::class);
    }

    /**
     * Relação N:N (Usuários que este usuário segue).
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function segue(): BelongsToMany
    {
        // 'seguidor_seguido' é o nome da tabela pivo (pivot)
        // 'seguidor_id' é a chave estrangeira deste modelo
        // 'seguido_id' é a chave estrangeira do modelo relacionado
        return $this->belongsToMany(
            Usuario::class,
            'seguidor_seguido',
            'seguidor_id',
            'seguido_id'
        );
    }

    /**
     * Relação N:N (Usuários que seguem este usuário).
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function seguidoPor(): BelongsToMany
    {
        return $this->belongsToMany(
            Usuario::class,
            'seguidor_seguido',
            'seguido_id',
            'seguidor_id'
        );
    }

    // ==================== GETTERS ====================

    public function getId(): int
    {
        return $this->id;
    }
    public function getNome(): string
    {
        return $this->nome;
    }
    public function getEmail(): string
    {
        return $this->email;
    }
    public function getTelefone(): string
    {
        return $this->telefone;
    }
    public function isWhatsApp(): bool
    {
        return $this->whatsApp;
    }
    public function getNascimento(): \Carbon\Carbon
    {
        return $this->nascimento;
    }
    public function getIdade(): int
    {
        return $this->idade;
    }
    public function getCriacao(): \Carbon\Carbon
    {
        return $this->created_at;
    }
    public function getUltimaAtualizacao(): ?\Carbon\Carbon
    {
        return $this->updated_at;
    }

    // ==================== SETTERS ====================

    public function setNome(string $nome): self
    {
        $this->nome = $nome;
        return $this;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function setTelefone(string $telefone): self
    {
        $this->telefone = $telefone;
        return $this;
    }

    public function setWhatsApp(bool $status): self
    {
        $this->whatsApp = $status;
        return $this;
    }

    public function setNascimento(\Carbon\Carbon $data): self
    {
        $this->nascimento = $data;
        return $this;
    }

    public function setIdade(int $idade): self
    {
        $this->idade = $idade;
        return $this;
    }
}