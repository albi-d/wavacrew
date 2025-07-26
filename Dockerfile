# Gunakan image resmi PHP dengan ekstensi yang dibutuhkan
FROM php:8.2-fpm

# Install dependensi sistem dan ekstensi PHP
RUN apt-get update && apt-get install -y \
    git curl zip unzip nodejs npm libzip-dev libpng-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo pdo_mysql zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set direktori kerja
WORKDIR /var/www

# Salin semua file ke dalam container
COPY . .

# Install dependensi PHP Laravel
RUN composer install --optimize-autoloader --no-dev

# Install dependensi frontend Vite
RUN npm install && npm run build

# Set permission
RUN chown -R www-data:www-data /var/www \
    && chmod -R 755 /var/www/storage

# Laravel akan dijalankan di port 8080 (agar cocok dengan Railway)
EXPOSE 8080

# Jalankan Laravel menggunakan built-in server
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8080"]
