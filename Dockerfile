# =================================================================
# Stage 1: Build front-end assets (SUDAH DIPERBAIKI)
# =================================================================
FROM node:18-alpine AS node-builder
WORKDIR /app

# Salin file package untuk caching
COPY package*.json ./

# Install node dependencies
RUN npm install

# Salin SEMUA file proyek. Ini memastikan semua file konfigurasi (vite, postcss, tailwind)
# dan source code (resources/js) tersedia untuk proses build.
COPY . .

# Jalankan build. Sekarang, build akan berjalan dengan semua file yang diperlukan.
RUN npm run build

# =================================================================
# Stage 2: PHP Runtime dengan Apache (Lingkungan Produksi)
# =================================================================
FROM php:8.1-apache

ENV DEBIAN_FRONTEND=noninteractive

# Install system dependencies & PHP extensions (Tidak ada perubahan)
RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev zip unzip libzip-dev gnupg2 \
    && rm -rf /var/lib/apt/lists/* \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd xml zip

# Install Composer (Tidak ada perubahan)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install Microsoft ODBC Driver & SQL Server extensions (Tidak ada perubahan)
RUN curl -fsSL https://packages.microsoft.com/keys/microsoft.asc | gpg --dearmor -o /etc/apt/keyrings/microsoft.gpg \
    && echo "deb [arch=amd64 signed-by=/etc/apt/keyrings/microsoft.gpg] https://packages.microsoft.com/debian/11/prod bullseye main" > /etc/apt/sources.list.d/mssql-release.list \
    && apt-get update \
    && ACCEPT_EULA=Y apt-get install -y msodbcsql18 mssql-tools18 unixodbc-dev \
    && rm -rf /var/lib/apt/lists/* \
    && pecl install sqlsrv pdo_sqlsrv \
    && docker-php-ext-enable sqlsrv pdo_sqlsrv

# Set working directory
WORKDIR /var/www/html

# Salin file composer dan install dependencies tanpa menjalankan skrip
COPY composer.json composer.lock ./
RUN composer install --no-interaction --no-scripts --optimize-autoloader

# Salin semua file aplikasi
COPY . .

COPY --from=node-builder /app/public/build ./public/build

RUN cp .env.example .env \
    && php artisan key:generate --ansi \
    && php artisan config:clear \
    && php artisan route:clear \
    && php artisan view:clear \
    && php artisan route:cache \
    && php artisan view:cache \
    && chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# =================================================================
# Konfigurasi Final Server & Entrypoint
# =================================================================
# Salin konfigurasi PHP kustom
COPY docker/php.ini /usr/local/etc/php/conf.d/custom.ini

# --- BAGIAN PERUBAHAN UTAMA DI SINI ---

# Aktifkan mod_rewrite Apache
RUN a2enmod rewrite

# Nonaktifkan default site (jika ada) dan file ports.conf default Apache
# Ini untuk menghindari konflik dengan konfigurasi kustom kita
RUN a2dissite 000-default.conf || true \
    && a2disconf ports || true

# Salin file konfigurasi VirtualHost Laravel kustom
COPY docker/laravel-vhost.conf /etc/apache2/sites-available/laravel.conf

# Aktifkan situs Laravel yang baru
RUN a2ensite laravel.conf

# --- AKHIR BAGIAN PERUBAHAN ---

# Biarkan CMD default dari base image php:apache yang akan berjalan
EXPOSE 8080
