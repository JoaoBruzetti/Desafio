<?php

namespace App\Services;

use App\Repositories\TarefaRepository;



class DeleteTarefaService
{
    public function deleteTarefa($id)
    {
        $tarefaRepository = new TarefaRepository();

        return $tarefaRepository->deleteById($id);
    }

}
