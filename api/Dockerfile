# Usar imagem base do PHP
FROM php:8.2-fpm

# Instalar dependências do sistema
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev \
    libcurl4-openssl-dev \
    libssl-dev \
    libonig-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev

# Instalar extensões do PHP necessárias para Laravel
RUN docker-php-ext-install \
    pdo_mysql \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd \
    zip

# Instalar o Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Limpar o cache do Composer
RUN composer clear-cache

# Definir diretório de trabalho
WORKDIR /var/www

# Copiar os arquivos do projeto
COPY . .

# Instalar dependências do Laravel
RUN composer install --no-dev --optimize-autoloader

# Configurar permissões para o diretório de trabalho
RUN chown -R www-data:www-data /var/www && chmod -R 755 /var/www

# Expor a porta
EXPOSE 9000

# Comando padrão do container
CMD ["php-fpm"]
