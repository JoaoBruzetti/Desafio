<script>
    let email = '';
    let password = '';
    const apiUrl = import.meta.env.VITE_API_URL;

    async function login() {
      try {
        const response = await fetch(apiUrl + `api/login`, {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ email, password })
        });

        if (response.ok) {
          const data = await response.json();
          localStorage.setItem('jwt_token', data.token);
          window.location.href = '/home';
        } else {
          alert('Login inválido');
        }
      } catch (error) {
        console.error('Erro no login:', error);
        alert('Erro ao tentar fazer login');
      }
    }
  </script>

  <form on:submit|preventDefault={login}>
    <label>Email:</label>
    <input type="email" bind:value={email} required />
    <label>Senha:</label>
    <input type="password" bind:value={password} required />
    <button type="submit">Entrar</button>
  </form>
