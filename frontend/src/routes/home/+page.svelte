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

    interface Option {
        [key: string]: string;
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

    let statusOptions: Option = {};
    let orderOptions: Option = {};

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

    async function buscarOpcoes() {
        const response = await fetch(`${apiUrl}api/options`, {
            headers: { 'Authorization': `Bearer ${token}` },
        });
        const data = await response.json();
        statusOptions = data.statusOptions;
        orderOptions = data.orderOptions;
        console.log(statusOptions,orderOptions)
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

    onMount(() => {
        buscarTarefas(paginaAtual);
        buscarOpcoes();
    })
</script>
<style>
    .status-badge {
        padding: 0.5em 1em;
        color: #fff;
        border-radius: 4px;
        font-size: 0.875em;
        text-align: center;
    }
    .small-btn {
        font-size: 0.875rem;
        padding: 0.25em 0.75em;
    }
  </style>

  <div class="d-flex justify-content-center align-items-center vh-100">
    <div class="container" style="max-width: 800px;">
      <h2 class="text-center mb-4 fw-bold">Lista de Tarefas</h2>

      <div class="d-flex justify-content-between mb-3">
        <!-- <button class="btn btn-primary" on:click={abrirModalCriacao}>Criar Nova Tarefa</button> -->
        <button class="btn btn-primary small-btn" on:click={abrirModalCriacao}>Criar Nova Tarefa</button>

        <div class="d-flex align-items-center">
          <label for="ordenarPor" class="form-label me-2">Ordenar por:</label>
          <select id="ordenarPor" class="form-select" bind:value={ordenarPor} on:change={() => atualizarOrdenacao(ordenarPor)}>
            {#each Object.entries(orderOptions) as [key, value]}
                <option value={key}>{value}</option>
            {/each}
            </select>
          <button class="btn btn-secondary ms-2" on:click={alternarOrdem}>
            {ordem === 'asc' ? 'Crescente' : 'Decrescente'}
          </button>
        </div>
      </div>

      <table class="table table-bordered table-hover">
        <thead class="table-light">
          <tr>
            <th>Título</th>
            <th>Data</th>
            <th>Status</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody>
          {#each tarefas as tarefa}
            <tr>
              <td>{tarefa.nm}</td>
              <td>{tarefa.dt}</td>
              <td>
                <span class="status-badge bg-{tarefa.nm_cor}">
                  {tarefa.nm_status}
                </span>
              </td>
              <td>
                <button class="btn btn-outline-primary btn-sm" on:click={() => abrirModalEdicao(tarefa)}>Editar</button>
              </td>
            </tr>
          {/each}
        </tbody>
      </table>

      <!-- Paginação -->
    <div class="d-flex justify-content-center align-items-center mt-3">
  <button class="btn btn-secondary small-btn me-2" on:click={() => irParaPagina(paginaAtual - 1)} disabled={paginaAtual === 1}>
    Anterior
  </button>
  <span>Página {paginaAtual} de {totalDePaginas}</span>
  <button class="btn btn-secondary small-btn ms-2" on:click={() => irParaPagina(paginaAtual + 1)} disabled={paginaAtual === totalDePaginas}>
    Próxima
  </button>
</div>
    </div>
  </div>

  {#if mostrarModalEdicao}
  <Modal on:close={fecharModalEdicao}>
    <h2 class="text-center fw-bold">Editar Tarefa</h2>

    <div class="mb-3 d-flex align-items-center">
      <label class="form-label me-2">ID:</label>
      <input type="text" class="form-control w-75" bind:value={tarefaAtual.id} disabled />
    </div>

    <div class="mb-3 d-flex align-items-center">
      <label class="form-label me-2">Título:</label>
      <input type="text" class="form-control w-75" bind:value={tarefaAtual.nm} placeholder="Nome" />
    </div>

    <div class="mb-3 d-flex align-items-center">
      <label class="form-label me-2">Descrição:</label>
      <input type="text" class="form-control w-75" bind:value={tarefaAtual.nm_descricao} placeholder="Descrição" />
    </div>

    <div class="mb-3 d-flex align-items-center">
      <label class="form-label me-2">Status:</label>
      <select class="form-select w-75" bind:value={tarefaAtual.statustarefa_id}>
        {#each Object.entries(statusOptions) as [value, label]}
            <option value={value}>{label}</option>
        {/each}
    </select>
    </div>

    <!-- Centralizando os botões -->
    <div class="d-flex justify-content-center">
      <button class="btn btn-primary small-btn w-50 mb-2" on:click={atualizarTarefa}>Salvar</button>
    </div>
    <div class="d-flex justify-content-center">
      <button class="btn btn-danger small-btn w-50" on:click={excluirTarefa}>Excluir</button>
    </div>
  </Modal>

{/if}

{#if mostrarModalCriacao}
  <Modal on:close={fecharModalCriacao}>
      <h2 class="text-center fw-bold">Criar Nova Tarefa</h2>
      <div class="mb-3">
        <input type="text" class="form-control" bind:value={novaTarefa.nm} placeholder="Nome" />
      </div>
      <div class="mb-3">
        <input type="text" class="form-control" bind:value={novaTarefa.nm_descricao} placeholder="Descrição" />
      </div>
      <div class="d-flex justify-content-center">
        <button class="btn btn-primary small-btn w-50" on:click={criarTarefa}>Criar</button>
      </div>  </Modal>
{/if}
