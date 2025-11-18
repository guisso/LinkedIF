<?php

namespace App\Models\Enums;

/**
 * Enum para tipos de perfil de usuário no sistema.
 */
enum TipoPerfil: int
{
    case ADMINISTRADOR = 1;
    case EDITOR = 2;
    case CANDIDATO = 3;
    case EMPRESA = 4;
    case PROFESSOR = 5;

    /**
     * Retorna todos os valores do enum.
     *
     * @return array Lista com todos os valores possíveis
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * Retorna a descrição legível do perfil.
     *
     * @return string Descrição amigável do tipo de perfil
     */
    public function label(): string
    {
        return match ($this) {
            self::ADMINISTRADOR => 'Administrador',
            self::EDITOR => 'Editor',
            self::CANDIDATO => 'Candidato',
            self::EMPRESA => 'Empresa',
            self::PROFESSOR => 'Professor',
        };
    }
}
