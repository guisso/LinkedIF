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
        return $this->hasMany(Experiencia::class, 'candidato_id', 'usuario_id');
    }

    public function cursos(): HasMany
    {
        return $this->hasMany(Curso::class, 'candidato_id', 'usuario_id');
    }

    public function competencias(): HasMany
    {
        return $this->hasMany(Competencia::class, 'candidato_id', 'usuario_id');
    }

    /**
     * Calcula a porcentagem de completude do perfil do candidato
     * Critérios: curso, foto, competências, cursos, experiências
     * 
     * @return float Porcentagem de completude (0-100)
     */
    public function calcularCompletudePerfilPorcentagem(): float
    {
        $criterios = [
            'curso' => !empty($this->curso), // 20%
            'foto' => !empty($this->foto), // 20%
            'competencias' => $this->competencias()->count() > 0, // 20%
            'cursos' => $this->cursos()->count() > 0, // 20%
            'experiencias' => $this->experiencias()->count() > 0, // 20%
        ];

        $pontos = array_sum(array_map(fn($preenchido) => $preenchido ? 20 : 0, $criterios));
        
        return $pontos;
    }

    /**
     * Verifica se o perfil está pelo menos 70% completo
     * 
     * @return bool
     */
    public function perfilCompleto(): bool
    {
        return $this->calcularCompletudePerfilPorcentagem() >= 70;
    }

    /**
     * Retorna os campos faltantes para completar 70% do perfil
     * 
     * @return array
     */
    public function camposFaltantes(): array
    {
        $faltantes = [];

        if (empty($this->curso)) {
            $faltantes[] = 'Curso';
        }
        if (empty($this->foto)) {
            $faltantes[] = 'Foto de perfil';
        }
        if ($this->competencias()->count() === 0) {
            $faltantes[] = 'Competências';
        }
        if ($this->cursos()->count() === 0) {
            $faltantes[] = 'Cursos/Formação acadêmica';
        }
        if ($this->experiencias()->count() === 0) {
            $faltantes[] = 'Experiências profissionais';
        }

        return $faltantes;
    }
}