FROM mcr.microsoft.com/vscode/devcontainers/php:8.1

RUN apt-get update && apt-get install -y \
    php-mysql \
    php-xml \
    php-mbstring \
    && apt-get clean -y

WORKDIR /workspace
