<?php

namespace App\Services;

use App\Repositories\TarefaRepository;

class ShowTarefasService
{
    public function showTarefas($request)
    {
        $tarefaRepository = new TarefaRepository();

        return $tarefaRepository->getAllWithStatus($request->get('orderBy', 'dt_cricao'),$request->get('direction', 'asc'));
    }

}
