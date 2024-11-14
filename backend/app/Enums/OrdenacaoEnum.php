<?php

namespace App\Enums;

enum OrdenacaoEnum: string
{
    case NOME = 'nm';
    case DATA = 'dt_criacao';
    case STATUS = 'statustarefa_id';

    public static function toArray(): array
    {
        return [
            self::NOME->value => 'Nome',
            self::DATA->value => 'Data',
            self::STATUS->value => 'Status',
        ];
    }
}
