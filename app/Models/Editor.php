<?php

namespace App\Models;

use App\Models\Entidade; // Assumindo que herda de Entidade, senão use Model

class Editor extends Entidade
{
    // Define o nome correto da chave primária
    protected $primaryKey = 'usuario_id';

    protected $table = 'editores';

    // AVISO IMPORTANTE: Diz ao Laravel que a chave NÃO é auto-incrementável
    public $incrementing = false;

    // Define o tipo da chave (opcional, mas bom para clareza)
    protected $keyType = 'int';

    protected $fillable = [
        'usuario_id',
        'cnpj',
        'descricao'
    ];

    // Opcional: Definir relacionamento inverso para facilitar
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id', 'id');
    }

    // Getters
    public function getId(): int
    {
        return $this->usuario_id;
    }

    public function getCnpj(): ?string
    {
        return $this->cnpj;
    }

    public function getDescricao(): ?string
    {
        return $this->descricao;
    }
}