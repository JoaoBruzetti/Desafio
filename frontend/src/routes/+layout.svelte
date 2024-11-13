<script>
    import { onMount } from 'svelte';

    onMount(() => {
      const token = localStorage.getItem('jwt_token');
      if (!token && window.location.pathname !== '/login') {
        window.location.href = '/login';
      }
    });
  </script>

  <slot />
