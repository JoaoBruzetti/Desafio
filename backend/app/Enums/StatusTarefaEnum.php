<?php

namespace App\Enums;

enum StatusTarefaEnum: int
{
    case PENDENTE = 1;
    case EM_ANDAMENTO = 2;
    case CONCLUIDA = 3;
}
