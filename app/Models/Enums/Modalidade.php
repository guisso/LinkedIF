<?php

namespace App\Models\Enums;


enum Modalidade: int
{
    case PRESENCIAL = 1;
    case REMOTO = 2;
    case HIBRIDO = 3;

    
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }


    public function label(): string
    {
        return match($this) {
            self::PRESENCIAL => 'Presencial',
            self::REMOTO => 'Remoto',
            self::HIBRIDO => 'Híbrido',
        };
    }
}