<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Enums\EstadoCandidatura;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Candidatura extends Entidade
{
    use HasFactory;

    protected $table = 'candidaturas';

    // Campos que podem ser preenchidos via create() ou fill()
    protected $fillable = [
        'candidato_id',
        'oportunidade_id',
        'mensagem',
        'estado',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'estado'     => EstadoCandidatura::class, // ← transforma o número em objeto enum automaticamente
    ];

    // Relacionamentos (obrigatórios para API)
    public function candidato(): BelongsTo
    {
        return $this->belongsTo(Candidato::class);
    }

    public function oportunidade(): BelongsTo
    {
        return $this->belongsTo(Oportunidade::class);
    }

    protected static function booted()
    {
        static::retrieved(function (Candidatura $candidatura) {
            // Se o usuário logado for editor E o estado ainda for EM_ANALISE → vira LIDA
            if (
                auth()->check() &&
                auth()->user()->isEditor() && // ← você precisa ter esse método no User
                $candidatura->estado === EstadoCandidatura::EM_ANALISE
            ) {
                $candidatura->update(['estado' => EstadoCandidatura::LIDA->value]);
            }
        });
    }
}