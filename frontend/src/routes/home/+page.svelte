<script lang="ts">
    import { onMount } from 'svelte';
    import Modal from './modal.svelte';

    const apiUrl = import.meta.env.VITE_API_URL;
    const token = localStorage.getItem('jwt_token');

    interface Tarefa {
        id: string;
        nm: string;
        nm_descricao: string;
        nm_cor: string;
        statustarefa_id: string;
        created: string;
    }

    let tarefas: Tarefa[] = [];
    let tarefaAtual: Tarefa = {
        id: '',
        nm: '',
        nm_descricao: '',
        nm_cor: '',
        statustarefa_id: '',
        created: '',
    };

    let mostrarModalEdicao = false;
    let mostrarModalCriacao = false;

    let novaTarefa = {
      nm: '',
      nm_descricao: '',
    };

    // Busca as tarefas no endpoint Laravel
    async function buscarTarefas() {
      const response = await fetch(`${apiUrl}/api/tarefas`, {
        headers: {
          'Content-Type': 'application/json',
          'Authorization': `Bearer ${token}`,
        }
      });
      tarefas = await response.json();
    }

    // Abre o modal de edição
    function abrirModalEdicao(tarefa: Tarefa) {
      tarefaAtual = { ...tarefa };
      mostrarModalEdicao = true;
    }

    // Fecha o modal de edição
    function fecharModalEdicao() {
      mostrarModalEdicao = false;
    }

    // Abre o modal de criação
    function abrirModalCriacao() {
      novaTarefa = { nm: '', nm_descricao: '' };
      mostrarModalCriacao = true;
    }

    // Fecha o modal de criação
    function fecharModalCriacao() {
      mostrarModalCriacao = false;
    }

    // Função para atualizar a tarefa
    async function atualizarTarefa() {
      await fetch(`${apiUrl}/api/tarefas/${tarefaAtual?.id}`, {
        method: 'PUT',
        headers: {
          'Content-Type': 'application/json',
          'Authorization': `Bearer ${token}`,
        },
        body: JSON.stringify(tarefaAtual),
      });
      await buscarTarefas();
      fecharModalEdicao();
    }

    // Função para excluir a tarefa
    async function excluirTarefa() {
      await fetch(`${apiUrl}/api/tarefas/${tarefaAtual.id}`, {
        method: 'DELETE',
        headers: {
          'Content-Type': 'application/json',
          'Authorization': `Bearer ${token}`,
        },
      });
      await buscarTarefas();
      fecharModalEdicao();
    }

    // Função para criar uma nova tarefa
    async function criarTarefa() {

      await fetch(`${apiUrl}/api/tarefas`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Authorization': `Bearer ${token}`,
        },
        body: JSON.stringify(novaTarefa),
      });

      await buscarTarefas(); // Atualiza a lista de tarefas
      fecharModalCriacao();
    }

    onMount(buscarTarefas);
  </script>

  <h1>Lista de Tarefas</h1>
  <button on:click={abrirModalCriacao}>Criar Nova Tarefa</button>

  <ul>
    {#each tarefas as tarefa}
      <li>
        {tarefa.nm} - {tarefa.nm_descricao}
        <button on:click={() => abrirModalEdicao(tarefa)}>Editar</button>
      </li>
    {/each}
  </ul>

  {#if mostrarModalEdicao}
    <Modal on:close={fecharModalEdicao}>
      <h2>Editar Tarefa</h2>
      <input type="text" bind:value={tarefaAtual.nm} placeholder="Nome" />
      <input type="text" bind:value={tarefaAtual.nm_descricao} placeholder="Descrição" />
      <select bind:value={tarefaAtual.statustarefa_id}>
        <option value="1">Pendente</option>
        <option value="2">Em andamento</option>
        <option value="3">Concluída</option>
      </select>
      <button on:click={atualizarTarefa}>Salvar</button>
      <button on:click={excluirTarefa}>Excluir</button>
      <button on:click={fecharModalEdicao}>Cancelar</button>
    </Modal>
  {/if}

  {#if mostrarModalCriacao}
    <Modal on:close={fecharModalCriacao}>
      <h2>Criar Nova Tarefa</h2>
      <input type="text" bind:value={novaTarefa.nm} placeholder="Nome" />
      <input type="text" bind:value={novaTarefa.nm_descricao} placeholder="Descrição" />
      <button on:click={criarTarefa}>Criar</button>
      <button on:click={fecharModalCriacao}>Cancelar</button>
    </Modal>
  {/if}
