<?php

namespace App\Models;

// 1. Importa a sua classe base
use App\Models\Entidade;
use Illuminate\Database\Eloquent\Relations\HasMany;

// 2. Herda de Entidade, não de Model
class Candidato extends Entidade
{
    // 1. Defina o nome da chave primária correta
    protected $primaryKey = 'usuario_id';

    // 2. Avise que ela NÃO é auto-incrementável (pois vem do Usuario pai)
    public $incrementing = false;

    // 3. Defina o tipo da chave (geralmente int, mas bom garantir)
    protected $keyType = 'int';

    protected $fillable = [
        'usuario_id',
        'curso',
        'foto'
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