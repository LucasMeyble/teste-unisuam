FROM php:8.2-fpm

# Variáveis para UID e GID do host (evita problemas de permissão no WSL2)
ARG UID=1000
ARG GID=1000

# Criar grupo e usuário com mesmos UID/GID do host
RUN groupadd -g ${GID} laravelgroup \
    && useradd -u ${UID} -g laravelgroup -m laravel

# Instalar dependências
RUN apt-get update && apt-get install -y \
    git unzip curl zip libzip-dev \
    libonig-dev libxml2-dev libpq-dev libpng-dev \
    libcurl4-openssl-dev libssl-dev libicu-dev zlib1g-dev \
    && docker-php-ext-install pdo pdo_pgsql zip intl

# Instalar Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Definir diretório de trabalho
WORKDIR /var/www

# Copiar arquivos da aplicação (se houver)
COPY . .

# Corrigir permissões se as pastas existirem
RUN mkdir -p /var/www/storage /var/www/bootstrap/cache && \
    chown -R laravel:laravelgroup /var/www && \
    chmod -R 775 /var/www/storage /var/www/bootstrap/cache || true

# Trocar para o usuário criado
USER laravel

# Comando padrão do container
CMD if [ -f artisan ]; then \
      composer install && \
      php artisan serve --host=0.0.0.0 --port=8000; \
    else \
      echo "Laravel ainda não instalado. Use 'docker compose exec backend composer create-project laravel/laravel .'" && tail -f /dev/null; \
    fi
