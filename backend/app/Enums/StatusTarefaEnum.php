<?php

namespace App\Enums;

enum StatusTarefaEnum: int
{
    case PENDENTE = 1;
    case EM_ANDAMENTO = 2;
    case CONCLUIDA = 3;

    public static function toArray(): array
    {
        return [
            self::PENDENTE->value => 'Pendente',
            self::EM_ANDAMENTO->value => 'Em andamento',
            self::CONCLUIDA->value => 'Concluída',
        ];
    }
}
