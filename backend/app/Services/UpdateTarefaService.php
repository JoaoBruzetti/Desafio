<?php

namespace App\Services;

use App\Repositories\TarefaRepository;
use Illuminate\Validation\Rule;
use App\Enums\StatusTarefaEnum;



class UpdateTarefaService
{
    public function updateTarefa($id,$request)
    {
        $request->validate([
            'nm' => 'string|max:255',
            'nm_descricao' => 'string|max:255',
            'statustarefa_id' => [
                'integer',
                Rule::in(array_column(StatusTarefaEnum::cases(), 'value'))
            ],
        ]);

        $tarefaRepository = new TarefaRepository();
        return $tarefaRepository->updateById($id, $request->only(['nm', 'nm_descricao', 'statustarefa_id']));
    }

}
