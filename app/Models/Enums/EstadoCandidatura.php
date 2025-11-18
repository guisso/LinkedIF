<?php

namespace App\Models\Enums;

enum EstadoCandidatura: int
{
    case LIDA        = 0;
    case EM_ANALISE  = 1;
    case APROVADA    = 2;
    case REJEITADA   = 3;
    case DESISTENCIA = 4;
}