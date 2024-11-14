<?php

namespace App\Repositories;

use App\Models\Tarefa;
use Illuminate\Support\Facades\DB;

class TarefaRepository
{
    public function create(array $data)
    {
        Tarefa::insert([
            'nm' => $data['nm'],
            'nm_descricao' => $data['nm_descricao'],
        ]);
    }

    public function deleteById(int $id)
    {
        $tarefa = Tarefa::find($id);

        if ($tarefa) {
            return $tarefa->delete();
        }

        return false;
    }

    public function updateById(int $id, array $data)
    {
        $tarefa = Tarefa::find($id);
        if ($tarefa) {
            $tarefa->nm = $data['nm'] ?? $tarefa->nm;
            $tarefa->nm_descricao = $data['nm_descricao'] ?? $tarefa->nm_descricao;
            $tarefa->statustarefa_id = $data['statustarefa_id'] ?? $tarefa->statustarefa_id;

            return $tarefa->save();
        }

        return false;
    }

    public function getAllWithStatus(?string $orderBy = 'dt_criacao', ?string $direction = 'asc')
    {
        $validColumns = ['dt_criacao', 'statustarefa_id', 'nm'];
        if (!in_array($orderBy, $validColumns)) {
            $orderBy = 'dt_criacao';
        }

        return Tarefa::join('statustarefas', 'tarefas.statustarefa_id', '=', 'statustarefas.id')
            ->select(
                'tarefas.id',
                'tarefas.nm',
                'tarefas.nm_descricao',
                'tarefas.statustarefa_id',
                DB::raw("DATE_FORMAT(CONVERT_TZ(dt_criacao, '+00:00', '-03:00'), '%d/%m/%Y %H:%i') as dt"),
                'statustarefas.nm_cor',
                'statustarefas.nm as nm_status'
                )
            ->orderBy($orderBy, $direction)
            ->paginate(5);
    }
}
