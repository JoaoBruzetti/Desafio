# Desafio

**Tempo gasto: 6 horas**

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
