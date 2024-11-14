<?php

use App\Models\StatusTarefa;
use App\Enums\StatusTarefaEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;


return new class extends Migration
{
    public function up(): void
    {
        Schema::create('statustarefas', function (Blueprint $table) {
            $table->id();
            $table->text('nm');
            $table->text('nm_cor');
        });

        StatusTarefa::insert([
            ['id' => 1, 'nm' => 'Pendente', 'nm_cor' => 'danger'],
            ['id' => 2, 'nm' => 'Em Andamento', 'nm_cor' => 'warning'],
            ['id' => 3, 'nm' => 'Concluída', 'nm_cor' => 'success'],
        ]);

        Schema::create('tarefas', function (Blueprint $table) {
            $table->id();
            $table->text('nm');
            $table->text('nm_descricao');
            $table->timestamp('dt_criacao')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->unsignedBigInteger('statustarefa_id')->default(StatusTarefaEnum::PENDENTE->value);
            $table->foreign('statustarefa_id')->references('id')->on('statustarefas');

        });

    }

    public function down(): void
    {
        Schema::dropIfExists('statustarefas');
        Schema::dropIfExists('tarefas');
    }
};
