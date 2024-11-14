<script>
    let email = '';
    let password = '';
    const apiUrl = import.meta.env.VITE_API_URL;

    async function login() {
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
    }
  </script>

  <div class="d-flex justify-content-center align-items-center vh-100">
    <form class="p-4 border rounded shadow-sm" style="width: 100%; max-width: 400px;" on:submit|preventDefault={login}>
      <h2 class="text-center mb-4 fw-bold">Login Tarefas</h2>
      <div class="mb-3">
        <label for="email" class="form-label">Email:</label>
        <input id="email" type="email" class="form-control" bind:value={email} required />
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Senha:</label>
        <input id="password" type="password" class="form-control" bind:value={password} required />
      </div>
      <button type="submit" class="btn btn-primary w-100">Entrar</button>
    </form>
  </div>
