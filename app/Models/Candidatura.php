<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Candidatura extends Entidade
{
    use HasFactory;

    protected $table = 'candidaturas';

    protected $fillable = [
        'candidato_id',
        'oportunidade_id',
        'mensagem',
        'estado_id',
    ];

    protected $casts = [
        'criacao' => 'datetime',
        'ultimaAtualizacao' => 'datetime',
    ];

    public function candidato()
    {
        return $this->belongsTo(Candidato::class);
    }

    public function oportunidade()
    {
        return $this->belongsTo(Oportunidade::class);
    }

    public function estado()
    {
        return $this->belongsTo(Estado::class);
    }
}
