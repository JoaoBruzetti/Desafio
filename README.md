# Desafio

**Tempo gasto: 6 horas**

Recomendavel fazer deploy utilizando o codespaces do github

1. Rodar comando para subir containers

    **`docker compose up -d`**

2. Entrar no container do laravel

    **`docker compose exec php bash`**

3. Gerar .env

    **`cp .env.example .env`**

4. Composer install

    **`composer install`**

5. Gerar chave

    **`php artisan key:generate`**

6. Gerar jwt

    **`php artisan jwt:secret`**

7. Rodar migrations

    **`php artisan migrate`**
