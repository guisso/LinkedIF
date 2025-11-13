<?php

namespace App\Models;

// 1. Importa a sua classe base
use App\Models\Entidade;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

// 2. Herda de Entidade
class Experiencia extends Entidade
{
    // use HasFactory;

    protected $fillable = [
        'candidato_id',
        'instituicao',
        'funcao',
        'descricao',
        'inicio',
        'termino',
    ];

    public function candidato(): BelongsTo
    {
        return $this->belongsTo(Candidato::class);
    }
}