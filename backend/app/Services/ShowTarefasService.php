<?php

namespace App\Services;

use App\Repositories\TarefaRepository;

class ShowTarefasService
{
    public function showTarefas($request)
    {
        $tarefaRepository = new TarefaRepository();

        return $tarefaRepository->getAllWithStatus($request->get('order_by', 'dt_cricao'),$request->get('direction', 'asc'));
    }

}
