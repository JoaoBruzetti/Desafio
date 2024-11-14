<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CreateTarefaService;
use App\Services\ShowTarefasService;
use App\Services\UpdateTarefaService;
use App\Services\DeleteTarefaService;
use App\Enums\StatusTarefaEnum;
use App\Enums\OrdenacaoEnum;



class TarefaController extends Controller
{
    public function create(Request $request)
    {
        $createTarefaService = new CreateTarefaService();
        $createTarefaService->createTarefa($request);
        return response()->json(true);
    }

    public function show(Request $request)
    {
        $createTarefasService = new ShowTarefasService();
        $tarefas = $createTarefasService->showTarefas($request);
        return response()->json($tarefas);
    }

    public function update(Request $request, $id)
    {
        $updateTarefaService = new UpdateTarefaService();
        $update = $updateTarefaService->updateTarefa($id,$request);
        return response()->json($update);
    }

    public function delete($id)
    {
        $deleteTarefaService = new DeleteTarefaService();
        $delete = $deleteTarefaService->deleteTarefa($id);
        return response()->json($delete);
    }

    public function options()
    {
        return response()->json([
            'statusOptions' => StatusTarefaEnum::toArray(),
            'orderOptions' => OrdenacaoEnum::toArray()
        ]);
    }
}
