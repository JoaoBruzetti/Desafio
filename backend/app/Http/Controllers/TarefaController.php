<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tarefa;
use App\Enums\StatusTarefaEnum;
use Illuminate\Validation\Rule;


class TarefaController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            'nm' => 'required|string|max:255',
            'nm_descricao' => 'required|string|max:255',
        ]);

        $tarefa = Tarefa::create([
            'nm' => $request->nm,
            'nm_descricao' => $request->nm_descricao,
        ]);

        return response()->json($tarefa, 201);
    }

    public function show()
    {
       // Busca todos os registros da tabela tarefas
       $tarefas = Tarefa::all();

       // Retorna as tarefas como JSON
       return response()->json($tarefas);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nm' => 'string|max:255',
            'nm_descricao' => 'string|max:255',
            'statustarefa_id' => [
                'integer',
                Rule::in(array_column(StatusTarefaEnum::cases(), 'value'))
            ],
        ]);

        $tarefa = Tarefa::findOrFail($id);
        $tarefa->update($request->only(['nm', 'nm_descricao', 'statustarefa_id']));

        return response()->json($tarefa);
    }

    public function delete($id)
    {
        $tarefa = Tarefa::findOrFail($id);
        $tarefa->delete();

        return response()->json(null, 204);
    }
}
