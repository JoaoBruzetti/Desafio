<?php

use App\Models\StatusTarefa;
use App\Enums\StatusTarefaEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('statustarefas', function (Blueprint $table) {
            $table->id();
            $table->text('nm');
            $table->text('cor');
        });

        StatusTarefa::insert([
            ['id' => 1, 'nm' => 'Pendente', 'cor' => '#FF0000'],
            ['id' => 2, 'nm' => 'Em Andamento', 'cor' => '#FFFF00'],
            ['id' => 3, 'nm' => 'Concluída', 'cor' => '#00FF00'],
        ]);

        Schema::create('tarefas', function (Blueprint $table) {
            $table->id();
            $table->text('nm');
            $table->text('descricao');
            $table->foreignId('statustarefa_id')
                  ->constrained('statustarefas')
                  ->default(StatusTarefaEnum::PENDENTE->value);
            $table->timestamps();
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('statustarefas');
        Schema::dropIfExists('tarefas');
    }
};
