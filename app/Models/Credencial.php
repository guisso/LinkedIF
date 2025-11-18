<?php

namespace App\Models;

use App\Models\Enums\TipoPerfil;
use Illuminate\Support\Str;

/**
 * Classe Credencial para autenticação de usuários.
 * Gerencia as credenciais de acesso ao sistema.
 * 
 * @property int $id Identificador único da credencial
 * @property string $nome_usuario Nome de usuário (max 20 caracteres, único)
 * @property string $senha Senha hasheada do usuário
 * @property bool $ativo Indica se a conta está ativa (padrão: false)
 * @property string $codigo Código UUID para ativação/recuperação de senha
 * @property TipoPerfil $tipo_perfil Tipo de perfil do usuário
 * @property \DateTime $criacao Data e hora de criação
 * @property \DateTime $ultima_atualizacao Data e hora da última atualização
 */
class Credencial extends Entidade
{
    /**
     * Nome da tabela associada ao model.
     *
     * @var string
     */
    protected $table = 'credenciais';

    /**
     * Atributos que podem ser atribuídos em massa.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nome_usuario',
        'senha',
        'ativo',
        'codigo',
        'tipo_perfil',
        'api_token',
        'token_expira_em',
    ];

    /**
     * Atributos que devem ser ocultados na serialização (JSON).
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'senha',
        'codigo',
        'api_token',
    ];

    /**
     * Conversão de tipos dos atributos.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'ativo' => 'boolean',
        'tipo_perfil' => TipoPerfil::class,
        'criacao' => 'datetime',
        'ultima_atualizacao' => 'datetime',
        'token_expira_em' => 'datetime',
    ];

    /**
     * Valores padrão dos atributos.
     *
     * @var array
     */
    protected $attributes = [
        'ativo' => false,
    ];

    /**
     * Método de inicialização do model.
     * Gera automaticamente um código UUID ao criar nova credencial.
     */
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

    /**
     * Relação 1:1 com Usuario.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }

    // ==================== GETTERS ====================

    /**
     * Obtém o identificador único da credencial.
     *
     * @return int ID da credencial
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Obtém o nome de usuário.
     *
     * @return string Nome de usuário
     */
    public function getNomeUsuario(): string
    {
        return $this->nome_usuario;
    }

    /**
     * Obtém a senha hasheada.
     *
     * @return string Hash da senha
     */
    public function getSenha(): string
    {
        return $this->senha;
    }

    /**
     * Verifica se a credencial está ativa.
     *
     * @return bool Verdadeiro se ativo, falso caso contrário
     */
    public function isAtivo(): bool
    {
        return $this->ativo;
    }

    /**
     * Obtém o código UUID para ativação/recuperação.
     *
     * @return string Código UUID
     */
    public function getCodigo(): string
    {
        return $this->codigo;
    }

    /**
     * Obtém o tipo de perfil do usuário.
     *
     * @return TipoPerfil Tipo de perfil (ADMINISTRADOR, EDITOR ou CANDIDATO)
     */
    public function getTipoPerfil(): TipoPerfil
    {
        return $this->tipo_perfil;
    }

    /**
     * Obtém a data e hora de criação da credencial.
     *
     * @return \DateTime Data de criação
     */
    public function getCriacao(): \DateTime
    {
        return $this->criacao;
    }

    /**
     * Obtém a data e hora da última atualização.
     *
     * @return \DateTime Data da última atualização
     */
    public function getUltimaAtualizacao(): \DateTime
    {
        return $this->ultima_atualizacao;
    }

    // ==================== SETTERS ====================

    /**
     * Define o nome de usuário.
     *
     * @param string $nomeUsuario Nome de usuário (máximo 20 caracteres)
     * @return self Retorna a própria instância para encadeamento
     */
    public function setNomeUsuario(string $nomeUsuario): self
    {
        $this->nome_usuario = $nomeUsuario;
        return $this;
    }

    /**
     * Define a senha do usuário.
     * IMPORTANTE: A senha deve ser hasheada antes de chamar este método.
     *
     * @param string $senha Hash da senha
     * @return self Retorna a própria instância para encadeamento
     */
    public function setSenha(string $senha): self
    {
        $this->senha = $senha;
        return $this;
    }

    /**
     * Define se a credencial está ativa ou inativa.
     *
     * @param bool $ativo Verdadeiro para ativar, falso para desativar
     * @return self Retorna a própria instância para encadeamento
     */
    public function setAtivo(bool $ativo): self
    {
        $this->ativo = $ativo;
        return $this;
    }

    /**
     * Define o código UUID manualmente.
     *
     * @param string $codigo Código UUID válido
     * @return self Retorna a própria instância para encadeamento
     */
    public function setCodigo(string $codigo): self
    {
        $this->codigo = $codigo;
        return $this;
    }

    /**
     * Define o tipo de perfil do usuário.
     *
     * @param TipoPerfil $tipoPerfil Tipo de perfil (ADMINISTRADOR, EDITOR ou CANDIDATO)
     * @return self Retorna a própria instância para encadeamento
     */
    public function setTipoPerfil(TipoPerfil $tipoPerfil): self
    {
        $this->tipo_perfil = $tipoPerfil;
        return $this;
    }

    // ==================== MÉTODOS AUXILIARES ====================

    /**
     * Gera um novo código UUID.
     * Útil para renovar código de ativação ou recuperação de senha.
     *
     * @return self Retorna a própria instância para encadeamento
     */
    public function gerarNovoCodigo(): self
    {
        $this->codigo = (string) Str::uuid();
        return $this;
    }

    /**
     * Ativa a credencial.
     * Permite que o usuário acesse o sistema.
     *
     * @return self Retorna a própria instância para encadeamento
     */
    public function ativar(): self
    {
        $this->ativo = true;
        return $this;
    }

    /**
     * Desativa a credencial.
     * Impede que o usuário acesse o sistema.
     *
     * @return self Retorna a própria instância para encadeamento
     */
    public function desativar(): self
    {
        $this->ativo = false;
        return $this;
    }

    /**
     * Verifica se o usuário é administrador.
     *
     * @return bool Verdadeiro se for administrador
     */
    public function isAdministrador(): bool
    {
        return $this->tipo_perfil === TipoPerfil::ADMINISTRADOR;
    }

    /**
     * Verifica se o usuário é editor.
     *
     * @return bool Verdadeiro se for editor
     */
    public function isEditor(): bool
    {
        return $this->tipo_perfil === TipoPerfil::EDITOR;
    }

    /**
     * Verifica se o usuário é candidato.
     *
     * @return bool Verdadeiro se for candidato
     */
    public function isCandidato(): bool
    {
        return $this->tipo_perfil === TipoPerfil::CANDIDATO;
    }
}
