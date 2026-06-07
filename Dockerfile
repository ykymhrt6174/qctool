FROM php:8.4-cli

WORKDIR /var/www

# PHP関連
RUN apt-get update && apt-get install -y \
    git unzip curl libzip-dev \
    && docker-php-ext-install zip pdo pdo_mysql

# Node.js導入
RUN curl -fsSL https://deb.nodesource.com/setup_22.x | bash - \
    && apt-get install -y nodejs

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

COPY . .

# Laravel依存
RUN composer install --no-dev --optimize-autoloader

# フロントエンド依存
RUN npm install

# Viteビルド
RUN npm run build

EXPOSE 10000

CMD ["sh", "-c", "php artisan config:clear && php artisan cache:clear && php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=${PORT:-10000}"]