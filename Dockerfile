FROM php:8.2-apache

# Dependências do sistema
RUN apt-get update && apt-get install -y --no-install-recommends \
    git unzip zip \
    default-mysql-client \
    libzip-dev \
    libpng-dev libjpeg62-turbo-dev libfreetype6-dev \
    libicu-dev \
  && rm -rf /var/lib/apt/lists/*

# Extensões PHP
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
  && docker-php-ext-install -j$(nproc) \
    mysqli \
    pdo \
    pdo_mysql \
    zip \
    gd \
    intl \
    opcache

# Apache
RUN a2enmod rewrite headers \
  && echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Permitir .htaccess
RUN sed -i 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf

# Copia os arquivos do projeto
COPY ./www/ /var/www/html/

# Permissões
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80