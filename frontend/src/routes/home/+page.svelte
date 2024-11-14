<script lang="ts">
    import { onMount } from 'svelte';
    import Modal from './modal.svelte';

    const apiUrl = import.meta.env.VITE_API_URL;
    let token: string | null = null;

    onMount(() => {
        token = localStorage.getItem('jwt_token');
    });

    interface Tarefa {
        id: string;
        nm: string;
        nm_descricao: string;
        nm_cor: string;
        nm_status: string;
        statustarefa_id: string;
        dt: string;
    }

    interface PaginatedResponse {
        data: Tarefa[];
        current_page: number;
        last_page: number;
    }

    let tarefas: Tarefa[] = [];
    let tarefaAtual: Tarefa = {
        id: '',
        nm: '',
        nm_descricao: '',
        nm_cor: '',
        nm_status: '',
        statustarefa_id: '',
        dt: '',
    };

    let mostrarModalEdicao = false;
    let mostrarModalCriacao = false;
    let novaTarefa = { nm: '', nm_descricao: '' };

    let paginaAtual = 1;
    let totalDePaginas = 1;
    let ordenarPor = 'dt_criacao';
    let ordem = 'asc';

    async function buscarTarefas(pagina: number = 1) {
        const response = await fetch(
            `${apiUrl}api/tarefas?page=${pagina}&orderBy=${ordenarPor}&direction=${ordem}`, {
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${token}`,
                }
            });
        const data: PaginatedResponse = await response.json();
        tarefas = data.data;
        paginaAtual = data.current_page;
        totalDePaginas = data.last_page;
    }

    function abrirModalEdicao(tarefa: Tarefa) {
        tarefaAtual = {
            ...tarefa,
            statustarefa_id: String(tarefa.statustarefa_id)
        };
        mostrarModalEdicao = true;
    }

    function fecharModalEdicao() {
        mostrarModalEdicao = false;
    }

    function abrirModalCriacao() {
        novaTarefa = { nm: '', nm_descricao: '' };
        mostrarModalCriacao = true;
    }

    function fecharModalCriacao() {
        mostrarModalCriacao = false;
    }

    async function atualizarTarefa() {
        await fetch(`${apiUrl}api/tarefas/${tarefaAtual.id}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${token}`,
            },
            body: JSON.stringify(tarefaAtual),
        });
        await buscarTarefas(paginaAtual);
        fecharModalEdicao();
    }

    async function excluirTarefa() {
        await fetch(`${apiUrl}api/tarefas/${tarefaAtual.id}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${token}`,
            },
        });
        await buscarTarefas(paginaAtual);
        fecharModalEdicao();
    }

    async function criarTarefa() {
        await fetch(`${apiUrl}api/tarefas`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${token}`,
            },
            body: JSON.stringify(novaTarefa),
        });
        await buscarTarefas(paginaAtual);
        fecharModalCriacao();
    }

    function irParaPagina(pagina: number) {
        if (pagina >= 1 && pagina <= totalDePaginas) {
            buscarTarefas(pagina);
        }
    }

    function atualizarOrdenacao(campo: string) {
        ordenarPor = campo;
        buscarTarefas(paginaAtual);
    }

    function alternarOrdem() {
        ordem = ordem === 'asc' ? 'desc' : 'asc';
        buscarTarefas(paginaAtual);
    }

    onMount(() => buscarTarefas(paginaAtual));
</script>

<h1>Lista de Tarefas</h1>
<button on:click={abrirModalCriacao}>Criar Nova Tarefa</button>

<div>
    <label for="ordenarPor">Ordenar por:</label>
    <select id="ordenarPor" bind:value={ordenarPor} on:change={() => atualizarOrdenacao(ordenarPor)}>
        <option value="nm">Nome</option>
        <option value="dt_criacao">Data</option>
        <option value="statustarefa_id">Status</option>
    </select>
    <button on:click={alternarOrdem}>
        {ordem === 'asc' ? 'Ordem Ascendente' : 'Ordem Descendente'}
    </button>
</div>

<ul>
    {#each tarefas as tarefa}
        <li>
            {tarefa.nm} - {tarefa.dt} - {tarefa.nm_status} -
            <button on:click={() => abrirModalEdicao(tarefa)}>Editar</button>
        </li>
    {/each}
</ul>

{#if mostrarModalEdicao}
    <Modal on:close={fecharModalEdicao}>
      <h2>Editar Tarefa</h2>
      <label> {tarefaAtual.id} </label>
      <input type="text" bind:value={tarefaAtual.nm} placeholder="Nome" />
      <input type="text" bind:value={tarefaAtual.nm_descricao} placeholder="Descrição" />
      <select bind:value={tarefaAtual.statustarefa_id}>
        <option value="1">Pendente</option>
        <option value="2">Em andamento</option>
        <option value="3">Concluída</option>
      </select>
      <button on:click={atualizarTarefa}>Salvar</button>
      <button on:click={excluirTarefa}>Excluir</button>
    </Modal>
  {/if}

  {#if mostrarModalCriacao}
    <Modal on:close={fecharModalCriacao}>
      <h2>Criar Nova Tarefa</h2>
      <input type="text" bind:value={novaTarefa.nm} placeholder="Nome" />
      <input type="text" bind:value={novaTarefa.nm_descricao} placeholder="Descrição" />
      <button on:click={criarTarefa}>Criar</button>
    </Modal>
  {/if}


<div>
    <button on:click={() => irParaPagina(paginaAtual - 1)} disabled={paginaAtual === 1}>Anterior</button>
    <span>Página {paginaAtual} de {totalDePaginas}</span>
    <button on:click={() => irParaPagina(paginaAtual + 1)} disabled={paginaAtual === totalDePaginas}>Próxima</button>
</div>
