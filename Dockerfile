FROM php:8.2-fpm-alpine
RUN docker-php-ext-install pdo pdo_mysql
RUN apk add --no-cache nginx
COPY .docker/nginx.conf /etc/nginx/nginx.conf
WORKDIR /var/www/budi_absen12
COPY . .
RUN chmod -R 777 storage bootstrap/cache
EXPOSE 80
CMD php-fpm -D && nginx -g "daemon off;"