# Desafio

**Tempo gasto: 10 horas**

Recomendavel fazer deploy utilizando o codespaces do github

1. Rodar comando para subir containers

    **`docker compose up -d --build`**

2. Entrar no container do laravel

    **`docker compose exec php bash`**

3. Gerar .env

    **`cp .env.example .env`**

4. Gerar chave

    **`php artisan key:generate`**

5. Gerar jwt

    **`php artisan jwt:secret`**

6. Rodar migrations

    **`php artisan migrate`**

7. Sair do container e entrar no projeto frontend

    **`exit`**
    **`cd frontend/`**

8. Criar arquivo .env

    **`touch .env`**

9. Deixar porta do container php como publica (caso esteja no codespaces acessar aba de portas -> visibilidade da porta -> public) copiar url da porta e adicionar variavel no .env

    **`VITE_API_URL=URL_CONTAINER_PHP`**

10. Rodar frontend

    **`npm run dev`**

11. Abrir url gerada no navegador
