<?php

namespace App\Models;

use App\Models\Enums\TipoPerfil;
use Illuminate\Support\Str;
use Illuminate\Contracts\Auth\Authenticatable; // NECESSÁRIO
use Illuminate\Auth\Authenticatable as AuthenticatableTrait; // NECESSÁRIO

/**
 * Classe Credencial para autenticação de usuários.
 */
class Credencial extends Entidade implements Authenticatable
{
    use AuthenticatableTrait;

    // --- CONFIGURAÇÃO CRÍTICA DE AUTH ---
    protected $table = 'credenciais';
    protected $primaryKey = 'usuario_id';
    public $incrementing = false;
    protected $keyType = 'int';

    public function getApiTokenName()
    {
        return 'api_token';
    }
    // --- FIM CONFIGURAÇÃO AUTH ---

    protected $fillable = [
        'usuario_id',
        'nome_usuario',
        'senha',
        'ativo',
        'codigo',
        'tipo_perfil',
        'api_token',
        'token_expira_em',
    ];

    protected $hidden = [
        'senha',
        'codigo',
        // 'api_token', 
    ];

    protected $casts = [
        'ativo' => 'boolean',
        'tipo_perfil' => TipoPerfil::class,
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'token_expira_em' => 'datetime',
    ];

    protected $attributes = [
        'ativo' => false,
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($credencial) {
            if (empty($credencial->codigo)) {
                $credencial->codigo = (string) Str::uuid();
            }
        });
    }

    // ==================== RELAÇÕES ====================

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    // ==================== GETTERS (IMPLEMENTADOS) ====================

    public function getId(): int
    {
        return $this->usuario_id;
    }

    public function getNomeUsuario(): string
    {
        return $this->nome_usuario;
    }

    public function getSenha(): string
    {
        return $this->senha;
    }

    public function isAtivo(): bool
    {
        return $this->ativo;
    }

    public function getCodigo(): string
    {
        return $this->codigo;
    }

    public function getTipoPerfil(): TipoPerfil
    {
        return $this->tipo_perfil;
    }

    public function getCriacao(): \DateTime
    {
        return $this->created_at;
    }

    public function getUltimaAtualizacao(): \DateTime
    {
        return $this->updated_at;
    }

    // ==================== SETTERS (IMPLEMENTADOS) ====================

    public function setNomeUsuario(string $nomeUsuario): self
    {
        $this->nome_usuario = $nomeUsuario;
        return $this;
    }

    public function setSenha(string $senha): self
    {
        $this->senha = $senha;
        return $this;
    }

    public function setAtivo(bool $ativo): self
    {
        $this->ativo = $ativo;
        return $this;
    }

    public function setCodigo(string $codigo): self
    {
        $this->codigo = $codigo;
        return $this;
    }

    public function setTipoPerfil(TipoPerfil $tipoPerfil): self
    {
        $this->tipo_perfil = $tipoPerfil;
        return $this;
    }

    // ==================== MÉTODOS AUXILIARES (CONTINUAÇÃO) ====================

    public function gerarNovoCodigo(): self
    {
        $this->codigo = (string) Str::uuid();
        return $this;
    }

    public function ativar(): self
    {
        $this->ativo = true;
        return $this;
    }

    public function desativar(): self
    {
        $this->ativo = false;
        return $this;
    }

    public function isAdministrador(): bool
    {
        return $this->tipo_perfil === TipoPerfil::ADMINISTRADOR;
    }

    public function isEditor(): bool
    {
        return $this->tipo_perfil === TipoPerfil::EDITOR;
    }

    public function isCandidato(): bool
    {
        return $this->tipo_perfil === TipoPerfil::CANDIDATO;
    }
}