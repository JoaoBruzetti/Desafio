# Desafio

**Tempo gasto: 10 horas**

Recomendavel fazer deploy utilizando o codespaces do github

1. Rodar comando para subir containers

    **`docker compose up -d --build`**

2. Entrar no container do laravel

    **`docker compose exec php bash`**

3. Gerar .env

    **`cp .env.example .env`**

4. Rodar composer install

    **`composer install`**

5. Gerar chave

    **`php artisan key:generate`**

6. Gerar jwt

    **`php artisan jwt:secret`**

7. Rodar migrations

    **`php artisan migrate`**

8. Sair do container e entrar no projeto frontend

    **`exit`**
    **`cd frontend/`**

9. Criar arquivo .env

    **`touch .env`**

10. Deixar porta do container php (porta 80) como publica (caso esteja no codespaces acessar aba de portas -> botão direito na porta 80 -> visibilidade da porta -> public) copiar url da porta e adicionar variavel no .env

    **`VITE_API_URL=URL_CONTAINER_PHP`**

11. Rodar npm install

    **`npm install`**

12. Rodar frontend

    **`npm run dev`**

13. Abrir url gerada no navegador
