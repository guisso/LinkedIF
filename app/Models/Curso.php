<?php

namespace App\Models;

// 1. Importa a sua classe base
use App\Models\Entidade;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

// 2. Herda de Entidade
class Curso extends Entidade
{
    // use HasFactory;

    protected $fillable = [
        'candidato_id',
        'nome',
        'ingresso',
        'conclusao',
        'instituicao',
        'sitio',
    ];

    public function candidato(): BelongsTo
    {
        return $this->belongsTo(Candidato::class);
    }
}