<?php

namespace App\Services;

use App\Repositories\TarefaRepository;

class CreateTarefaService
{
    public function createTarefa($request)
    {
        $request->validate([
            'nm' => 'required|string|max:255',
            'nm_descricao' => 'required|string|max:255',
        ]);

        $tarefaRepository = new TarefaRepository();

        $tarefaRepository->create($request->only(['nm', 'nm_descricao']));

        return true;

    }

}
