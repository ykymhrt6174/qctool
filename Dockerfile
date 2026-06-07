FROM php:8.4-cli

WORKDIR /var/www

RUN apt-get update && apt-get install -y \
    git unzip curl libzip-dev \
    && docker-php-ext-install zip pdo pdo_mysql

RUN curl -fsSL https://deb.nodesource.com/setup_22.x | bash - \
    && apt-get install -y nodejs

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

COPY . .

RUN composer install --no-dev --optimize-autoloader

RUN npm install
RUN npm run build

EXPOSE 10000

CMD ["sh", "-c", "\
php artisan migrate --force && \
php artisan db:seed --force || true && \
php artisan serve --host=0.0.0.0 --port=${PORT:-10000} \
"]