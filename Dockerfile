FROM php:8.2-fpm-alpine

# 1. Install Composer & Unzip (syarat wajib Laravel)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN apk add --no-cache nginx git unzip

# 2. Install Ekstensi Database
RUN docker-php-ext-install pdo pdo_mysql

# 3. Masukkan Config Nginx
COPY .docker/nginx.conf /etc/nginx/nginx.conf

# 4. UBAH NAMA FOLDER KERJA JADI HAFIZH
WORKDIR /var/www/hafizh_absen15
COPY . .

# 5. Install folder vendor (Library Laravel)
RUN composer install --no-dev --optimize-autoloader

# 6. Duplikat file .env & Generate Key Keamanan
RUN php artisan key:generate

# 7. Beri Izin Akses
RUN chmod -R 777 storage bootstrap/cache

EXPOSE 80
CMD php-fpm -D && nginx -g "daemon off;"