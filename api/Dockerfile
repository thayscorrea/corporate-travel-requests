FROM php:8.2-fpm

# Instala dependências do sistema
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl

# Instala extensões PHP necessárias
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Instala Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Define o diretório de trabalho
WORKDIR /var/www

# Copia os arquivos do aplicativo
COPY . .

# Instala as dependências do Composer
RUN composer install --no-scripts --no-autoloader

# Gera autoload
RUN composer dump-autoload --optimize

# Define permissões
RUN chown -R www-data:www-data /var/www
RUN chmod -R 755 /var/www

# Expõe a porta 9000 e inicia o PHP-FPM
EXPOSE 9000
CMD ["php-fpm"]
