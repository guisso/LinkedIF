<?php

namespace App\Models;

// 1. Importa a sua classe base
use App\Models\Entidade;
use Illuminate\Database\Eloquent\Relations\HasMany;

// 2. Herda de Entidade, não de Model
class Candidato extends Entidade
{
    // HasFactory já vem da classe Entidade, mas é boa prática
    // mantê-lo aqui se você for usar factories específicas.
    // use HasFactory; 

    protected $fillable = [
        'foto',
    ];

    public function experiencias(): HasMany
    {
        return $this->hasMany(Experiencia::class);
    }

    public function cursos(): HasMany
    {
        return $this->hasMany(Curso::class);
    }

    public function competencias(): HasMany
    {
        return $this->hasMany(Competencia::class);
    }
}