<script>
    import { createEventDispatcher } from 'svelte';

    const dispatch = createEventDispatcher();

    // Emite o evento de fechar quando clicado fora do modal
    function fecharModal() {
      dispatch('close');
    }
  </script>

  <div class="modal-overlay" on:click={fecharModal}>
    <div class="modal-content" on:click|stopPropagation>
      <slot></slot>
    </div>
  </div>

  <style>
  .modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
  }

    .modal-content {
        background: white;
        padding: 20px;
        border-radius: 5px;
        width: 700px;
        margin: auto;
    }
  </style>
