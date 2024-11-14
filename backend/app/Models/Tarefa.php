<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tarefa extends Model
{
    use HasFactory;

    protected $table = 'tarefas';

    public $timestamps = false;

    protected $fillable = [
        'nm',
        'nm_descricao',
        'dt_criacao',
    ];
}
